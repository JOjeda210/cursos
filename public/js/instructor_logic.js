const BASE_API = '/api/';
let modalBootstrap;
let categoriasData = []; // Almacena las categorías para uso en renderizado

function getToken() {
    return localStorage.getItem('jwt_token');
}

document.addEventListener("DOMContentLoaded", () => {
    const token = getToken();
    
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

    const modalEl = document.getElementById('modalCurso');
    if(modalEl) {
        modalBootstrap = new bootstrap.Modal(modalEl);
    }

    // Agregar listener para vista previa de imagen
    const imagenInput = document.getElementById('imagenPortada');
    if (imagenInput) {
        imagenInput.addEventListener('change', mostrarVistaPrevia);
    }

    cargarCategorias();
    cargarCursos();
});

function mostrarVistaPrevia(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagenPreview');
    const previewImg = document.getElementById('imagenPreviewImg');
    
    if (file) {
        // Validar tipo de archivo
        if (!file.type.match(/^image\/(jpeg|jpg|png|svg\+xml)$/)) {
            alert('Por favor selecciona un archivo de imagen válido (JPG, PNG, SVG)');
            event.target.value = '';
            preview.style.display = 'none';
            return;
        }
        
        // Validar tamaño (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('La imagen no puede ser mayor a 2MB');
            event.target.value = '';
            preview.style.display = 'none';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
}

function getHeaders() {
    const token = getToken();
    return {
        "Accept": "application/json",
        "Authorization": `Bearer ${token}`
    };
}

function getJsonHeaders() {
    const token = getToken();
    return {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "Authorization": `Bearer ${token}`
    };
}

async function cargarCategorias() {
    try {
        const res = await fetch(`${BASE_API}categorias`, { headers: getJsonHeaders() });
        
        if (!res.ok) {
            throw new Error(`Error HTTP: ${res.status}`);
        }

        const categorias = await res.json();
        categoriasData = categorias; // Guardar para uso posterior
        const selectCategoria = document.getElementById('categoria');
        
        if (!selectCategoria) return;
        
        // Limpiar opciones existentes except la primera
        selectCategoria.innerHTML = '<option value="">Selecciona una categoría</option>';
        
        // Agregar categorías de la BD
        categorias.forEach(categoria => {
            const option = document.createElement('option');
            option.value = categoria.id_categoria;
            option.textContent = categoria.nombre_categoria;
            selectCategoria.appendChild(option);
        });

    } catch (error) {
        console.error("Error al cargar categorías:", error);
        // Fallback con categorías básicas
        const selectCategoria = document.getElementById('categoria');
        if (selectCategoria) {
            selectCategoria.innerHTML = `
                <option value="">Selecciona una categoría</option>
                <option value="1">Tecnología</option>
                <option value="2">Diseño</option>
                <option value="3">Marketing</option>
                <option value="4">Negocios</option>
                <option value="5">Idiomas</option>
                <option value="6">Salud y Bienestar</option>
            `;
        }
    }
}

async function cargarCursos() {
    try {
        const res = await fetch(`${BASE_API}instructor/cursos`, { headers: getJsonHeaders() });
        
        if (!res.ok) {
            throw new Error(`Error HTTP: ${res.status}`);
        }

        const datos = await res.json();
        renderizarCursos(datos);

    } catch (error) {
        console.error("Error al cargar cursos:", error);
        alert("Error al conectar con la API");
    }
}

function renderizarCursos(datos) {
    const contenedor = document.getElementById("listaCursos");
    if (!contenedor) return;
    
    contenedor.innerHTML = "";

    if (datos.length === 0) {
        contenedor.innerHTML = "<div class='col-12 text-center p-5'>No hay cursos disponibles. Crea tu primer curso.</div>";
        return;
    }

    datos.forEach(curso => {
        const badgeClass = curso.estado === 'publicado' ? 'bg-publicado' : 'bg-borrador';
        const titulo = curso.titulo || "Sin título";
        const precio = curso.precio || 0;
        
        // Buscar nombre de categoría
        const categoria = categoriasData.find(cat => cat.id_categoria == curso.id_categoria);
        const categoriaNombre = categoria ? categoria.nombre_categoria : `ID: ${curso.id_categoria || "N/A"}`;
        
        const desc = curso.descripcion || "";

        // Botones dinámicos según el estado del curso
        let botonesAccion = `
            <button class="btn btn-outline-primary btn-sm rounded-pill px-3" 
                onclick='editarCurso(${JSON.stringify(curso)})'>
                Editar
            </button>
        `;

        // Solo mostrar botón eliminar si no está publicado
        if (curso.estado !== 'publicado') {
            botonesAccion += `
                <button class="btn btn-outline-danger btn-sm rounded-pill px-3" 
                    onclick="eliminarCurso(${curso.id_curso})">
                    Eliminar
                </button>
            `;
        }

        // Mostrar botón publicar solo si está en borrador
        if (curso.estado === 'borrador') {
            botonesAccion += `
                <button class="btn btn-success btn-sm rounded-pill px-3" 
                    onclick="publicarCurso(${curso.id_curso})">
                    Publicar
                </button>
            `;
        }

        // Preparar imagen de portada
        let imagenHTML = '';
        if (curso.imagen_portada) {
            const imagenUrl = `/storage/${curso.imagen_portada}`;
            imagenHTML = `<img src="${imagenUrl}" class="card-img-top" alt="${titulo}" style="height: 180px; object-fit: cover;">`;
        } else {
            imagenHTML = `
                <div class="card-img-top-wrapper d-flex align-items-center justify-content-center bg-light" style="height: 180px;">
                    <i class="bi bi-book fs-1 text-secondary"></i>
                </div>
            `;
        }

        contenedor.innerHTML += `
            <div class="col-md-4">
                <div class="card promo-card h-100 position-relative">
                    <span class="badge badge-pos ${badgeClass}">${curso.estado || 'borrador'}</span>
                    
                    ${imagenHTML}

                    <div class="card-body text-center">
                        <h5 class="fw-bold mb-1 text-dark">${titulo}</h5>
                        <small class="text-muted d-block mb-3">${categoriaNombre}</small>
                        <h4 class="text-primary fw-bold mb-3">$${precio}</h4>

                        <div class="d-flex justify-content-center gap-1 flex-wrap">
                            ${botonesAccion}
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
}

const form = document.getElementById("cursoForm");
if (form) {
    form.addEventListener("submit", async e => {
        e.preventDefault();

        const id = document.getElementById("cursoId").value;
        const tituloVal = document.getElementById("titulo").value;
        const precioVal = document.getElementById("precio").value;
        const catVal = document.getElementById("categoria").value;
        const descVal = document.getElementById("descripcion").value;
        const estadoVal = document.getElementById("estado").value;
        const imagenFile = document.getElementById("imagenPortada").files[0];

        // Crear FormData para enviar archivos
        const formData = new FormData();
        formData.append('titulo', tituloVal);
        formData.append('precio', precioVal || '0');
        formData.append('id_categoria', catVal);
        formData.append('descripcion', descVal);
        formData.append('estado', estadoVal);
        
        if (imagenFile) {
            formData.append('imagen_portada', imagenFile);
        }

        let url = `${BASE_API}instructor/cursos`;
        let method = "POST";

        if (id) {
            url = `${BASE_API}instructor/cursos/${id}`;
            // Mantener POST pero agregar _method para simular PUT
            formData.append('_method', 'PUT');
        }

        try {
            const res = await fetch(url, {
                method: method, // Siempre POST
                headers: getHeaders(), // Sin Content-Type para FormData
                body: formData
            });

            if (res.ok) {
                modalBootstrap.hide();
                alert(id ? "Curso actualizado" : "Curso creado");
                cargarCursos();
                limpiarFormulario();
            } else {
                const error = await res.json();
                throw new Error(error.error || "Error en la petición");
            }
        } catch (error) {
            console.error("Error al guardar:", error);
            alert(error.message || "No se pudo guardar");
        }
    });
}

async function eliminarCurso(id) {
    if (!confirm("¿Eliminar curso?")) return;

    try {
        const res = await fetch(`${BASE_API}instructor/cursos/${id}`, {
            method: "DELETE",
            headers: getJsonHeaders()
        });

        if (res.ok) {
            alert("Curso eliminado");
            cargarCursos();
        } else {
            throw new Error("Error al eliminar");
        }
    } catch(e) {
        console.error(e);
        alert(e.message || "Error al eliminar");
    }
}

window.limpiarFormulario = function() {
    document.getElementById("cursoForm").reset();
    document.getElementById("cursoId").value = "";
    document.getElementById("estado").value = "borrador";
    document.getElementById("modalTitulo").innerText = "Nuevo Curso";
    
    // Limpiar vista previa de imagen
    const preview = document.getElementById('imagenPreview');
    if (preview) {
        preview.style.display = 'none';
    }
}

window.editarCurso = function(curso) {
    document.getElementById("cursoId").value = curso.id_curso;
    document.getElementById("titulo").value = curso.titulo;
    document.getElementById("precio").value = curso.precio;
    document.getElementById("descripcion").value = curso.descripcion || "";
    document.getElementById("categoria").value = curso.id_categoria;
    document.getElementById("estado").value = curso.estado || "borrador";
    document.getElementById("modalTitulo").innerText = "Editar Curso";
    modalBootstrap.show();
}

async function publicarCurso(id) {
    if (!confirm("¿Estás seguro de que quieres publicar este curso? Una vez publicado, no podrás eliminarlo.")) {
        return;
    }

    try {
        const res = await fetch(`${BASE_API}instructor/cursos/${id}/publicar`, {
            method: "PATCH",
            headers: getJsonHeaders()
        });

        if (res.ok) {
            const response = await res.json();
            alert("¡Curso publicado exitosamente!");
            cargarCursos(); // Recargar la lista de cursos
        } else {
            const error = await res.json();
            throw new Error(error.error || "Error al publicar el curso");
        }
    } catch(e) {
        console.error("Error al publicar:", e);
        alert(e.message || "Error al publicar el curso");
    }
}

// Hacer la función global para que pueda ser llamada desde onclick
window.publicarCurso = publicarCurso;

// Función para ver curso
function verCurso(idCurso) {
    window.location.href = `/panel-instructor/cursos/${idCurso}`;
}

// Hacer la función global para que pueda ser llamada desde onclick
window.verCurso = verCurso;