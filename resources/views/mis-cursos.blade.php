<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Cursos</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Miscursos.css') }}">
    
    <style>
        .curso-card {
            transition: all 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
        }
        
        .curso-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }
        
        .curso-img {
            height: 200px;
            object-fit: cover;
        }
        
        .progreso-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            padding: 1rem;
        }
        
        .stat-item i {
            font-size: 1.2rem;
        }
        
        .curso-stats {
            border-top: 1px solid #dee2e6;
            padding-top: 1rem;
        }
    </style>
</head>

<body class="gradient-bg">

    @include('components.navbar')

    <section class="banner-section text-center py-5">
        <div class="container">
            <h1>Mis Cursos</h1>
            <p>Accede a todos los cursos en los que estás inscrito</p>
            <a href="{{ route('catalogo.privado') }}" class="btn btn-primary mt-3">
                <i class="bi bi-plus-circle"></i> Explorar más cursos
            </a>
        </div>
    </section>

    <section class="cursos-section py-5">
        <div class="container">
            <h2 class="text-center mb-2">Cursos Activos</h2>
            <p class="descripcion text-center mb-5">Continúa tu aprendizaje en los cursos que has adquirido</p>

            <!-- Aquí se cargarán los cursos dinámicamente -->
            <div class="row g-4 justify-content-center" id="mis-cursos-container">
                <!-- Los cursos se insertarán aquí desde JavaScript -->
                <div class="col-12 text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="text-muted mt-3">Cargando tus cursos...</p>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/navbar.js') }}"></script>
    <script src="{{ asset('js/comentarios.js') }}"></script>
    <script src="{{ asset('js/mis-cursos.js') }}"></script>

</body>
</html>