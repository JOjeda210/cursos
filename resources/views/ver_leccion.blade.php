<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargando lección...</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        
        .lesson-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        
        .lesson-content {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .resource-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .resource-card:hover {
            border-color: #667eea;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        }
        
        .resource-video {
            border-color: #dc3545;
        }
        
        .resource-pdf {
            border-color: #fd7e14;
        }
        
        .resource-link {
            border-color: #0dcaf0;
        }
        
        .resource-imagen {
            border-color: #198754;
        }
        
        .video-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 */
            height: 0;
            overflow: hidden;
            border-radius: 10px;
        }
        
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        
        .pdf-viewer {
            width: 100%;
            height: 600px;
            border: none;
            border-radius: 10px;
        }
        
        .btn-complete {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-complete:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        }
        
        .btn-complete.completed {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            cursor: not-allowed;
        }
        
        .navigation-btns .btn {
            padding: 0.75rem 1.5rem;
        }
        
        #loading-spinner {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
    </style>
</head>
<body>
    @include('components.navbar')
    
    <div id="loading-spinner" class="text-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
        <p class="mt-3 text-primary fw-bold">Cargando lección...</p>
    </div>
    
    <div id="lesson-content" style="display: none;">
        <div class="lesson-header">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb text-white mb-3">
                        <li class="breadcrumb-item"><a href="/mis-cursos" class="text-white">Mis Cursos</a></li>
                        <li class="breadcrumb-item"><a id="breadcrumb-curso" href="#" class="text-white">Curso</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page" id="breadcrumb-modulo">Módulo</li>
                    </ol>
                </nav>
                <h1 id="lesson-title" class="display-6 fw-bold mb-2">Cargando...</h1>
                <p id="lesson-module" class="mb-0"><i class="fas fa-book me-2"></i>Módulo</p>
            </div>
        </div>
        
        <div class="container">
            <!-- Contenido de la lección -->
            <div class="lesson-content">
                <div id="lesson-description" class="mb-4">
                    <h4><i class="fas fa-info-circle me-2 text-primary"></i>Descripción</h4>
                    <p class="text-muted">Cargando descripción...</p>
                </div>
                
                <div id="lesson-main-content" class="mb-4">
                    <!-- El contenido principal se cargará aquí -->
                </div>
                
                <hr class="my-4">
                
                <div id="lesson-resources">
                    <h4 class="mb-3"><i class="fas fa-folder-open me-2 text-primary"></i>Recursos de la Lección</h4>
                    <div id="resources-container">
                        <!-- Los recursos se cargarán aquí dinámicamente -->
                    </div>
                </div>
            </div>
            
            <!-- Botón de completar -->
            <div class="text-center mb-4">
                <button id="btn-completar" class="btn btn-success btn-lg btn-complete">
                    <i class="fas fa-check-circle me-2"></i>
                    Marcar como Completada
                </button>
            </div>
            
            <!-- Navegación entre lecciones -->
            <div class="navigation-btns d-flex justify-content-between mb-5">
                <button id="btn-anterior" class="btn btn-outline-primary" style="display: none;">
                    <i class="fas fa-arrow-left me-2"></i>
                    Lección Anterior
                </button>
                <div></div>
                <button id="btn-siguiente" class="btn btn-primary" style="display: none;">
                    Siguiente Lección
                    <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </div>
            
            <!-- Botón volver al curso -->
            <div class="text-center mb-5">
                <a id="btn-volver-curso" href="/mis-cursos" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Volver al Curso
                </a>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script personalizado -->
    <script>
        // Pasar los IDs de PHP a JavaScript
        window.CURSO_ID = {{ $id_curso }};
        window.LECCION_ID = {{ $id_leccion }};
    </script>
    <script src="{{ asset('js/ver-leccion.js') }}"></script>
</body>
</html>
