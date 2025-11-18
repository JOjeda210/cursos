<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Cursos</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/Miscursos.css') }}">
</head>

<body class="gradient-bg">

    <section class="banner-section text-center py-5">
        <div class="container">
            <h1>Mis Cursos</h1>
            <p>Accede a todos los cursos en los que estás inscrito</p>
        </div>
    </section>

    <section class="cursos-section py-5">
        <div class="container">
            <h2 class="text-center mb-2">Cursos Activos</h2>
            <p class="descripcion text-center mb-5">Continúa tu aprendizaje en los cursos que has adquirido</p>

            <!-- Aquí se cargarán los cursos dinámicamente -->
            <div class="row g-4 justify-content-center" id="cursos-container">
                <!-- Los cursos se insertarán aquí desde JavaScript -->
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/mis_cursos.js') }}"></script>

</body>
</html>