const BASE_API = '/api/';
const token = localStorage.getItem('jwt_token');
let modalBootstrap;
let cursoSeleccionadoId = null;
let moduloSeleccionadoId = null;
let leccionSeleccionadaId = null;

document.addEventListener('DOMContentLoaded', () => {
    // Verificar autenticación
    if (!token) {
        alert('Debes iniciar sesión para acceder a esta página');
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
        alert('Token inválido. Por favor, inicia sesión nuevamente');
        window.location.href = '/login';
        return;
    }

    // Inicializar modal
    const modalEl = document.getElementById('modalRecurso');
    if (modalEl) {
        modalBootstrap = new bootstrap.Modal(modalEl);
    }

    // Event listeners
    setupEventListeners();
    
    // Cargar cursos iniciales
    cargarCursos();
});

function setupEventListeners() {
    // Selectores en cascada
    document.getElementById('cursoSelect').addEventListener('change', (e) => {
        cursoSeleccionadoId = e.target.value;
        if (cursoSeleccionadoId) {
            cargarModulos(cursoSeleccionadoId);
            resetModulosYLecciones();
        } else {
            resetTodo();
        }
    });

    document.getElementById('moduloSelect').addEventListener('change', (e) => {
        moduloSeleccionadoId = e.target.value;
        if (moduloSeleccionadoId) {
            cargarLecciones(moduloSeleccionadoId);
            resetLecciones();
        } else {
            resetLecciones();
        }
    });

    document.getElementById('leccionSelect').addEventListener('change', (e) => {
        leccionSeleccionadaId = e.target.value;
        if (leccionSeleccionadaId) {
            document.getElementById('btnNuevoRecurso').disabled = false;
            cargarRecursos(leccionSeleccionadaId);
        } else {
            document.getElementById('btnNuevoRecurso').disabled = true;
            resetRecursos();
        }
    });

    // Cambio de tipo de recurso
    document.getElementById('tipo').addEventListener('change', (e) => {
        mostrarCamposSegunTipo(e.target.value);
    });

    // Vista previa de imagen
    document.getElementById('archivo').addEventListener('change', mostrarVistaPrevia);

    // Formulario
    document.getElementById('recursoForm').addEventListener('submit', guardarRecurso);
}

function getHeaders() {
    return {
        "Accept": "application/json",
        "Authorization": `Bearer ${token}`
    };
}

function getJsonHeaders() {
    return {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "Authorization": `Bearer ${token}`
    };
}

async function cargarCursos() {
    try {
        const res = await fetch(`${BASE_API}instructor/cursos`, { headers: getJsonHeaders() });
        
        if (!res.ok) throw new Error(`Error HTTP: ${res.status}`);

        const cursos = await res.json();
        const select = document.getElementById('cursoSelect');
        
        select.innerHTML = '<option value="">Selecciona un curso...</option>';
        
        cursos.forEach(curso => {
            const option = document.createElement('option');
            option.value = curso.id_curso;
            option.textContent = curso.titulo;
            select.appendChild(option);
        });

    } catch (error) {
        console.error("Error al cargar cursos:", error);
        alert("Error al cargar los cursos");
    }
}

async function cargarModulos(cursoId) {
    try {
        const res = await fetch(`${BASE_API}instructor/modulos/${cursoId}`, { headers: getJsonHeaders() });
        
        if (!res.ok) throw new Error(`Error HTTP: ${res.status}`);

        const modulos = await res.json();
        const select = document.getElementById('moduloSelect');
        
        select.innerHTML = '<option value="">Selecciona un módulo...</option>';
        select.disabled = false;
        
        modulos.forEach(modulo => {
            const option = document.createElement('option');
            option.value = modulo.id_modulo;
            option.textContent = modulo.titulo;
            select.appendChild(option);
        });

    } catch (error) {
        console.error("Error al cargar módulos:", error);
        alert("Error al cargar los módulos");
    }
}

async function cargarLecciones(moduloId) {
    try {
        const res = await fetch(`${BASE_API}modulos/${moduloId}/lecciones`, { headers: getJsonHeaders() });
        
        if (!res.ok) throw new Error(`Error HTTP: ${res.status}`);

        const lecciones = await res.json();
        const select = document.getElementById('leccionSelect');
        
        select.innerHTML = '<option value="">Selecciona una lección...</option>';
        select.disabled = false;
        
        lecciones.forEach(leccion => {
            const option = document.createElement('option');
            option.value = leccion.id_leccion;
            option.textContent = leccion.titulo;
            select.appendChild(option);
        });

    } catch (error) {
        console.error("Error al cargar lecciones:", error);
        alert("Error al cargar las lecciones");
    }
}

