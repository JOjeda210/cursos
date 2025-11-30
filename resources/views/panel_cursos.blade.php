<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Cursos - Instructor</title>

    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
        rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">
    <h1 class="mb-4 text-center">Gestión de Cursos</h1>

    <!-- FORMULARIO -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Registrar / Actualizar Curso</h5>

            <form id="cursoForm">
                <input type="hidden" id="cursoId">

                <div class="mb-3">
                    <label class="form-label">Nombre del Curso</label>
                    <input type="text" id="nombre" class="form-control" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">Guardar</button>
                    <button type="button" id="btnCancelar" class="btn btn-secondary">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- TABLA -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">Listado de Cursos</h5>

            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Curso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody id="tablaCursos"></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const API_URL = "http://localhost:8000/api/cursos";

    document.addEventListener("DOMContentLoaded", cargarCursos);
    const form = document.getElementById("cursoForm");

    // GET — Cargar cursos
    async function cargarCursos() {
        const res = await fetch(API_URL);
        const datos = await res.json();

        const tabla = document.getElementById("tablaCursos");
        tabla.innerHTML = "";

        datos.forEach(curso => {
            tabla.innerHTML += `
                <tr>
                    <td>${curso.id}</td>
                    <td>${curso.nombre}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editarCurso(${curso.id}, '${curso.nombre}')">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarCurso(${curso.id})">Eliminar</button>
                    </td>
                </tr>
            `;
        });
    }

    // POST & PUT — Guardar o actualizar
    form.addEventListener("submit", async e => {
        e.preventDefault();

        const id = document.getElementById("cursoId").value;
        const nombre = document.getElementById("nombre").value;

        const payload = { nombre };

        let endpoint = API_URL;
        let metodo = "POST";

        if (id) {
            endpoint = `${API_URL}/${id}`;
            metodo = "PUT";
        }

        await fetch(endpoint, {
            method: metodo,
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload),
        });

        form.reset();
        cargarCursos();
    });

    // Cargar valores en el formulario
    function editarCurso(id, nombre) {
        document.getElementById("cursoId").value = id;
        document.getElementById("nombre").value = nombre;
    }

    // DELETE — Eliminar
    async function eliminarCurso(id) {
        await fetch(`${API_URL}/${id}`, { method: "DELETE" });
        cargarCursos();
    }

    // Botón cancelar
    document.getElementById("btnCancelar").addEventListener("click", () => {
        form.reset();
        document.getElementById("cursoId").value = "";
    });

</script>
</body>
</html>
