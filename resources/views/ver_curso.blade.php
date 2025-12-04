<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $curso->titulo }} - Plataforma Cursos</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    
    <style>
        .course-header {
            background: linear-gradient(135deg, #2b3e50 0%, #4a90e2 100%);
            color: white;
            padding: 3rem 0 2rem;
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
            background: rgba(0, 0, 0, 0.3);
            z-index: 1;
        }
        
        .course-header .container {
            position: relative;
            z-index: 2;
        }
        
        .course-status-badge {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 500;
        }
        
        .status-borrador {
            background: #fef3cd;
            color: #856404;
        }
        
        .status-publicado {
            background: #d1f2eb;
            color: #0f5132;
        }
        
        .module-card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }
        
        .module-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }
        
        .module-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 10px 10px 0 0;
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
            border-left-color: #4a90e2;
        }
        
        .course-info-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .stat-card {
            text-align: center;
            padding: 1.5rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-top: 4px solid #4a90e2;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #2b3e50;
        }
        
        .stat-label {
            color: #6c757d;
            font-weight: 500;
        }
    </style>
</head>
<body>
    @include('components.navbar')
    @include('components.instructor-nav')
    
    <div class="course-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-5 fw-bold mb-3">{{ $curso->titulo }}</h1>
                    <p class="lead mb-4">{{ $curso->descripcion }}</p>
                    <div class="d-flex align-items-center gap-3">
                        <span class="course-status-badge {{ $curso->fecha_publicacion ? 'status-publicado' : 'status-borrador' }}">
                            <i class="fas {{ $curso->fecha_publicacion ? 'fa-check-circle' : 'fa-edit' }} me-2"></i>
                            {{ $curso->fecha_publicacion ? 'Publicado' : 'Borrador' }}
                        </span>
                        @if($curso->fecha_publicacion)
                            <small class="text-light">
                                <i class="fas fa-calendar me-1"></i>
                                Publicado el {{ \Carbon\Carbon::parse($curso->fecha_publicacion)->format('d/m/Y') }}
                            </small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container my-5">
        <!-- Información del curso -->
        <div class="course-info-card">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="text-primary mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Información del Curso
                    </h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <strong>Categoría:</strong>
                            <p class="text-muted">{{ $curso->categoria_nombre ?? 'Sin categoría' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <strong>Precio:</strong>
                            <p class="text-success fw-bold">
                                {{ $curso->precio ? '$' . number_format($curso->precio, 2) : 'Gratis' }}
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <strong>Nivel:</strong>
                            <p class="text-muted">{{ ucfirst($curso->nivel) }}</p>
                        </div>
                        <div class="col-sm-6">
                            <strong>Duración:</strong>
                            <p class="text-muted">{{ $curso->duracion }} horas</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4 class="text-primary mb-3">
                        <i class="fas fa-chart-bar me-2"></i>
                        Estadísticas
                    </h4>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-number">{{ $totalModulos }}</div>
                            <div class="stat-label">Módulos</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">{{ $totalLecciones }}</div>
                            <div class="stat-label">Lecciones</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">{{ $totalInscripciones }}</div>
                            <div class="stat-label">Estudiantes</div>
                        </div>
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
                                <h5 class="mb-0">
                                    <i class="fas fa-folder me-2"></i>
                                    Módulo {{ $index + 1 }}: {{ $modulo->titulo }}
                                </h5>
                                @if($modulo->descripcion ?? false)
                                    <p class="mt-2 mb-0 text-light">{{ $modulo->descripcion }}</p>
                                @endif
                            </div>
                            
                            <div class="card-body">
                                @if(count($modulo->lecciones) > 0)
                                    @foreach($modulo->lecciones as $leccionIndex => $leccion)
                                        <div class="lesson-item">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="fw-bold mb-1">
                                                        <i class="fas fa-play-circle me-2 text-primary"></i>
                                                        Lección {{ $leccionIndex + 1 }}: {{ $leccion->titulo }}
                                                    </h6>
                                                    @if($leccion->descripcion ?? false)
                                                        <p class="text-muted mb-2">{{ $leccion->descripcion }}</p>
                                                    @endif
                                                    @if($leccion->duracion ?? false)
                                                        <small class="text-secondary">
                                                            <i class="fas fa-clock me-1"></i>
                                                            {{ $leccion->duracion }} minutos
                                                        </small>
                                                    @endif
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
            <div class="course-info-card text-center">
                <div class="py-5">
                    <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No hay contenido</h4>
                    <p class="text-muted">Este curso aún no tiene módulos ni lecciones.</p>
                    <a href="{{ url('/panel-instructor/cursos/' . $curso->id_curso . '/modulos') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Agregar Módulos
                    </a>
                </div>
            </div>
        @endif
        
        <!-- Acciones rápidas -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ url('/panel-instructor') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver al Panel
                    </a>
                    <a href="{{ url('/panel-instructor/cursos/' . $curso->id_curso . '/editar') }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>
                        Editar Curso
                    </a>
                    <a href="{{ url('/panel-instructor/cursos/' . $curso->id_curso . '/modulos') }}" class="btn btn-info text-white">
                        <i class="fas fa-cogs me-2"></i>
                        Gestionar Módulos
                    </a>
                    @if(!$curso->fecha_publicacion && $totalModulos > 0 && $totalLecciones > 0)
                        <button onclick="publishCourse({{ $curso->id_curso }})" class="btn btn-success">
                            <i class="fas fa-rocket me-2"></i>
                            Publicar Curso
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/instructor_logic.js') }}"></script>
</body>
</html>