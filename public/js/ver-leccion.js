document.addEventListener('DOMContentLoaded', () => {
    const leccionId = window.LECCION_ID;
    const cursoId = window.CURSO_ID;
    
    if (!leccionId || !cursoId) {
        alert('Error: Datos de lección no encontrados');
        window.location.href = '/mis-cursos';
        return;
    }
    
    cargarDatosLeccion(leccionId, cursoId);
});

/**
 * Carga los datos de la lección desde la API
 */
function cargarDatosLeccion(leccionId, cursoId) {
    const token = localStorage.getItem('jwt_token');
    
    if (!token) {
        alert('Debes iniciar sesión');
        window.location.href = '/login';
        return;
    }
    
    fetch(`/api/lecciones/${leccionId}/datos`, {
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
        
        if (response.status === 403) {
            alert('No estás inscrito en este curso');
            window.location.href = '/mis-cursos';
            return null;
        }
        
        if (response.status === 404) {
            alert('Lección no encontrada');
            window.location.href = `/mis-cursos/${cursoId}`;
            return null;
        }
        
        if (!response.ok) {
            // Intentar obtener el mensaje de error del servidor
            return response.json().then(errorData => {
                console.error('Error del servidor:', errorData);
                throw new Error(errorData.message || 'Error al cargar la lección');
            }).catch(() => {
                throw new Error(`Error del servidor (${response.status})`);
            });
        }
        
        return response.json();
    })
    .then(data => {
        if (!data) return;
        
        console.log('Datos de la lección:', data);
        renderizarLeccion(data, cursoId);
        
        // Ocultar spinner y mostrar contenido
        document.getElementById('loading-spinner').style.display = 'none';
        document.getElementById('lesson-content').style.display = 'block';
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cargar la lección: ' + error.message);
        window.location.href = `/mis-cursos/${cursoId}`;
    });
}

/**
 * Renderiza los datos de la lección en la página
 */
function renderizarLeccion(leccion, cursoId) {
    // Actualizar título de la página
    document.title = `${leccion.titulo} - ${leccion.curso_titulo}`;
    
    // Breadcrumb
    const breadcrumbCurso = document.getElementById('breadcrumb-curso');
    breadcrumbCurso.textContent = leccion.curso_titulo;
    breadcrumbCurso.href = `/mis-cursos/${cursoId}`;
    
    document.getElementById('breadcrumb-modulo').textContent = leccion.modulo_titulo;
    
    // Header
    document.getElementById('lesson-title').textContent = leccion.titulo;
    
    // Mostrar tipo de lección y duración
    let tipoIcono = 'fa-book';
    switch(leccion.tipo) {
        case 'video': tipoIcono = 'fa-video'; break;
        case 'texto': tipoIcono = 'fa-file-alt'; break;
        case 'quiz': tipoIcono = 'fa-question-circle'; break;
        case 'recurso': tipoIcono = 'fa-folder'; break;
    }
    
    document.getElementById('lesson-module').innerHTML = `
        <i class="fas ${tipoIcono} me-2"></i>${leccion.tipo.toUpperCase()} - ${leccion.modulo_titulo}
        ${leccion.duracion ? `<span class="ms-3"><i class="fas fa-clock me-2"></i>${leccion.duracion} min</span>` : ''}
    `;
    
    // Contenido principal (sin descripción separada, solo contenido)
    const descContainer = document.getElementById('lesson-description');
    descContainer.style.display = 'none'; // Ocultar sección de descripción
    
    const contentContainer = document.getElementById('lesson-main-content');
    if (leccion.contenido) {
        contentContainer.innerHTML = `
            <h4><i class="fas fa-file-alt me-2 text-primary"></i>Contenido</h4>
            <div class="content-text">${leccion.contenido}</div>
        `;
    }
    
    // Recursos
    renderizarRecursos(leccion.recursos || []);
    
    // Botón de completar
    const btnCompletar = document.getElementById('btn-completar');
    const btnVolverCurso = document.getElementById('btn-volver-curso');
    
    btnVolverCurso.href = `/mis-cursos/${cursoId}`;
    
    if (leccion.completada) {
        btnCompletar.classList.add('completed');
        btnCompletar.innerHTML = '<i class="fas fa-check-circle me-2"></i>Lección Completada';
        btnCompletar.disabled = true;
    } else {
        btnCompletar.addEventListener('click', () => marcarComoCompletada(leccion.id_leccion, cursoId));
    }
    
    // Navegación
    configurarNavegacion(leccion, cursoId);
}

/**
 * Renderiza los recursos de la lección
 */
function renderizarRecursos(recursos) {
    const container = document.getElementById('resources-container');
    
    if (!recursos || recursos.length === 0) {
        container.innerHTML = `
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Sin recursos adicionales</strong><br>
                <small>Esta lección no tiene videos, PDFs o enlaces adjuntos. El contenido principal está en la descripción de arriba.</small>
            </div>
        `;
        return;
    }
    
    const recursosHTML = recursos.map(recurso => {
        let html = '';
        let iconClass = 'fa-file';
        let colorClass = 'resource-card';
        let badgeColor = 'secondary';
        
        switch(recurso.tipo) {
            case 'video':
                iconClass = 'fa-video';
                colorClass += ' resource-video';
                badgeColor = 'danger';
                html = renderizarVideo(recurso);
                break;
            case 'pdf':
                iconClass = 'fa-file-pdf';
                colorClass += ' resource-pdf';
                badgeColor = 'warning';
                html = renderizarPDF(recurso);
                break;
            case 'link':
                iconClass = 'fa-link';
                colorClass += ' resource-link';
                badgeColor = 'info';
                html = renderizarEnlace(recurso);
                break;
            case 'imagen':
                iconClass = 'fa-image';
                colorClass += ' resource-imagen';
                badgeColor = 'success';
                html = renderizarImagen(recurso);
                break;
        }
        
        return `
            <div class="${colorClass}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="fas ${iconClass} me-2"></i>
                        ${recurso.titulo}
                    </h5>
                    <span class="badge bg-${badgeColor}">${recurso.tipo.toUpperCase()}</span>
                </div>
                ${html}
            </div>
        `;
    }).join('');
    
    container.innerHTML = recursosHTML;
}

