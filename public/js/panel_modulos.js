const BASE_API = '/api/';
const token = localStorage.getItem('jwt_token');
let modalBootstrap;
let cursoSeleccionadoId = null;

document.addEventListener('DOMContentLoaded', () => {
    if (!token) {
        alert('Debes iniciar sesión');
        window.location.href = '/login';
        return;
    }

    try {
        const payload = JSON.parse(atob(token.split('.')[1]));
        if (payload.id_rol !== 1) {
            alert('Esta vista es solo para instructores');
            window.location.href = '/catalogo-privado';
            return;
        }
    } catch (error) {
        alert('Token inválido');
        window.location.href = '/login';
        return;
    }

    const modalEl = document.getElementById('modalModulo');
    if (modalEl) {
        modalBootstrap = new bootstrap.Modal(modalEl);
    }

    cargarCursos();
});

const cursoSelect = document.getElementById('cursoSelect');
const btnNuevoModulo = document.getElementById('btnNuevoModulo');

cursoSelect.addEventListener('change', async () => {
    const cursoId = cursoSelect.value;
    cursoSeleccionadoId = cursoId;

    if (!cursoId) {
        btnNuevoModulo.disabled = true;
        document.getElementById('listaModulos').innerHTML = '';
        return;
    }

    btnNuevoModulo.disabled = false;
    await cargarModulos(cursoId);
});

async function cargarCursos() {
    try {
        const response = await fetch(`${BASE_API}instructor/cursos`, {
            headers: { Authorization: `Bearer ${token}` }
        });

        if (!response.ok) throw new Error('Error al cargar cursos');

        const cursos = await response.json();
        cursoSelect.innerHTML = '<option value="">-- Selecciona un curso --</option>';
        
        cursos.forEach(curso => {
            const option = document.createElement('option');
            option.value = curso.id_curso;
            option.textContent = curso.titulo;
            cursoSelect.appendChild(option);
        });
    } catch (error) {
        console.error('Error:', error);
        alert('Error al cargar los cursos');
    }
}

async function cargarModulos(cursoId) {
    try {
        const response = await fetch(`${BASE_API}instructor/modulos/${cursoId}`, {
            headers: { Authorization: `Bearer ${token}` }
        });

        if (!response.ok) throw new Error('Error al cargar módulos');

        const modulos = await response.json();
        renderizarModulos(modulos);
    } catch (error) {
        console.error('Error:', error);
        alert('Error al cargar los módulos');
    }
}

function renderizarModulos(modulos) {
    const contenedor = document.getElementById('listaModulos');
    contenedor.innerHTML = '';

    if (modulos.length === 0) {
        contenedor.innerHTML = '<div class="col-12 text-center p-5">No hay módulos en este curso. Crea el primero.</div>';
        return;
    }

    modulos.forEach(modulo => {
        contenedor.innerHTML += `
            <div class="col-md-6">
                <div class="card modulo-card h-100">
                    <div class="card-body">
                        <h5 class="fw-bold mb-2">${modulo.titulo}</h5>
                        <small class="text-muted">Orden: ${modulo.orden}</small>

                        <div class="d-flex gap-2 mt-3">
                            <button class="btn btn-outline-primary btn-sm rounded-pill px-3" 
                                onclick="abrirModal(${modulo.id_modulo}, '${modulo.titulo}', ${modulo.orden})">
                                Editar
                            </button>
                            <button class="btn btn-outline-danger btn-sm rounded-pill px-3" 
                                onclick="eliminarModulo(${modulo.id_modulo})">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
}

const form = document.getElementById('moduloForm');
if (form) {
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const id = document.getElementById('moduloId').value;
        const titulo = document.getElementById('titulo').value;
        const orden = document.getElementById('orden').value;

        if (!cursoSeleccionadoId && !id) {
            alert('Selecciona un curso primero');
            return;
        }

        const payload = {
            titulo,
            orden: parseInt(orden)
        };

        if (!id) {
            payload.id_curso = parseInt(cursoSeleccionadoId);
        }

        const method = id ? 'PUT' : 'POST';
        const url = id ? `${BASE_API}instructor/modulos/${id}` : `${BASE_API}instructor/modulos`;

        try {
            const response = await fetch(url, {
                method,
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.error || 'Error al guardar');
            }

            alert(id ? 'Módulo actualizado' : 'Módulo creado');
            modalBootstrap.hide();
            await cargarModulos(cursoSeleccionadoId);
        } catch (error) {
            console.error('Error:', error);
            alert(error.message || 'Error al guardar el módulo');
        }
    });
}

async function eliminarModulo(id) {
    if (!confirm('¿Eliminar este módulo?')) return;

    try {
        const response = await fetch(`${BASE_API}instructor/modulos/${id}`, {
            method: 'DELETE',
            headers: { Authorization: `Bearer ${token}` }
        });

        if (!response.ok) {
            const error = await response.json();
            throw new Error(error.error || 'Error al eliminar');
        }

        alert('Módulo eliminado');
        await cargarModulos(cursoSeleccionadoId);
    } catch (error) {
        console.error('Error:', error);
        alert(error.message || 'Error al eliminar el módulo');
    }
}

window.limpiarFormulario = function() {
    document.getElementById('moduloForm').reset();
    document.getElementById('moduloId').value = '';
    document.getElementById('cursoId').value = cursoSeleccionadoId;
    document.getElementById('modalTitulo').innerText = 'Nuevo Módulo';
}

window.abrirModal = function(id, titulo, orden) {
    document.getElementById('moduloId').value = id;
    document.getElementById('titulo').value = titulo;
    document.getElementById('orden').value = orden;
    document.getElementById('modalTitulo').innerText = 'Editar Módulo';
    modalBootstrap.show();
}