async function cargarRecursos(leccionId) {
    try {
        const res = await fetch(`${BASE_API}leccions/${leccionId}/recursos`, { headers: getJsonHeaders() });
        
        if (!res.ok) throw new Error(`Error HTTP: ${res.status}`);

        const recursos = await res.json();
        renderizarRecursos(recursos);

    } catch (error) {
        console.error("Error al cargar recursos:", error);
        alert("Error al cargar los recursos");
    }
}

function renderizarRecursos(recursos) {
    const container = document.getElementById('listaRecursos');
    
    if (!recursos || recursos.length === 0) {
        container.innerHTML = `
            <div class="text-center text-muted py-4">
                <i class="fas fa-folder-open fa-3x mb-3"></i>
                <h5>No hay recursos</h5>
                <p>Esta lección aún no tiene recursos. ¡Agrega el primero!</p>
            </div>
        `;
        return;
    }

    const tabla = `
        <table class="table table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Tipo</th>
                    <th>Título</th>
                    <th>URL/Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                ${recursos.map(recurso => `
                    <tr>
                        <td>
                            <span class="badge bg-${getBadgeColor(recurso.tipo)}">
                                <i class="${getIconoTipo(recurso.tipo)} me-1"></i>
                                ${recurso.tipo.toUpperCase()}
                            </span>
                        </td>
                        <td class="fw-bold">${recurso.titulo}</td>
                        <td>
                            ${recurso.tipo === 'link' || recurso.tipo === 'video' 
                                ? `<a href="${recurso.url}" target="_blank" class="text-primary">Ver recurso</a>`
                                : recurso.url 
                                    ? `<a href="/storage/${recurso.url}" target="_blank" class="text-primary">Ver archivo</a>`
                                    : `<span class="text-muted">Sin archivo</span>`
                            }
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" onclick="editarRecurso(${JSON.stringify(recurso).replace(/"/g, '&quot;')})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="eliminarRecurso(${recurso.id_recurso})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;
    
    container.innerHTML = tabla;
}

function mostrarCamposSegunTipo(tipo) {
    const campoUrl = document.getElementById('campoUrl');
    const campoArchivo = document.getElementById('campoArchivo');
    const archivo = document.getElementById('archivo');
    
    // Ocultar todos los campos primero
    campoUrl.style.display = 'none';
    campoArchivo.style.display = 'none';
    archivo.removeAttribute('required');
    document.getElementById('url').removeAttribute('required');
    
    switch (tipo) {
        case 'video':
        case 'link':
            campoUrl.style.display = 'block';
            document.getElementById('url').setAttribute('required', 'required');
            break;
        case 'pdf':
            campoArchivo.style.display = 'block';
            archivo.setAttribute('accept', '.pdf');
            archivo.setAttribute('required', 'required');
            break;
        case 'imagen':
            campoArchivo.style.display = 'block';
            archivo.setAttribute('accept', 'image/*');
            archivo.setAttribute('required', 'required');
            break;
    }
}

function mostrarVistaPrevia(event) {
    const file = event.target.files[0];
    const vistaPrevia = document.getElementById('vistaPrevia');
    const imagenPreview = document.getElementById('imagenPreview');
    
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagenPreview.src = e.target.result;
            vistaPrevia.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        vistaPrevia.style.display = 'none';
    }
}

async function guardarRecurso(e) {
    e.preventDefault();
    
    const id = document.getElementById('recursoId').value;
    const leccionId = document.getElementById('leccionId').value || leccionSeleccionadaId;
    
    const formData = new FormData();
    formData.append('id_leccion', leccionId);
    formData.append('titulo', document.getElementById('titulo').value);
    formData.append('tipo', document.getElementById('tipo').value);
    
    const tipo = document.getElementById('tipo').value;
    if (tipo === 'video' || tipo === 'link') {
        formData.append('url', document.getElementById('url').value);
    } else if (tipo === 'pdf' || tipo === 'imagen') {
        const archivo = document.getElementById('archivo').files[0];
        if (archivo) {
            formData.append('file', archivo);
        }
    }

    const descripcion = document.getElementById('descripcion').value;
    if (descripcion) {
        formData.append('descripcion', descripcion);
    }

    let url = `${BASE_API}recursos`;
    let method = "POST";

    if (id) {
        url = `${BASE_API}recursos/${id}`;
        method = "PUT";
    }

    try {
        const res = await fetch(url, {
            method: method,
            headers: getHeaders(),
            body: formData
        });

        if (res.ok) {
            modalBootstrap.hide();
            alert(id ? "Recurso actualizado" : "Recurso creado");
            cargarRecursos(leccionSeleccionadaId);
            limpiarFormulario();
        } else {
            const error = await res.json();
            throw new Error(error.error || "Error en la petición");
        }
    } catch (error) {
        console.error("Error al guardar:", error);
        alert(error.message || "No se pudo guardar");
    }
}

async function eliminarRecurso(id) {
    if (!confirm("¿Eliminar este recurso?")) return;

    try {
        const res = await fetch(`${BASE_API}recursos/${id}`, {
            method: "DELETE",
            headers: getJsonHeaders()
        });

        if (res.ok) {
            alert("Recurso eliminado");
            cargarRecursos(leccionSeleccionadaId);
        } else {
            throw new Error("Error al eliminar");
        }
    } catch(e) {
        console.error(e);
        alert(e.message || "Error al eliminar");
    }
}

function editarRecurso(recurso) {
    document.getElementById('recursoId').value = recurso.id_recurso;
    document.getElementById('leccionId').value = recurso.id_leccion;
    document.getElementById('titulo').value = recurso.titulo;
    document.getElementById('tipo').value = recurso.tipo;
    document.getElementById('descripcion').value = recurso.descripcion || '';
    
    mostrarCamposSegunTipo(recurso.tipo);
    
    if (recurso.tipo === 'video' || recurso.tipo === 'link') {
        document.getElementById('url').value = recurso.url || '';
    }
    
    document.getElementById('modalTitulo').innerText = "Editar Recurso";
    modalBootstrap.show();
}

function limpiarFormulario() {
    document.getElementById('recursoForm').reset();
    document.getElementById('recursoId').value = "";
    document.getElementById('leccionId').value = "";
    document.getElementById('modalTitulo').innerText = "Nuevo Recurso";
    document.getElementById('vistaPrevia').style.display = 'none';
    document.getElementById('campoUrl').style.display = 'none';
    document.getElementById('campoArchivo').style.display = 'none';
}

// Funciones de utilidad
function getBadgeColor(tipo) {
    const colores = {
        'video': 'danger',
        'pdf': 'info',
        'link': 'warning',
        'imagen': 'success'
    };
    return colores[tipo] || 'secondary';
}

function getIconoTipo(tipo) {
    const iconos = {
        'video': 'fas fa-play',
        'pdf': 'fas fa-file-pdf',
        'link': 'fas fa-link',
        'imagen': 'fas fa-image'
    };
    return iconos[tipo] || 'fas fa-file';
}

// Funciones de reset
function resetTodo() {
    resetModulosYLecciones();
    resetRecursos();
}

function resetModulosYLecciones() {
    const moduloSelect = document.getElementById('moduloSelect');
    const leccionSelect = document.getElementById('leccionSelect');
    
    moduloSelect.innerHTML = '<option value="">Selecciona un módulo...</option>';
    moduloSelect.disabled = true;
    
    leccionSelect.innerHTML = '<option value="">Selecciona una lección...</option>';
    leccionSelect.disabled = true;
    
    document.getElementById('btnNuevoRecurso').disabled = true;
    resetRecursos();
}

function resetLecciones() {
    const leccionSelect = document.getElementById('leccionSelect');
    
    leccionSelect.innerHTML = '<option value="">Selecciona una lección...</option>';
    leccionSelect.disabled = true;
    
    document.getElementById('btnNuevoRecurso').disabled = true;
    resetRecursos();
}

function resetRecursos() {
    document.getElementById('listaRecursos').innerHTML = `
        <p class="text-muted text-center py-4">
            Selecciona una lección para ver sus recursos
        </p>
    `;
}

// Hacer funciones globales
window.editarRecurso = editarRecurso;
window.eliminarRecurso = eliminarRecurso;