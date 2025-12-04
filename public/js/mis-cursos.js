document.addEventListener('DOMContentLoaded', () => {
    verificarAutenticacion();
    cargarMisCursos();
});

/**
 * Verifica si el usuario tiene un token JWT válido
 */
function verificarAutenticacion() {
    const token = localStorage.getItem('jwt_token');
    
    if (!token) {
        alert(' Debes iniciar sesión para ver tus cursos');
        window.location.href = '/login';
        return false;
    }
    
    try {
        const payload = JSON.parse(atob(token.split('.')[1]));
        if (payload.id_rol !== 2) { // 2 = estudiante
            alert('Esta vista es solo para estudiantes');
            window.location.href = '/catalogo-privado';
            return false;
        }
    } catch (error) {
        alert('Token inválido. Por favor, inicia sesión nuevamente');
        window.location.href = '/login';
        return false;
    }
    
    return true;
}

/**
 * Carga los cursos en los que está inscrito el usuario
 */
function cargarMisCursos() {
    const token = localStorage.getItem('jwt_token');
    const container = document.getElementById('mis-cursos-container');

    fetch('/api/mis-cursos', {
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
            alert('⚠️ Tu sesión ha expirado. Por favor, inicia sesión nuevamente.');
            window.location.href = '/login';
            return null;
        }
        
        if (!response.ok) {
            throw new Error('Error al cargar tus cursos: ' + response.status);
        }
        
        return response.json();
    })
    .then(data => {
        if (!data) return;

        console.log('Mis cursos:', data);
        
        // DEBUG: Verificar que cada curso tenga id_curso
        data.forEach(curso => {
            console.log('Curso:', curso.titulo, 'ID:', curso.id_curso);
        });

        if (!data || data.length === 0) {
            container.innerHTML = `
                <div class="col-12 text-center py-5">
                    <i class="fas fa-graduation-cap fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">No tienes cursos</h4>
                    <p class="text-muted">Aún no te has inscrito en ningún curso.</p>
                    <a href="/catalogo-privado" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>
                        Explorar Cursos
                    </a>
                </div>
            `;
            return;
        }

        // Generar las tarjetas de cursos
        const cursosHTML = data.map(curso => {
            const imagenUrl = curso.imagen_url || 'https://via.placeholder.com/400x200?text=Sin+Imagen';

            // Calcular progreso (si está disponible)
            const progreso = curso.progreso || 0;
            const progresoBarColor = progreso === 100 ? 'bg-success' : 
                                   progreso >= 50 ? 'bg-warning' : 'bg-info';

            return `
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card curso-card h-100 shadow-sm">
                        <div class="position-relative">
                            <img src="${imagenUrl}" alt="${curso.titulo}" class="card-img-top curso-img">
                            <div class="progreso-overlay">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar ${progresoBarColor}" 
                                         role="progressbar" 
                                         style="width: ${progreso}%" 
                                         aria-valuenow="${progreso}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                    </div>
                                </div>
                                <small class="text-white mt-1 d-block">${Math.round(progreso)}% completado</small>
                            </div>
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary">${curso.titulo}</h5>
                            <p class="card-text text-muted flex-grow-1">
                                ${curso.descripcion || 'Sin descripción disponible'}
                            </p>
                            
                            <div class="curso-stats mb-3">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <div class="stat-item">
                                            <i class="fas fa-clock text-info"></i>
                                            <small class="d-block text-muted">Duración</small>
                                            <span class="fw-bold">${curso.duracion || 'N/A'}</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stat-item">
                                            <i class="fas fa-signal text-success"></i>
                                            <small class="d-block text-muted">Nivel</small>
                                            <span class="fw-bold">${curso.nivel || 'N/A'}</span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stat-item">
                                            <i class="fas fa-star text-warning"></i>
                                            <small class="d-block text-muted">Rating</small>
                                            <span class="fw-bold">${curso.rating || 'N/A'}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" onclick="irACurso(${curso.id_curso})">
                                    <i class="fas fa-play-circle me-2"></i>
                                    Continuar Curso
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" 
                                        onclick="dejarComentario(${curso.id_curso}, '${curso.titulo}')">
                                    <i class="fas fa-comment me-2"></i>
                                    Comentar
                                </button>
                            </div>
                        </div>
                        
                        ${progreso === 100 ? 
                            '<div class="card-footer bg-success text-white text-center"><i class="fas fa-trophy me-2"></i>¡Curso Completado!</div>' : 
                            ''
                        }
                    </div>
                </div>
            `;
        }).join('');

        container.innerHTML = cursosHTML;

        // Agregar modales de comentarios dinámicamente
        agregarModalesComentarios(data);
    })
    .catch(error => {
        console.error('Error al cargar mis cursos:', error);
        container.innerHTML = `
            <div class="col-12">
                <div class="alert alert-danger text-center">
                    <h4><i class="fas fa-exclamation-triangle me-2"></i>Error al cargar tus cursos</h4>
                    <p>${error.message}</p>
                    <button class="btn btn-primary" onclick="location.reload()">
                        <i class="fas fa-refresh me-2"></i>Reintentar
                    </button>
                </div>
            </div>
        `;
    });
}

/**
 * Agrega los modales de comentarios para cada curso
 */
function agregarModalesComentarios(cursos) {
    const body = document.body;
    
    cursos.forEach(curso => {
        const modalHTML = `
            <div class="modal fade" id="modalComentario-${curso.id_curso}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content" style="border-radius: 20px;">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Comentario para: ${curso.titulo}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formComentario-${curso.id_curso}" class="form-comentario" data-curso-id="${curso.id_curso}">
                                <input type="hidden" name="id_curso" value="${curso.id_curso}">
                                
                                <div class="mb-3">
                                    <label for="comentario-${curso.id_curso}" class="form-label">Comentario</label>
                                    <textarea id="comentario-${curso.id_curso}" 
                                              name="comentario" 
                                              class="form-control" 
                                              rows="3" 
                                              placeholder="Comparte tu experiencia con este curso" 
                                              required></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="rating-${curso.id_curso}" class="form-label">Calificación (1–10)</label>
                                    <input type="number" 
                                           id="rating-${curso.id_curso}" 
                                           name="rating" 
                                           class="form-control" 
                                           min="1" 
                                           max="10" 
                                           placeholder="Ej. 8" 
                                           required>
                                </div>
                                
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-2"></i>Enviar Comentario
                                    </button>
                                </div>
                            </form>
                            <p id="mensaje-${curso.id_curso}" class="mensaje mt-2"></p>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Remover modal existente si hay uno
        const existingModal = document.getElementById(`modalComentario-${curso.id_curso}`);
        if (existingModal) {
            existingModal.remove();
        }
        
        body.insertAdjacentHTML('beforeend', modalHTML);
    });
}

/**
 * Muestra el modal para dejar comentario
 */
function dejarComentario(cursoId, titulo) {
    const modal = new bootstrap.Modal(document.getElementById(`modalComentario-${cursoId}`));
    modal.show();
}

/**
 * Redirige al curso del estudiante
 */
function irACurso(cursoId) {
    if (!cursoId) {
        console.error('ID de curso no definido');
        alert('Error: ID de curso no encontrado');
        return;
    }
    
    console.log('Navegando al curso ID:', cursoId);
    // Guardar el ID en sessionStorage para que esté disponible en la siguiente página
    sessionStorage.setItem('curso_actual', cursoId);
    window.location.href = `/mis-cursos/${cursoId}`;
}

// Hacer las funciones globales
window.dejarComentario = dejarComentario;
window.irACurso = irACurso;