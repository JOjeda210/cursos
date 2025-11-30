/* public/js/instructor_logic.js */

// ASEGÚRATE QUE ESTA URL SEA CORRECTA (Si usas otro puerto, cámbialo)
const API_URL = "http://127.0.0.1:8000/api/instructor/cursos";
let modalBootstrap;

document.addEventListener("DOMContentLoaded", () => {
    console.log("Script cargado correctamente");

    // 1. TOKEN DUMMY
    let token = localStorage.getItem("auth_token");
    if (!token) {
        token = "token_prueba_" + Math.random().toString(36).substr(2);
        localStorage.setItem("auth_token", token);
    }

    // Inicializar Modal
    const modalEl = document.getElementById('modalCurso');
    if(modalEl) {
        modalBootstrap = new bootstrap.Modal(modalEl);
    } else {
        console.error("Error: No se encontró el modal con ID 'modalCurso'");
    }

    // Cargar datos
    cargarCursos();
});

function getHeaders() {
    return {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "Authorization": `Bearer ${localStorage.getItem("auth_token")}`
    };
}

// GET - LISTAR
async function cargarCursos() {
    try {
        console.log("Cargando cursos desde:", API_URL);
        const res = await fetch(API_URL, { headers: getHeaders() });
        
        if (!res.ok) {
            throw new Error(`Error HTTP: ${res.status}`);
        }

        const datos = await res.json();
        console.log("Datos recibidos:", datos);
        renderizarCursos(datos);

    } catch (error) {
        console.error("Error al cargar cursos:", error);
        alert("Error al conectar con la API. Revisa la consola (F12).");
    }
}

// RENDERIZADO
function renderizarCursos(datos) {
    const contenedor = document.getElementById("listaCursos");
    if (!contenedor) return;
    
    contenedor.innerHTML = "";

    if (datos.length === 0) {
        contenedor.innerHTML = "<div class='col-12 text-center p-5'>No hay cursos disponibles.</div>";
        return;
    }

    datos.forEach(curso => {
        const badgeClass = curso.estado === 'publicado' ? 'bg-publicado' : 'bg-borrador';
        
        // Manejo seguro de propiedades por si la API devuelve nombres distintos
        const titulo = curso.titulo || curso.nombre || "Sin título";
        const precio = curso.precio || 0;
        const catId  = curso.id_categoria || curso.categoria || "N/A";
        const desc   = curso.descripcion || "";
        const img    = curso.imagen_portada || curso.imagen || "";

        contenedor.innerHTML += `
            <div class="col-md-4">
                <div class="card promo-card h-100 position-relative">
                    <span class="badge badge-pos ${badgeClass}">${curso.estado || 'borrador'}</span>
                    
                    <div class="card-img-top-wrapper d-flex align-items-center justify-content-center bg-light" style="height: 180px;">
                        ${img ? `<img src="${img}" style="width:100%; height:100%; object-fit:cover;">` : '<i class="bi bi-image fs-1 text-secondary"></i>'}
                    </div>

                    <div class="card-body text-center">
                        <h5 class="fw-bold mb-1 text-dark">${titulo}</h5>
                        <small class="text-muted d-block mb-3">Cat: ${catId}</small>
                        <h4 class="text-primary fw-bold mb-3">$${precio}</h4>

                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-outline-primary btn-sm rounded-pill px-3" 
                                onclick="abrirModal(${curso.id}, '${titulo}', ${precio}, '${desc}', '${catId}')">
                                Editar
                            </button>
                            <button class="btn btn-outline-danger btn-sm rounded-pill px-3" 
                                onclick="eliminarCurso(${curso.id})">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    });
}

// POST & PUT - GUARDAR
const form = document.getElementById("cursoForm");
if (form) {
    form.addEventListener("submit", async e => {
        e.preventDefault();
        console.log("Intentando guardar...");

        const id = document.getElementById("cursoId").value;
        
        // RECOLECTAR VALORES
        const tituloVal = document.getElementById("titulo").value;
        const precioVal = document.getElementById("precio").value;
        const catVal = document.getElementById("categoria").value;
        const descVal = document.getElementById("descripcion").value;

        const payload = {
            titulo: tituloVal,
            precio: parseFloat(precioVal),
            id_categoria: catVal, // Se envía como string o int según el backend
            descripcion: descVal,
            estado: 'borrador'
        };

        console.log("Enviando Payload:", payload);

        let url = API_URL;
        let method = "POST";

        if (id) {
            url = `${API_URL}/${id}`;
            method = "PUT";
        }

        try {
            const res = await fetch(url, {
                method: method,
                headers: getHeaders(),
                body: JSON.stringify(payload)
            });

            console.log("Estatus Respuesta:", res.status);

            if (res.ok) {
                // ÉXITO
                const respuestaJson = await res.json();
                console.log("Respuesta Server:", respuestaJson);
                
                modalBootstrap.hide();
                alert(id ? "Curso actualizado (Simulado)" : "Curso creado (Simulado)");
                cargarCursos(); // RECARGAR LA LISTA
            } else {
                throw new Error("Error en la petición: " + res.statusText);
            }
        } catch (error) {
            console.error("Error al guardar:", error);
            alert("No se pudo guardar. Revisa la consola.");
        }
    });
} else {
    console.error("No se encontró el formulario 'cursoForm'");
}

// DELETE
async function eliminarCurso(id) {
    if (!confirm("¿Eliminar curso?")) return;

    try {
        await fetch(`${API_URL}/${id}`, {
            method: "DELETE",
            headers: getHeaders()
        });
        alert("Eliminado");
        cargarCursos();
    } catch(e) {
        console.error(e);
    }
}

// UI HELPERS
window.limpiarFormulario = function() {
    document.getElementById("cursoForm").reset();
    document.getElementById("cursoId").value = "";
    document.getElementById("modalTitulo").innerText = "Nuevo Curso";
}

window.abrirModal = function(id, titulo, precio, descripcion, categoria) {
    document.getElementById("cursoId").value = id;
    document.getElementById("titulo").value = titulo;
    document.getElementById("precio").value = precio;
    document.getElementById("descripcion").value = descripcion || "";
    document.getElementById("categoria").value = categoria; // Debe coincidir con el value de los options
    document.getElementById("modalTitulo").innerText = "Editar Curso";
    modalBootstrap.show();
}