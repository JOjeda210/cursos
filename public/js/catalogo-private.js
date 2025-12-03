document.addEventListener('DOMContentLoaded', () => {
    verificarAutenticacion();
    cargarCursosPrivados();
    
    // Agregar listener para los botones de inscripción
    document.addEventListener('click', manejarInscripcion);
});

/**
 * Maneja la inscripción a cursos
 */
async function manejarInscripcion(e) {
    const btn = e.target.closest('.btn-inscribir');
    if (!btn) return;

    e.preventDefault();
    
    const idCurso = btn.getAttribute('data-curso-id');
    if (!idCurso) {
        alert('Error: No se encontró el ID del curso');
        return;
    }

    const token = localStorage.getItem('jwt_token');
    if (!token) {
        alert('Debes iniciar sesión para inscribirte');
        window.location.href = '/login';
        return;
    }

    // Prevenir doble click
    if (btn.dataset.loading === '1') return;
    btn.dataset.loading = '1';
    
    const textoOriginal = btn.innerText;
    btn.innerText = 'Inscribiendo...';
    btn.disabled = true;

    try {
        const response = await fetch('/api/enroll', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ id_curso: parseInt(idCurso) })
        });

        let data = {};
        try { data = await response.json(); } catch (e) { /* respuesta vacía */ }

        if (response.status === 201) {
            alert('Inscrito correctamente');
            btn.innerText = 'Inscrito';
            btn.classList.remove('btn-inscribir');
            btn.classList.add('btn-success');
            // No restaurar el botón, mantener como "Inscrito"
        } else if (response.status === 422) {
            const mensaje = data.error || data.mensaje || 'Ya estás inscrito en este curso';
            alert(mensaje);
            restaurarBoton(btn, textoOriginal);
        } else if (response.status === 401) {
            alert('Tu sesión ha expirado. Inicia sesión nuevamente');
            localStorage.removeItem('jwt_token');
            window.location.href = '/login';
        } else {
            const mensaje = data.message || data.error || 'Error al inscribirse';
            alert('Error: ' + mensaje);
            restaurarBoton(btn, textoOriginal);
        }
    } catch (error) {
        console.error('Error de red:', error);
        alert('Error de conexión. Inténtalo nuevamente');
        restaurarBoton(btn, textoOriginal);
    }
}

function restaurarBoton(btn, textoOriginal) {
    btn.innerText = textoOriginal;
    btn.disabled = false;
    btn.dataset.loading = '0';
}

/**
 * Verifica si el usuario tiene un token JWT válido
 * Si no, redirige al login
 */
function verificarAutenticacion() {
    const token = localStorage.getItem('jwt_token');
    
    if (!token) {
        alert('⚠️ Debes iniciar sesión para acceder al catálogo privado');
        window.location.href = '/login';
        return false;
    }
    
    return true;
}

/**
 * Carga todos los cursos disponibles desde la API
 * Con autenticación JWT
 */
function cargarCursosPrivados() {
    const token = localStorage.getItem('jwt_token');
    const container = document.getElementById('cursos-catalogo');

    fetch('/api/cursos', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        // Si el token es inválido (401), redirigir al login
        if (response.status === 401) {
            localStorage.removeItem('jwt_token');
            alert('⚠️ Tu sesión ha expirado. Por favor, inicia sesión nuevamente.');
            window.location.href = '/login';
            return null;
        }
        
        if (!response.ok) {
            throw new Error('Error al cargar los cursos: ' + response.status);
        }
        
        return response.json();
    })
    .then(data => {
        if (!data) return; // Si hubo redirección, no continuar

        console.log('Cursos cargados:', data);

        if (!data || data.length === 0) {
            container.innerHTML = '<div class="col-12"><h4 class="text-center">No hay cursos disponibles en este momento.</h4></div>';
            return;
        }

        // Generar las tarjetas de cursos
        const cursosHTML = data.map(curso => {
            const imagenUrl = curso.imagen_portada 
                ? `/storage/${curso.imagen_portada}` 
                : 'https://via.placeholder.com/400x200?text=Sin+Imagen';

            // Determinar el botón de inscripción
            const botonInscripcion = curso.esta_inscrito === 1 
                ? `<button class="btn btn-success" disabled>
                        <i class="fas fa-check"></i> Inscrito
                   </button>`
                : `<button class="btn btn-inscribir mt-2" data-curso-id="${curso.id_curso}">
                        Inscribirme
                   </button>`;

            return `
                <div class="col-md-4">
                    <div class="card promo-card h-100">
                        <img src="${imagenUrl}" alt="${curso.titulo}" class="card-img-top">
                        <div class="card-body text-center">
                            <h5>${curso.titulo}</h5>
                            <p>${curso.descripcion || 'Sin descripción disponible'}</p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <p class="precio fw-bold mb-0">$${parseFloat(curso.precio).toFixed(2)}</p>
                                <small class="text-muted">${curso.nombre_categoria || 'Sin categoría'}</small>
                            </div>
                            
                            ${botonInscripcion}
                            
                            <!-- Botón de comentario -->
                            <button class="btn btn-comentario" data-bs-toggle="modal" data-bs-target="#modalComentario-${curso.id_curso}">
                                Dejar Comentario
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        container.innerHTML = cursosHTML;

        // Agregar modales de comentarios dinámicamente
        agregarModalesComentarios(data);
    })
    .catch(error => {
        console.error('Error al cargar cursos:', error);
        container.innerHTML = `
            <div class="col-12">
                <div class="alert alert-danger text-center">
                    <h4> Error al cargar los cursos</h4>
                    <p>${error.message}</p>
                    <button class="btn btn-primary" onclick="location.reload()">Reintentar</button>
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
                        <div class="modal-header">
                            <h5 class="modal-title">Comentario para: ${curso.titulo}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formComentario-${curso.id_curso}" class="form-comentario" data-curso-id="${curso.id_curso}">
                                <input type="hidden" name="id_curso" value="${curso.id_curso}">
                                
                                <label for="comentario-${curso.id_curso}">Comentario</label>
                                <textarea id="comentario-${curso.id_curso}" name="comentario" rows="3" placeholder="Escribe tu opinión" required></textarea>
                                
                                <label for="rating-${curso.id_curso}">Calificación (1–10)</label>
                                <input type="number" id="rating-${curso.id_curso}" name="rating" min="1" max="10" placeholder="Ej. 8" required>
                                
                                <button type="submit" class="btn btn-primary mt-3">Enviar</button>
                            </form>
                            <p id="mensaje-${curso.id_curso}" class="mensaje mt-2"></p>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        body.insertAdjacentHTML('beforeend', modalHTML);
    });
}
