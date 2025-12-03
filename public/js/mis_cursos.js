document.addEventListener('DOMContentLoaded', () => {
    cargarCursos();
});

function cargarCursos() {
    const token = localStorage.getItem('jwt_token');

    console.log('Token encontrado:', token ? 'Sí' : 'No');
    console.log('Primeros 20 caracteres del token:', token ? token.substring(0, 20) + '...' : 'null');

    if (!token) {
        alert('No se encontró el token. Redirigiendo al login...');
        window.location.href = '/login';
        return;
    }

    console.log('Haciendo petición a /api/mis-cursos...');

    fetch('/api/mis-cursos', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        console.log('Status de respuesta:', response.status);
        console.log('Response completo:', response);
        
        if (response.status === 401) {
            localStorage.removeItem('jwt_token');
            alert('Tu sesión ha expirado o el token es inválido. Por favor, inicia sesión nuevamente.');
            window.location.href = '/login';
            return null;
        }
        if (!response.ok) {
            throw new Error('Error del servidor: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (!data) return; // Si data es null (por el return anterior)
        
        console.log('Datos recibidos:', data); // Debug
        const cursos = data;
        const container = document.getElementById('cursos-container');

        if (!cursos || cursos.length === 0) {
            container.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        <h4>No tienes cursos inscritos</h4>
                        <p>Visita nuestro <a href="/catalogos" class="alert-link">catálogo de cursos</a> para inscribirte.</p>
                    </div>
                </div>
            `;
        } else {
            const htmlDeCursos = cursos.map(curso => {
                // Usando snake_case como viene de la BD
                return `
                    <div class="col-md-6 col-lg-4 d-flex">
                        <div class="promo-card">
                            <img src="${curso.imagen_portada || 'https://via.placeholder.com/400x200'}" 
                                 class="card-img-top" 
                                 alt="${curso.titulo}">
                            
                            <div class="card-body">
                                <h5 class="card-title mb-2">${curso.titulo}</h5>
                                <p class="card-description mb-3">${curso.descripcion || 'Sin descripción'}</p>
                            </div>

                            <div class="card-footer-action">
                                <a href="#" class="btn-curso-ver" data-bs-toggle="modal" data-bs-target="#modalPython">Ver curso</a>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            container.innerHTML = htmlDeCursos;
        }
    })
    .catch(error => {
        console.error('Error al cargar los cursos:', error);
        const container = document.getElementById('cursos-container');
        container.innerHTML = '<h4 class="text-white text-center">Hubo un error al cargar tus cursos. Intenta más tarde.</h4>';
    });
}