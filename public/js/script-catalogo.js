document.addEventListener('DOMContentLoaded', () => {
    const token = localStorage.getItem('jwt_token');
    cargarCursosPublicos(token);
});

async function cargarCursosPublicos(token) {
    try {
        const response = await fetch('/api/cursos');
        
        if (!response.ok) throw new Error('Error al cargar cursos');

        let cursos = await response.json();
        
        cursos = cursos.filter(curso => curso.estado === 'publicado');

        if (!token && cursos.length > 3) {
            cursos = cursos.slice(0, 3);
        }

        renderizarCursosPublicos(cursos, token);

        if (!token && cursos.length >= 3) {
            mostrarMensajeLogin();
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

function renderizarCursosPublicos(cursos, token) {
    const container = document.querySelector('.promociones .row');
    
    if (!container) return;

    container.innerHTML = '';

    if (cursos.length === 0) {
        container.innerHTML = '<div class="col-12 text-center p-5">No hay cursos disponibles en este momento</div>';
        return;
    }

    cursos.forEach(curso => {
        const col = document.createElement('div');
        col.className = 'col-md-4';
        
        col.innerHTML = `
            <div class="card promo-card h-100">
                <div class="card-img-top-wrapper d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                    <i class="bi bi-book fs-1 text-secondary"></i>
                </div>
                <div class="card-body text-center">
                    <h5>${curso.titulo}</h5>
                    <p>${curso.descripcion || 'Curso disponible'}</p>
                    <p class="fw-bold text-primary">$${curso.precio}</p>
                    ${token ? `
                        <button class="btn btn-inscribir mt-2" data-curso-id="${curso.id_curso}">Inscribirme</button>
                        <button class="btn btn-comentario" data-bs-toggle="modal" data-bs-target="#modalComentario-${curso.id_curso}">
                            Dejar Comentario
                        </button>
                    ` : `
                        <button class="btn btn-secondary mt-2" onclick="alert('Necesitas iniciar sesión para inscribirte')">
                            Inscribirme
                        </button>
                        <button class="btn btn-outline-secondary" onclick="alert('Necesitas iniciar sesión para comentar')">
                            Dejar Comentario
                        </button>
                    `}
                </div>
            </div>
        `;
        
        container.appendChild(col);
    });

    if (token) {
        const inscribirBtns = document.querySelectorAll('.btn-inscribir');
        inscribirBtns.forEach(btn => {
            btn.addEventListener('click', async () => {
                const cursoId = btn.dataset.cursoId;
                await inscribirCurso(cursoId);
            });
        });
    }
}

async function inscribirCurso(cursoId) {
    const token = localStorage.getItem('jwt_token');
    
    if (!token) {
        alert('Necesitas iniciar sesión para inscribirte');
        window.location.href = '/login';
        return;
    }
    
    try {
        const response = await fetch('/api/enroll', {  // Ruta correcta
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ id_curso: parseInt(cursoId) })
        });

        let data = {};
        try { 
            data = await response.json(); 
        } catch (e) { 
            // Si no puede parsear JSON, crear un objeto vacío
            data = { message: 'Respuesta del servidor no válida' };
        }

        if (response.status === 201) {
            alert('Inscrito correctamente');
        } else if (response.status === 422) {
            const mensaje = data.error || data.mensaje || 'Ya estás inscrito en este curso';
            alert(mensaje);
        } else if (response.status === 401) {
            alert('Tu sesión ha expirado. Inicia sesión nuevamente');
            localStorage.removeItem('jwt_token');
            window.location.href = '/login';
        } else {
            const mensaje = data.error || data.message || 'Error al inscribirte';
            alert('Error: ' + mensaje);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error de conexión al procesar la inscripción');
    }
}

function mostrarMensajeLogin() {
    const container = document.querySelector('.promociones .container');
    
    if (!container) return;

    const mensaje = document.createElement('div');
    mensaje.className = 'alert alert-info text-center mt-4';
    mensaje.innerHTML = `
        <strong>¿Quieres ver más cursos?</strong><br>
        <a href="/login" class="btn btn-primary mt-2">Inicia sesión</a> o 
        <a href="/registro" class="btn btn-outline-primary mt-2">Regístrate</a>
    `;
    
    container.appendChild(mensaje);
}
