<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Módulos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root { --gradiente: linear-gradient(135deg, #7e22ce 0%, #db2777 100%); }
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .banner { background: var(--gradiente); color: white; padding: 3rem 0; text-align: center; margin-bottom: 2rem; }
        .modulo-card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); background: white; transition: transform 0.2s; }
        .modulo-card:hover { transform: translateY(-5px); }
        .btn-miaula { background: var(--gradiente); color: white; border: none; border-radius: 50px; font-weight: 600; padding: 8px 24px; }
        .form-control, .form-select { border-radius: 8px; padding: 10px; }
    </style>
</head>
<body>

    @include('components.navbar')
    @include('components.instructor-nav')

    <section class="banner">
        <div class="container">
            <h1>Gestión de Módulos</h1>
            <p>Organiza el contenido de tus cursos en módulos</p>
        </div>
    </section>

    <div class="container pb-5">
        <div class="row mb-4">
            <div class="col-md-6">
                <label class="fw-bold form-label">Selecciona un Curso</label>
                <select id="cursoSelect" class="form-select">
                    <option value="">-- Selecciona un curso --</option>
                </select>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <button onclick="limpiarFormulario()" class="btn btn-miaula w-100" data-bs-toggle="modal" data-bs-target="#modalModulo" disabled id="btnNuevoModulo">
                    <i class="bi bi-plus-lg"></i> Nuevo Módulo
                </button>
            </div>
        </div>

        <div id="listaModulos" class="row g-4"></div>
    </div>

    <div class="modal fade" id="modalModulo" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="modalTitulo">Nuevo Módulo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="moduloForm">
                        <input type="hidden" id="moduloId">
                        <input type="hidden" id="cursoId">
                        
                        <div class="mb-3">
                            <label class="fw-bold form-label">Título del Módulo</label>
                            <input type="text" id="titulo" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold form-label">Orden</label>
                            <input type="number" id="orden" class="form-control" min="1" required>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-miaula">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/navbar.js') }}" defer></script>
    <script src="{{ asset('js/panel_modulos.js') }}" defer></script>

</body>
</html>
