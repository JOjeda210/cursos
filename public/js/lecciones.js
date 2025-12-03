// Configuración base
const BASE_API = '/api/';
const token = localStorage.getItem('jwt_token');

// Elementos del DOM
const cursoSelect = document.getElementById('cursoSelect');
const moduloSelect = document.getElementById('moduloSelect');
const formLeccionCard = document.getElementById('formLeccionCard');
const formTitle = document.getElementById('formTitle');
const leccionIdInput = document.getElementById('leccionId');
const tituloInput = document.getElementById('titulo');
const descripcionInput = document.getElementById('descripcion');
const guardarBtn = document.getElementById('guardarBtn');
const cancelarBtn = document.getElementById('cancelarBtn');
const listaLecciones = document.getElementById('listaLecciones');
const recursosCard = document.getElementById('recursosCard');
const listaRecursos = document.getElementById('listaRecursos');
const recursoIdInput = document.getElementById('recursoId');
const nombreRecursoInput = document.getElementById('nombreRecurso');
const urlRecursoInput = document.getElementById('urlRecurso');
const guardarRecursoBtn = document.getElementById('guardarRecursoBtn');
const cancelarRecursoBtn = document.getElementById('cancelarRecursoBtn');

let leccionActualId = null;
let moduloActualId = null;

// Verificar autenticación y rol de instructor
document.addEventListener('DOMContentLoaded', () => {
    if (!token) {
        alert('Debes iniciar sesión para acceder a esta página');
        window.location.href = '/login';
        return;
    }

    // Verificar rol de instructor desde el token JWT
    try {
        const payload = JSON.parse(atob(token.split('.')[1]));
        if (payload.id_rol !== 1) {
            alert('Esta vista es solo para instructores');
            window.location.href = '/catalogo-privado';
            return;
        }
    } catch (error) {
        alert('Token inválido. Por favor, inicia sesión nuevamente');
        window.location.href = '/login';
        return;
    }

    cargarCursos();
});

// --- Cargar Cursos ---
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

// --- Cargar Módulos cuando cambia el curso ---
cursoSelect.addEventListener('change', async () => {
    const cursoId = cursoSelect.value;
    
    // Reset
    moduloSelect.innerHTML = '<option value="">-- Selecciona un módulo --</option>';
    moduloSelect.disabled = true;
    listaLecciones.innerHTML = '';
    formLeccionCard.classList.add('d-none');
    recursosCard.classList.add('d-none');

    if (!cursoId) return;

    try {
        const response = await fetch(`${BASE_API}instructor/modulos/${cursoId}`, {
            headers: { Authorization: `Bearer ${token}` }
        });

        if (!response.ok) throw new Error('Error al cargar módulos');

        const modulos = await response.json();
        modulos.forEach(modulo => {
            const option = document.createElement('option');
            option.value = modulo.id_modulo;
            option.textContent = modulo.titulo;
            moduloSelect.appendChild(option);
        });

        moduloSelect.disabled = false;
    } catch (error) {
        console.error('Error:', error);
        alert('Error al cargar los módulos');
    }
});

// --- Cargar Lecciones cuando cambia el módulo ---
moduloSelect.addEventListener('change', async () => {
    const moduloId = moduloSelect.value;
    moduloActualId = moduloId;

    // Reset
    listaLecciones.innerHTML = '';
    formLeccionCard.classList.add('d-none');
    recursosCard.classList.add('d-none');
    resetFormularioLeccion();

    if (!moduloId) return;

    // Mostrar formulario de creación
    formLeccionCard.classList.remove('d-none');

    // Cargar lecciones del módulo
    await cargarLecciones(moduloId);
});

