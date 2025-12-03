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
    <!-- Custom CSS -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        .course-header {
            background: linear-gradient(135deg, #2b3e50 0%, #4a90e2 100%);
            color: white;
            padding: 3rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .course-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.2);
            z-index: 1;
        }
        
        .course-header .container {
            position: relative;
            z-index: 2;
        }
        
        .progress-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .progress-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            margin: 0 auto;
        }
        
        .module-card {
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
            border-radius: 15px;
            overflow: hidden;
        }
        
        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .module-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
        }
        
        .lesson-item {
            border-left: 4px solid #667eea;
            padding: 1rem;
            margin-bottom: 0.5rem;
            background: #f8f9fa;
            border-radius: 0 8px 8px 0;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .lesson-item:hover {
            background: #e9ecef;
            border-left-color: #4a90e2;
        }
        
        .lesson-completed {
            background: #d1f2eb;
            border-left-color: #28a745;
        }
        
        .resource-item {
            background: white;
            border-radius: 8px;
            padding: 0.75rem;
            margin-top: 0.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .instructor-info {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .stats-item {
            text-align: center;
            padding: 1rem;
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: #2b3e50;
            display: block;
        }
        
        .stats-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    @include('components.navbar')
    
    <div class="course-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 id="curso-titulo" class="display-5 fw-bold mb-3">Cargando...</h1>
                    <p id="curso-descripcion" class="lead mb-4">Cargando descripción...</p>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge bg-success fs-6 px-3 py-2">
                            <i class="fas fa-check-circle me-2"></i>
                            Inscrito
                        </span>
                        <span class="text-light">
                            <i class="fas fa-user me-1"></i>
                            Instructor: {{ $curso->instructor_nombre }} {{ $curso->instructor_apellido }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    @if($curso->imagen_portada)
                        <img src="{{ asset('storage/' . $curso->imagen_portada) }}" 
                             alt="{{ $curso->titulo }}" 
                             class="img-fluid rounded shadow"
                             style="max-height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center" 
                             style="height: 200px; width: 100%;">
                            <i class="fas fa-graduation-cap fa-3x text-light"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="container my-5">
        <!-- Progreso del curso -->
        <div class="progress-card">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <div class="progress-circle" 
                         style="background: conic-gradient(#28a745 {{ $progresoCalculado * 3.6 }}deg, #dee2e6 {{ $progresoCalculado * 3.6 }}deg);">
                        {{ round($progresoCalculado) }}%
                    </div>
                </div>
                <div class="col-md-9">
                    <h4 class="text-primary mb-3">
                        <i class="fas fa-chart-line me-2"></i>
                        Tu Progreso
                    </h4>
                    <div class="progress mb-3" style="height: 10px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: {{ $progresoCalculado }}%" 
                             aria-valuenow="{{ $progresoCalculado }}" 
                             aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="row text-center">
                        <div class="col-4 stats-item">
                            <span class="stats-number">{{ $leccionesCompletadas }}</span>
                            <span class="stats-label">Lecciones Completadas</span>
                        </div>
                        <div class="col-4 stats-item">
                            <span class="stats-number">{{ $totalLecciones - $leccionesCompletadas }}</span>
                            <span class="stats-label">Pendientes</span>
                        </div>
                        <div class="col-4 stats-item">
                            <span class="stats-number">{{ $totalModulos }}</span>
                            <span class="stats-label">Módulos</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Información del instructor -->
        <div class="instructor-info">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h5 class="text-primary mb-2">
                        <i class="fas fa-chalkboard-teacher me-2"></i>
                        Sobre tu Instructor
                    </h5>
                    <h6 class="fw-bold">{{ $curso->instructor_nombre }} {{ $curso->instructor_apellido }}</h6>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <strong>Categoría:</strong>
                            <p class="text-muted">{{ $curso->categoria_nombre ?? 'Sin categoría' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Precio pagado:</strong>
                            <p class="text-success fw-bold">
                                {{ $curso->precio ? '$' . number_format($curso->precio, 2) : 'Gratis' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="instructor-avatar bg-primary rounded-circle d-inline-flex align-items-center justify-content-center"
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-user fa-2x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contenido del curso -->
        @if($totalModulos > 0)
            <div class="row">
                <div class="col-12">
                    <h3 class="text-primary mb-4">
                        <i class="fas fa-list-alt me-2"></i>
                        Contenido del Curso
                    </h3>
                    
                    @foreach($modulos as $index => $modulo)
                        <div class="module-card">
                            <div class="module-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-folder me-2"></i>
                                        Módulo {{ $index + 1 }}: {{ $modulo->titulo }}
                                    </h5>
                                    <span class="badge bg-light text-dark">
                                        {{ count($modulo->lecciones) }} lecciones
                                    </span>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                @if(count($modulo->lecciones) > 0)
                                    @foreach($modulo->lecciones as $leccionIndex => $leccion)
                                        <div class="lesson-item" onclick="verLeccion({{ $leccion->id_leccion }})">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <h6 class="fw-bold mb-1">
                                                        <i class="fas fa-play-circle me-2 text-primary"></i>
                                                        Lección {{ $leccionIndex + 1 }}: {{ $leccion->titulo }}
                                                    </h6>
                                                    @if($leccion->descripcion ?? false)
                                                        <p class="text-muted mb-2">{{ $leccion->descripcion }}</p>
                                                    @endif
                                                    <div class="d-flex align-items-center gap-3">
                                                        @if($leccion->duracion ?? false)
                                                            <small class="text-secondary">
                                                                <i class="fas fa-clock me-1"></i>
                                                                {{ $leccion->duracion }} min
                                                            </small>
                                                        @endif
                                                        <small class="text-info">
                                                            <i class="fas fa-bookmark me-1"></i>
                                                            {{ ucfirst($leccion->tipo) }}
                                                        </small>
                                                    </div>
                                                    
                                                    <!-- Recursos de la lección -->
                                                    @if(count($leccion->recursos) > 0)
                                                        <div class="mt-2">
                                                            <small class="text-muted fw-bold">Recursos:</small>
                                                            @foreach($leccion->recursos as $recurso)
                                                                <div class="resource-item d-flex align-items-center justify-content-between">
                                                                    <span>
                                                                        @if($recurso->tipo === 'video')
                                                                            <i class="fas fa-play text-danger me-2"></i>
                                                                        @elseif($recurso->tipo === 'pdf')
                                                                            <i class="fas fa-file-pdf text-danger me-2"></i>
                                                                        @elseif($recurso->tipo === 'link')
                                                                            <i class="fas fa-link text-primary me-2"></i>
                                                                        @elseif($recurso->tipo === 'imagen')
                                                                            <i class="fas fa-image text-success me-2"></i>
                                                                        @endif
                                                                        {{ $recurso->titulo }}
                                                                    </span>
                                                                    @if($recurso->tipo === 'link' || $recurso->tipo === 'video')
                                                                        <a href="{{ $recurso->url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                            <i class="fas fa-external-link-alt"></i>
                                                                        </a>
                                                                    @elseif($recurso->url)
                                                                        <a href="{{ asset('storage/' . $recurso->url) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                                            <i class="fas fa-download"></i>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="text-end">
                                                    <button class="btn btn-sm btn-success">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center text-muted py-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        No hay lecciones en este módulo
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Curso sin contenido</h4>
                <p class="text-muted">Este curso aún no tiene módulos ni lecciones.</p>
            </div>
        @endif
        
        <!-- Acciones -->
        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="{{ url('/mis-cursos') }}" class="btn btn-lg btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Volver a Mis Cursos
                </a>
                <button onclick="dejarComentario()" class="btn btn-lg btn-outline-secondary ms-2">
                    <i class="fas fa-comment me-2"></i>
                    Dejar Comentario
                </button>
            </div>
        </div>
    </div>
    
    <!-- Modal para comentarios -->
    @include('components.comentarios', ['cursoId' => $curso->id_curso])
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/comentarios.js') }}"></script>
    
    <script>
        function verLeccion(leccionId) {
            // TODO: Implementar vista de lección
            console.log('Ver lección:', leccionId);
            alert('Función de visualización de lección en desarrollo');
        }
        
        function dejarComentario() {
            const modal = new bootstrap.Modal(document.getElementById('modalComentario-{{ $curso->id_curso }}'));
            modal.show();
        }
    </script>
</body>
</html>