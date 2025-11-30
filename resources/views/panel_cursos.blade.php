<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root { --gradiente: linear-gradient(135deg, #7e22ce 0%, #db2777 100%); }
        body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; }
        .banner { background: var(--gradiente); color: white; padding: 3rem 0; text-align: center; margin-bottom: 2rem; }
        .promo-card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); background: white; transition: transform 0.2s; }
        .promo-card:hover { transform: translateY(-5px); }
        .btn-miaula { background: var(--gradiente); color: white; border: none; border-radius: 50px; font-weight: 600; padding: 8px 24px; }
        .badge-pos { position: absolute; top: 10px; right: 10px; padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; }
        .bg-publicado { background-color: #d1e7dd; color: #0f5132; }
        .bg-borrador { background-color: #fff3cd; color: #856404; }
    </style>
</head>
<body>

    <section class="banner">
        <div class="container">
            <h1>Gestión de Cursos</h1>
            <button onclick="limpiarFormulario()" class="btn btn-light text-primary fw-bold mt-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalCurso">
                <i class="bi bi-plus-lg"></i> Nuevo Curso
            </button>
        </div>
    </section>

    <div class="container pb-5">
        <div id="listaCursos" class="row g-4">
            </div>
    </div>

    <div class="modal fade" id="modalCurso" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="modalTitulo">Curso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="cursoForm">
                        <input type="hidden" id="cursoId">
                        
                        <div class="mb-3">
                            <label class="fw-bold form-label">Título</label>
                            <input type="text" id="titulo" class="form-control bg-light" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="fw-bold form-label">Precio</label>
                                <input type="number" id="precio" step="0.01" class="form-control bg-light" required>
                            </div>
                            <div class="col-6">
                                <label class="fw-bold form-label">Categoría</label>
                                <select id="categoria" class="form-select bg-light">
                                    <option value="1">Tecnología</option>
                                    <option value="2">Diseño</option>
                                    <option value="3">Marketing</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold form-label">Descripción</label>
                            <textarea id="descripcion" class="form-control bg-light" rows="3"></textarea>
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
    <script src="{{ asset('js/instructor_logic.js') }}"></script>

</body>
</html>