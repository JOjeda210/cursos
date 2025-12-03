<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Recursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body>

    @include('components.navbar')
    @include('components.instructor-nav')

    <section class="banner" style="background: linear-gradient(135deg, #2b3e50 0%, #4a90e2 100%); color: white; padding: 2rem 0;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <h2 class="mb-0">
                        <i class="fas fa-file-alt me-3"></i>
                        Gestión de Recursos
                    </h2>
                    <p class="lead mb-0">Administra los recursos de tus lecciones</p>
                </div>
            </div>
        </div>
    </section>

    <div class="container my-4">
        <!-- Filtros -->
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="cursoSelect" class="form-label">Seleccionar Curso:</label>
                <select id="cursoSelect" class="form-select">
                    <option value="">Selecciona un curso...</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="moduloSelect" class="form-label">Seleccionar Módulo:</label>
                <select id="moduloSelect" class="form-select" disabled>
                    <option value="">Selecciona un módulo...</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="leccionSelect" class="form-label">Seleccionar Lección:</label>
                <select id="leccionSelect" class="form-select" disabled>
                    <option value="">Selecciona una lección...</option>
                </select>
            </div>
        </div>

        <!-- Botón para nuevo recurso -->
        <div class="row mb-4">
            <div class="col-12">
                <button id="btnNuevoRecurso" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRecurso" disabled>
                    <i class="fas fa-plus me-2"></i>
                    Nuevo Recurso
                </button>
            </div>
        </div>

        <!-- Lista de recursos -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>
                            Recursos de la Lección
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="listaRecursos" class="table-responsive">
                            <p class="text-muted text-center py-4">
                                Selecciona una lección para ver sus recursos
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para crear/editar recurso -->
    <div class="modal fade" id="modalRecurso" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTitulo">Nuevo Recurso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="recursoForm" enctype="multipart/form-data">
                        <input type="hidden" id="recursoId" value="">
                        <input type="hidden" id="leccionId" value="">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="titulo" class="form-label">Título del Recurso *</label>
                                <input type="text" id="titulo" class="form-control" placeholder="Ej: Video Introducción" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tipo" class="form-label">Tipo de Recurso *</label>
                                <select id="tipo" class="form-select" required>
                                    <option value="">Seleccionar tipo...</option>
                                    <option value="video">Video</option>
                                    <option value="pdf">Documento PDF</option>
                                    <option value="link">Enlace Web</option>
                                    <option value="imagen">Imagen</option>
                                </select>
                            </div>
                        </div>

                        <!-- Campo URL (para videos y links) -->
                        <div id="campoUrl" class="mb-3" style="display: none;">
                            <label for="url" class="form-label">URL del Recurso</label>
                            <input type="url" id="url" class="form-control" placeholder="https://ejemplo.com/video">
                            <small class="form-text text-muted">Para videos, puedes usar enlaces de YouTube, Vimeo, etc.</small>
                        </div>

                        <!-- Campo Archivo (para PDFs e imágenes) -->
                        <div id="campoArchivo" class="mb-3" style="display: none;">
                            <label for="archivo" class="form-label">Subir Archivo</label>
                            <input type="file" id="archivo" class="form-control" accept="">
                            <small class="form-text text-muted">Tamaño máximo: 10MB</small>
                            
                            <!-- Vista previa para imágenes -->
                            <div id="vistaPrevia" class="mt-3" style="display: none;">
                                <img id="imagenPreview" src="" alt="Vista previa" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea id="descripcion" class="form-control" rows="3" placeholder="Descripción opcional del recurso"></textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Guardar Recurso
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/panel_recursos.js') }}"></script>
</body>
</html>