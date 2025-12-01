<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargando curso...</title>
    
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
        
        .course-header {
            background: linear-gradient(135deg, #2b3e50 0%, #4a90e2 100%);
            color: white;
            padding: 3rem 0;
        }
        
        .progress-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .module-card {
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
            border-radius: 15px;
            overflow: hidden;
        }
        
        .lesson-item {
            border-left: 4px solid #667eea;
            padding: 1rem;
            margin-bottom: 0.5rem;
            background: #f8f9fa;
            border-radius: 0 8px 8px 0;
            transition: all 0.3s ease;
        }
        
        .lesson-item:hover {
            background: #e9ecef;
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
        <p class="mt-3 text-primary fw-bold">Cargando curso...</p>
    </div>
    
    <div id="course-content" style="display: none;">
        <div class="course-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 id="curso-titulo" class="display-5 fw-bold mb-3">Cargando...</h1>
                        <p id="curso-descripcion" class="lead mb-4">Cargando descripción...</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <img id="curso-imagen" src="https://via.placeholder.com/400x200" 
                             alt="Curso" 
                             class="img-fluid rounded shadow"
                             style="max-height: 200px; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container my-5">
            <!-- Progreso del curso -->
            <div class="progress-card">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <h4 class="text-primary mb-3">
                            <i class="fas fa-chart-line me-2"></i>
                            Tu Progreso
                        </h4>
                        <div class="progress mb-3" style="height: 25px;">
                            <div id="progreso-bar" class="progress-bar bg-success" role="progressbar" 
                                 style="width: 0%" 
                                 aria-valuenow="0" 
                                 aria-valuemin="0" aria-valuemax="100">
                                <span id="progreso-porcentaje" class="fw-bold">0%</span>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-4">
                                <h3 id="total-modulos" class="text-primary">0</h3>
                                <p class="text-muted">Módulos</p>
                            </div>
                            <div class="col-4">
                                <h3 id="total-lecciones" class="text-primary">0</h3>
                                <p class="text-muted">Lecciones</p>
                            </div>
                            <div class="col-4">
                                <h3 id="lecciones-completadas" class="text-success">0</h3>
                                <p class="text-muted">Completadas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contenido del curso -->
            <div class="row">
                <div class="col-12">
                    <h3 class="mb-4">
                        <i class="fas fa-book me-2"></i>
                        Contenido del Curso
                    </h3>
                    <div id="modulos-container">
                        <!-- Los módulos se cargarán aquí dinámicamente -->
                    </div>
                </div>
            </div>
            
            <!-- Botón volver -->
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <a href="/mis-cursos" class="btn btn-lg btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver a Mis Cursos
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script personalizado -->
    <script src="{{ asset('js/ver-curso-estudiante.js') }}"></script>
</body>
</html>
