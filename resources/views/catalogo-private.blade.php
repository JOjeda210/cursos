<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Catálogo </title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Tipografía -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/catalogo.css') }}">
  <link rel="stylesheet" href="{{ asset('css/comentarios.css') }}">
</head>

<body>  

  @include('components.navbar')

  <section class="banner">
    <h1>Catálogo de Cursos</h1>
    <p>Explora todos los cursos disponibles en mis cursos </p>
  </section>

  <section class="promociones">
    <div class="container">
      <h2>Cursos Disponibles</h2>
      <p class="descripcion">Encuentra el curso ideal para ti y sigue aprendiendo a tu ritmo</p>

      <!-- Contenedor donde se cargarán los cursos dinámicamente -->
      <div id="cursos-catalogo" class="row g-4">
        <div class="col-12 text-center">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Cargando cursos...</span>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- Footer -->
  <footer>
    © 2025 Cursos - Todos los derechos reservados.
  </footer>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/navbar.js') }}"></script>
  <script src="{{ asset('js/catalogo-private.js') }}"></script>
  <script src="{{ asset('js/comentarios.js') }}" defer></script>

  <!-- Modal de Comentarios Global -->
  <x-comentarios />

</body>
</html>