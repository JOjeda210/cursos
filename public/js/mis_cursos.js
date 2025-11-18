document.addEventListener('DOMContentLoaded', () => {
    cargarCursos();
});

function cargarCursos() {
    const token = localStorage.getItem('jwt_token');

    if (!token) {
        window.location.href = '/login';
        return;
    }

    fetch('http://plataforma-cursos-appsweb.test/api/mis-cursos', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (response.status === 401) {
            localStorage.removeItem('jwt_token');
            window.location.href = '/login';
            return;
        }
        if (!response.ok) {
            throw new Error('Error del servidor: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Datos recibidos:', data); // Debug
        const cursos = data;
        const container = document.getElementById('cursos-container');

        if (!cursos || cursos.length === 0) {
            container.innerHTML = '<h4 class="text-white text-center">No tienes cursos inscritos.</h4>';
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