// --- Cargar Lecciones ---
async function cargarLecciones(moduloId) {
    try {
        const response = await fetch(`${BASE_API}modulos/${moduloId}/lecciones`, {
            headers: { Authorization: `Bearer ${token}` }
        });

        if (!response.ok) throw new Error('Error al cargar lecciones');

        const lecciones = await response.json();
        listaLecciones.innerHTML = '';

        if (lecciones.length === 0) {
            listaLecciones.innerHTML = '<li class="list-group-item text-muted">No hay lecciones en este módulo</li>';
            return;
        }

        lecciones.forEach(leccion => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                <div>
                    <strong>${leccion.titulo}</strong>
                    <span class="badge bg-info ms-2">${leccion.tipo}</span>
                    <small class="text-muted ms-2">Orden: ${leccion.orden}</small>
                    ${leccion.duracion ? `<small class="text-muted ms-2">Duración: ${leccion.duracion} min</small>` : ''}
                </div>
                <div>
                    <button class="btn btn-sm btn-info verRecursosBtn" data-id="${leccion.id_leccion}">
                        Recursos
                    </button>
                    <button class="btn btn-sm btn-primary editarLeccionBtn" 
                        data-id="${leccion.id_leccion}"
                        data-titulo="${leccion.titulo}"
                        data-contenido="${leccion.contenido || ''}"
                        data-tipo="${leccion.tipo}"
                        data-orden="${leccion.orden}"
                        data-duracion="${leccion.duracion || ''}">
                        Editar
                    </button>
                    <button class="btn btn-sm btn-danger eliminarLeccionBtn" data-id="${leccion.id_leccion}">
                        Eliminar
                    </button>
                </div>
            `;
            listaLecciones.appendChild(li);
        });

        // Event listeners para botones
        document.querySelectorAll('.verRecursosBtn').forEach(btn => {
            btn.addEventListener('click', () => verRecursos(btn.dataset.id));
        });

        document.querySelectorAll('.editarLeccionBtn').forEach(btn => {
            btn.addEventListener('click', () => editarLeccion(btn.dataset));
        });

        document.querySelectorAll('.eliminarLeccionBtn').forEach(btn => {
            btn.addEventListener('click', () => eliminarLeccion(btn.dataset.id));
        });

    } catch (error) {
        console.error('Error:', error);
        alert('Error al cargar las lecciones');
    }
}

// --- Editar Lección ---
function editarLeccion(data) {
    leccionIdInput.value = data.id;
    tituloInput.value = data.titulo;
    descripcionInput.value = data.contenido;
    
    formTitle.textContent = 'Editar lección';
    guardarBtn.textContent = 'Actualizar lección';
    cancelarBtn.classList.remove('d-none');
    
    // Scroll al formulario
    formLeccionCard.scrollIntoView({ behavior: 'smooth' });
}

// --- Guardar Lección (Crear o Actualizar) ---
guardarBtn.addEventListener('click', async () => {
    const id = leccionIdInput.value;
    const titulo = tituloInput.value.trim();
    const contenido = descripcionInput.value.trim();

    if (!titulo) {
        alert('El título es obligatorio');
        return;
    }

    if (!moduloActualId) {
        alert('Debes seleccionar un módulo primero');
        return;
    }

    try {
        // Obtener el siguiente orden automáticamente
        const leccionesActuales = await fetch(`${BASE_API}modulos/${moduloActualId}/lecciones`, {
            headers: { Authorization: `Bearer ${token}` }
        }).then(r => r.json());

        const siguienteOrden = id ? 
            parseInt(document.querySelector(`[data-id="${id}"]`)?.dataset.orden || 1) : 
            (leccionesActuales.length + 1);

        const body = {
            titulo,
            contenido,
            tipo: 'texto', // Por defecto texto
            orden: siguienteOrden,
            duracion: 0
        };

        // Si es nueva, incluir id_modulo
        if (!id) {
            body.id_modulo = parseInt(moduloActualId);
        }

        const method = id ? 'PUT' : 'POST';
        const url = id ? `${BASE_API}lecciones/${id}` : `${BASE_API}lecciones`;

        const response = await fetch(url, {
            method,
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        });

        if (!response.ok) {
            const error = await response.json();
            throw new Error(error.error || 'Error al guardar la lección');
        }

        alert(id ? 'Lección actualizada correctamente' : 'Lección creada correctamente');
        resetFormularioLeccion();
        await cargarLecciones(moduloActualId);

    } catch (error) {
        console.error('Error:', error);
        alert(error.message || 'Error al guardar la lección');
    }
});

// --- Cancelar Edición ---
cancelarBtn.addEventListener('click', resetFormularioLeccion);

function resetFormularioLeccion() {
    leccionIdInput.value = '';
    tituloInput.value = '';
    descripcionInput.value = '';
    formTitle.textContent = 'Crear nueva lección';
    guardarBtn.textContent = 'Guardar';
    cancelarBtn.classList.add('d-none');
}

// --- Eliminar Lección ---
async function eliminarLeccion(leccionId) {
    if (!confirm('¿Estás seguro de eliminar esta lección? Esta acción no se puede deshacer.')) {
        return;
    }

    try {
        const response = await fetch(`${BASE_API}lecciones/${leccionId}`, {
            method: 'DELETE',
            headers: { Authorization: `Bearer ${token}` }
        });

        if (!response.ok) {
            const error = await response.json();
            throw new Error(error.error || 'Error al eliminar la lección');
        }

        alert('Lección eliminada correctamente');
        await cargarLecciones(moduloActualId);

        // Ocultar recursos si estaban visibles para esta lección
        if (leccionActualId == leccionId) {
            recursosCard.classList.add('d-none');
            leccionActualId = null;
        }

    } catch (error) {
        console.error('Error:', error);
        alert(error.message || 'Error al eliminar la lección');
    }
}

// --- Ver Recursos ---
async function verRecursos(leccionId) {
    listaRecursos.innerHTML = "";
    recursosCard.classList.remove("d-none");
    leccionActualId = leccionId;
    resetFormularioRecurso();

    try {
        // NOTA: El endpoint tiene un typo en la ruta (leccions en lugar de lecciones)
        const response = await fetch(`${BASE_API}leccions/${leccionId}/recursos`, { 
            headers: { Authorization: `Bearer ${token}` }
        });

        if (!response.ok) throw new Error('Error al cargar recursos');

        const recursos = await response.json();
        listaRecursos.innerHTML = "";

        if (recursos.length === 0) {
            listaRecursos.innerHTML = '<li class="list-group-item text-muted">No hay recursos para esta lección</li>';
            return;
        }

        recursos.forEach(recurso => {
            const li = document.createElement("li");
            li.className = "list-group-item d-flex justify-content-between align-items-center";
            li.innerHTML = `
                <div>
                    <strong>${recurso.titulo}</strong>
                    <span class="badge bg-secondary ms-2">${recurso.tipo}</span>
                    <br>
                    <a href="${recurso.url}" target="_blank" class="small">${recurso.url}</a>
                </div>
                <div>
                    <button class="btn btn-sm btn-primary editarRecursoBtn" 
                        data-id="${recurso.id_recurso}" 
                        data-titulo="${recurso.titulo}" 
                        data-url="${recurso.url}"
                        data-tipo="${recurso.tipo}">
                        Editar
                    </button>
                    <button class="btn btn-sm btn-danger eliminarRecursoBtn" 
                        data-id="${recurso.id_recurso}">
                        Eliminar
                    </button>
                </div>
            `;
            listaRecursos.appendChild(li);
        });

        // Event listeners para recursos
        document.querySelectorAll(".editarRecursoBtn").forEach(btn => {
            btn.addEventListener("click", () => {
                recursoIdInput.value = btn.dataset.id;
                nombreRecursoInput.value = btn.dataset.titulo;
                urlRecursoInput.value = btn.dataset.url;
                guardarRecursoBtn.textContent = "Actualizar recurso";
                cancelarRecursoBtn.classList.remove("d-none");
            });
        });

        document.querySelectorAll(".eliminarRecursoBtn").forEach(btn => {
            btn.addEventListener("click", () => eliminarRecurso(btn.dataset.id));
        });

    } catch (error) {
        console.error('Error:', error);
        alert('Error al cargar los recursos');
    }
}

// --- Guardar Recurso ---
guardarRecursoBtn.addEventListener("click", async () => {
    const id = recursoIdInput.value;
    const titulo = nombreRecursoInput.value.trim();
    const url = urlRecursoInput.value.trim();

    if (!titulo || !url) {
        alert("Completa todos los campos");
        return;
    }

    if (!leccionActualId) {
        alert("Selecciona una lección primero");
        return;
    }

    try {
        const body = {
            titulo,
            url,
            tipo: 'link' // Por defecto link
        };

        // Si es nuevo, incluir id_leccion
        if (!id) {
            body.id_leccion = parseInt(leccionActualId);
        }

        // NOTA: El endpoint de actualización usa POST en lugar de PUT
        const method = id ? 'POST' : 'POST';
        const urlApi = id 
            ? `${BASE_API}recursos/${id}` 
            : `${BASE_API}recursos`;

        const response = await fetch(urlApi, {
            method,
            headers: { 
                "Authorization": `Bearer ${token}`, 
                "Content-Type": "application/json" 
            },
            body: JSON.stringify(body)
        });

        if (!response.ok) {
            const error = await response.json();
            throw new Error(error.error || 'Error al guardar el recurso');
        }

        alert(id ? 'Recurso actualizado correctamente' : 'Recurso creado correctamente');
        resetFormularioRecurso();
        await verRecursos(leccionActualId);

    } catch (error) {
        console.error('Error:', error);
        alert(error.message || 'Error al guardar el recurso');
    }
});

// --- Cancelar Recurso ---
cancelarRecursoBtn.addEventListener("click", resetFormularioRecurso);

function resetFormularioRecurso() {
    recursoIdInput.value = "";
    nombreRecursoInput.value = "";
    urlRecursoInput.value = "";
    guardarRecursoBtn.textContent = "Guardar recurso";
    cancelarRecursoBtn.classList.add("d-none");
}

// --- Eliminar Recurso ---
async function eliminarRecurso(recursoId) {
    if (!confirm("¿Deseas eliminar este recurso?")) return;

    try {
        const response = await fetch(`${BASE_API}recursos/${recursoId}`, {
            method: "DELETE",
            headers: { Authorization: `Bearer ${token}` }
        });

        if (!response.ok) {
            const error = await response.json();
            throw new Error(error.error || 'Error al eliminar el recurso');
        }

        alert('Recurso eliminado correctamente');
        await verRecursos(leccionActualId);

    } catch (error) {
        console.error('Error:', error);
        alert(error.message || 'Error al eliminar el recurso');
    }
}
