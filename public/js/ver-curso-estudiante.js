document.addEventListener('DOMContentLoaded', () => {
    const cursoId = getCursoIdFromURL();
    if (!cursoId) {
        alert('Error: ID de curso no encontrado');
        window.location.href = '/mis-cursos';
        return;
    }
    
    cargarDatosCurso(cursoId);
});

/**
 * Obtiene el ID del curso desde la URL
 */
function getCursoIdFromURL() {
    const path = window.location.pathname;
    const matches = path.match(/\/mis-cursos\/(\d+)/);
    return matches ? matches[1] : null;
}

/**
 * Carga los datos del curso desde la API
 */
function cargarDatosCurso(cursoId) {
    const token = localStorage.getItem('jwt_token');
    
    if (!token) {
        alert('Debes iniciar sesión');
        window.location.href = '/login';
        return;
    }
    
    fetch(`/api/mis-cursos/${cursoId}/datos`, {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (response.status === 401) {
            localStorage.removeItem('jwt_token');
            alert('Tu sesión ha expirado. Por favor, inicia sesión nuevamente.');
            window.location.href = '/login';
            return null;
        }
        
        if (response.status === 404) {
            alert('Curso no encontrado o no estás inscrito');
            window.location.href = '/mis-cursos';
            return null;
        }
        
        if (!response.ok) {
            throw new Error('Error al cargar el curso');
        }
        
        return response.json();
    })
    .then(data => {
        if (!data) return;
        
        console.log('Datos del curso:', data);
        renderizarCurso(data);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cargar el curso: ' + error.message);
        window.location.href = '/mis-cursos';
    });
}

/**
 * Renderiza los datos del curso en la página
 */
function renderizarCurso(curso) {
    // Ocultar spinner y mostrar contenido
    const spinner = document.getElementById('loading-spinner');
    const content = document.getElementById('course-content');
    
    if (spinner) spinner.style.display = 'none';
    if (content) content.style.display = 'block';
    
    // Actualizar título de la página
    document.title = `${curso.titulo} - Mi Curso`;
    
    // Actualizar header del curso
    const headerTitle = document.getElementById('curso-titulo');
    const headerDescripcion = document.getElementById('curso-descripcion');
    const headerImagen = document.getElementById('curso-imagen');
    
    if (headerTitle) headerTitle.textContent = curso.titulo;
    if (headerDescripcion) headerDescripcion.textContent = curso.descripcion || 'Sin descripción';
    if (headerImagen && curso.imagen_url) headerImagen.src = curso.imagen_url;
    
    // Actualizar estadísticas
    const totalModulos = document.getElementById('total-modulos');
    const totalLecciones = document.getElementById('total-lecciones');
    const leccionesCompletadas = document.getElementById('lecciones-completadas');
    const progresoPorcentaje = document.getElementById('progreso-porcentaje');
    const progresoBar = document.getElementById('progreso-bar');
    
    if (totalModulos) totalModulos.textContent = curso.totalModulos || 0;
    if (totalLecciones) totalLecciones.textContent = curso.totalLecciones || 0;
    if (leccionesCompletadas) leccionesCompletadas.textContent = curso.leccionesCompletadas || 0;
    if (progresoPorcentaje) progresoPorcentaje.textContent = `${curso.progresoCalculado || 0}%`;
    if (progresoBar) {
        progresoBar.style.width = `${curso.progresoCalculado || 0}%`;
        progresoBar.setAttribute('aria-valuenow', curso.progresoCalculado || 0);
    }
    
    // Renderizar módulos
    renderizarModulos(curso.modulos || []);
}

/**
 * Renderiza los módulos y lecciones
 */
function renderizarModulos(modulos) {
    const container = document.getElementById('modulos-container');
    
    if (!container) {
        console.error('Contenedor de módulos no encontrado');
        return;
    }
    
    if (!modulos || modulos.length === 0) {
        container.innerHTML = `
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Este curso aún no tiene módulos disponibles.
            </div>
        `;
        return;
    }
    
    const modulosHTML = modulos.map((modulo, index) => `
        <div class="card mb-3 module-card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-book me-2"></i>
                    Módulo ${index + 1}: ${modulo.titulo}
                </h5>
                <span class="badge bg-light text-dark">${modulo.lecciones ? modulo.lecciones.length : 0} lecciones</span>
            </div>
            <div class="card-body">
                ${modulo.descripcion ? `<p class="text-muted">${modulo.descripcion}</p>` : ''}
                ${renderizarLecciones(modulo.lecciones || [], modulo.id_modulo)}
            </div>
        </div>
    `).join('');
    
    container.innerHTML = modulosHTML;
}

/**
 * Renderiza las lecciones de un módulo
 */
function renderizarLecciones(lecciones, moduloId) {
    if (!lecciones || lecciones.length === 0) {
        return '<p class="text-muted fst-italic">No hay lecciones en este módulo.</p>';
    }
    
    const cursoId = getCursoIdFromURL();
    
    const leccionesHTML = lecciones.map((leccion, index) => `
        <div class="lesson-item mb-2 p-3 border rounded ${leccion.completada ? 'bg-light' : ''}">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">
                        ${leccion.completada ? '<i class="fas fa-check-circle text-success me-2"></i>' : '<i class="far fa-circle text-muted me-2"></i>'}
                        Lección ${index + 1}: ${leccion.titulo}
                    </h6>
                    ${leccion.descripcion ? `<p class="mb-0 small text-muted">${leccion.descripcion}</p>` : ''}
                </div>
                <div>
                    ${leccion.completada 
                        ? '<span class="badge bg-success">Completada</span>' 
                        : `<button class="btn btn-sm btn-primary" onclick="abrirLeccion(${cursoId}, ${leccion.id_leccion})"><i class="fas fa-play me-1"></i>Comenzar</button>`
                    }
                </div>
            </div>
            ${leccion.recursos && leccion.recursos.length > 0 ? renderizarRecursos(leccion.recursos) : ''}
        </div>
    `).join('');
    
    return `<div class="lessons-list">${leccionesHTML}</div>`;
}

/**
 * Renderiza los recursos de una lección
 */
function renderizarRecursos(recursos) {
    const recursosHTML = recursos.map(recurso => {
        let icono = 'fa-file';
        let colorClass = 'text-primary';
        
        switch(recurso.tipo_recurso) {
            case 'video':
                icono = 'fa-video';
                colorClass = 'text-danger';
                break;
            case 'pdf':
                icono = 'fa-file-pdf';
                colorClass = 'text-danger';
                break;
            case 'enlace':
                icono = 'fa-link';
                colorClass = 'text-info';
                break;
            case 'documento':
                icono = 'fa-file-word';
                colorClass = 'text-primary';
                break;
        }
        
        return `
            <a href="${recurso.url_recurso}" target="_blank" class="btn btn-sm btn-outline-secondary me-2 mb-2">
                <i class="fas ${icono} ${colorClass} me-1"></i>
                ${recurso.titulo}
            </a>
        `;
    }).join('');
    
    return `
        <div class="mt-2 pt-2 border-top">
            <small class="text-muted d-block mb-2"><i class="fas fa-paperclip me-1"></i>Recursos:</small>
            ${recursosHTML}
        </div>
    `;
}

/**
 * Abre una lección
 */
function abrirLeccion(cursoId, leccionId) {
    console.log('Abriendo lección:', leccionId, 'del curso:', cursoId);
    window.location.href = `/mis-cursos/${cursoId}/leccion/${leccionId}`;
}

// Hacer funciones globales
window.abrirLeccion = abrirLeccion;
