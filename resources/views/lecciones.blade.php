<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Lecciones</title>
    <link rel="stylesheet" href="/css/lecciones.css">
</head>
<body>

<div class="layout-wrapper">

    <header class="page-header">
        <h1 class="section-title">Gestión de Lecciones</h1>
        <p style="text-align:center; color:#fff; opacity:.85;">
            Administra cursos, módulos, lecciones y recursos en un solo lugar
        </p>
    </header>

    <div class="container">

        <!-- Selección -->
        <div class="section-box">
            <div class="form-grid">
                <div>
                    <label class="form-label">Selecciona un curso</label>
                    <select id="cursoSelect" class="form-select">
                        <option value="">-- Selecciona un curso --</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Selecciona un módulo</label>
                    <select id="moduloSelect" class="form-select" disabled>
                        <option value="">-- Selecciona un módulo --</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Formulario de Lección -->
        <div class="section-box d-none" id="formLeccionCard">
            <h2 class="section-title" id="formTitle">Crear nueva lección</h2>

            <input type="hidden" id="leccionId">

            <div class="form-grid">
                <div>
                    <label class="form-label">Título de la lección</label>
                    <input type="text" id="titulo" class="form-control">
                </div>

                <div>
                    <label class="form-label">Descripción</label>
                    <textarea id="descripcion" class="form-control"></textarea>
                </div>
            </div>

            <div class="btn-group-row">
                <button class="btn btn-primary" id="guardarBtn">Guardar</button>
                <button class="btn btn-secondary d-none" id="cancelarBtn">Cancelar edición</button>
            </div>
        </div>

        <!-- Lista Lecciones -->
        <div class="section-box">
            <h2 class="section-title">Lecciones del módulo</h2>
            <ul class="list-group" id="listaLecciones"></ul>
        </div>

        <!-- Recursos -->
        <div class="section-box d-none" id="recursosCard">
            <h2 class="section-title">Recursos de la lección</h2>
            <ul class="list-group" id="listaRecursos"></ul>

            <div class="sub-section mt-4">
                <h4>Agregar recurso</h4>

                <input type="hidden" id="recursoId">

                <div class="form-grid">
                    <div>
                        <label class="form-label">Nombre del recurso</label>
                        <input type="text" id="nombreRecurso" class="form-control">
                    </div>

                    <div>
                        <label class="form-label">URL del recurso</label>
                        <input type="text" id="urlRecurso" class="form-control">
                    </div>
                </div>

                <div class="btn-group-row">
                    <button class="btn btn-primary" id="guardarRecursoBtn">Guardar recurso</button>
                    <button class="btn btn-secondary d-none" id="cancelarRecursoBtn">Cancelar edición</button>
                </div>
            </div>
        </div>

    </div>
</div>

<footer class="main-footer">
    <p>Mi Aula Virtual © {{ date('Y') }} — Gestión de Lecciones</p>
</footer>

<script src="/js/lecciones.js"></script>
</body>
</html>