/**
 * Renderiza un recurso de video
 */
function renderizarVideo(recurso) {
    // Detectar si es YouTube, Vimeo u otro
    let embedUrl = recurso.url;
    
    if (recurso.url.includes('youtube.com') || recurso.url.includes('youtu.be')) {
        const videoId = extraerYouTubeId(recurso.url);
        embedUrl = `https://www.youtube.com/embed/${videoId}`;
    } else if (recurso.url.includes('vimeo.com')) {
        const videoId = recurso.url.split('/').pop();
        embedUrl = `https://player.vimeo.com/video/${videoId}`;
    }
    
    return `
        <div class="video-container">
            <iframe 
                src="${embedUrl}" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
            </iframe>
        </div>
    `;
}

/**
 * Renderiza un recurso PDF
 */
function renderizarPDF(recurso) {
    // Si la URL no comienza con http/https, agregar el prefijo /storage/
    let pdfUrl = recurso.url;
    if (!pdfUrl.startsWith('http://') && !pdfUrl.startsWith('https://')) {
        pdfUrl = `/storage/${pdfUrl}`;
    }
    
    return `
        <div class="mb-3">
            <iframe src="${pdfUrl}" class="pdf-viewer"></iframe>
        </div>
        <a href="${pdfUrl}" target="_blank" class="btn btn-warning">
            <i class="fas fa-download me-2"></i>
            Descargar PDF
        </a>
    `;
}

/**
 * Renderiza un enlace externo
 */
function renderizarEnlace(recurso) {
    return `
        <p class="text-muted mb-3">Enlace a recurso externo</p>
        <a href="${recurso.url}" target="_blank" class="btn btn-info">
            <i class="fas fa-external-link-alt me-2"></i>
            Abrir Enlace
        </a>
    `;
}

/**
 * Renderiza una imagen
 */
function renderizarImagen(recurso) {
    // Si la URL no comienza con http/https, agregar el prefijo /storage/
    let imagenUrl = recurso.url;
    if (!imagenUrl.startsWith('http://') && !imagenUrl.startsWith('https://')) {
        imagenUrl = `/storage/${imagenUrl}`;
    }
    
    return `
        <img src="${imagenUrl}" class="img-fluid rounded" alt="${recurso.titulo}">
    `;
}

/**
 * Extrae el ID de un video de YouTube
 */
function extraerYouTubeId(url) {
    const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
    const match = url.match(regExp);
    return (match && match[2].length === 11) ? match[2] : null;
}

/**
 * Marca la lección como completada
 */
function marcarComoCompletada(leccionId, cursoId) {
    const token = localStorage.getItem('jwt_token');
    const btnCompletar = document.getElementById('btn-completar');
    
    btnCompletar.disabled = true;
    btnCompletar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Procesando...';
    
    fetch(`/api/lecciones/${leccionId}/completar`, {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            btnCompletar.classList.add('completed');
            btnCompletar.innerHTML = '<i class="fas fa-check-circle me-2"></i>Lección Completada';
            
            // Mostrar mensaje de éxito
            mostrarNotificacion('¡Felicidades! Lección completada', 'success');
            
            // Actualizar progreso si está disponible
            if (data.progreso) {
                console.log('Progreso actualizado:', data.progreso);
            }
        } else {
            throw new Error(data.error || 'Error al completar la lección');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        btnCompletar.disabled = false;
        btnCompletar.innerHTML = '<i class="fas fa-check-circle me-2"></i>Marcar como Completada';
        mostrarNotificacion('Error al completar la lección: ' + error.message, 'danger');
    });
}

/**
 * Configura la navegación entre lecciones
 */
function configurarNavegacion(leccion, cursoId) {
    const btnAnterior = document.getElementById('btn-anterior');
    const btnSiguiente = document.getElementById('btn-siguiente');
    
    if (leccion.leccion_anterior) {
        btnAnterior.style.display = 'block';
        btnAnterior.textContent = '';
        btnAnterior.innerHTML = `<i class="fas fa-arrow-left me-2"></i>${leccion.leccion_anterior.titulo}`;
        btnAnterior.addEventListener('click', () => {
            window.location.href = `/mis-cursos/${cursoId}/leccion/${leccion.leccion_anterior.id_leccion}`;
        });
    }
    
    if (leccion.leccion_siguiente) {
        btnSiguiente.style.display = 'block';
        btnSiguiente.textContent = '';
        btnSiguiente.innerHTML = `${leccion.leccion_siguiente.titulo}<i class="fas fa-arrow-right ms-2"></i>`;
        btnSiguiente.addEventListener('click', () => {
            window.location.href = `/mis-cursos/${cursoId}/leccion/${leccion.leccion_siguiente.id_leccion}`;
        });
    }
}

/**
 * Muestra una notificación temporal
 */
function mostrarNotificacion(mensaje, tipo = 'info') {
    const alert = document.createElement('div');
    alert.className = `alert alert-${tipo} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
    alert.style.zIndex = '9999';
    alert.innerHTML = `
        ${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.remove();
    }, 5000);
}
