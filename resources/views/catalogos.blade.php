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

      <div class="row g-4">

        <!-- Curso 1 -->
        <div class="col-md-4">
          <div class="card promo-card h-100">
            <img src="{{ asset('img/catalogo1.jpeg') }}" alt="Curso de Python">
            <div class="card-body text-center">
              <h5>Programación en Python</h5>
              <p>Aprende a programar con uno de los lenguajes más populares del mundo.</p>
              <button class="btn btn-inscribir mt-2" data-curso-id="1">Inscribirme</button>
              <button class="btn btn-comentario" data-bs-toggle="modal" data-bs-target="#modalComentario">
                Dejar Comentario
              </button>

            </div>
          </div>
        </div>

        <!-- Curso 2 -->
        <div class="col-md-4">
          <div class="card promo-card h-100">
            <img src="{{ asset('img/catalogo2.jpg') }}" alt="Curso de Diseño UI/UX">
            <div class="card-body text-center">
              <h5>Diseño UI/UX</h5>
              <p>Crea interfaces atractivas y centradas en la experiencia del usuario.</p>
              <button class="btn btn-inscribir mt-2" data-curso-id="2">Inscribirme</button>
              <button class="btn btn-comentario" data-bs-toggle="modal" data-bs-target="#modalComentario">
                Dejar Comentario
              </button>   
              
            </div>
          </div>
        </div>

        <!-- Curso 3 -->
        <div class="col-md-4">
          <div class="card promo-card h-100">
            <img src="{{ asset('img/catalogo3.png') }}" alt="Curso de Bases de Datos">
            <div class="card-body text-center">
              <h5>Bases de Datos con MySQL</h5>
              <p>Aprende a diseñar, consultar y administrar bases de datos.</p>
              <button class="btn btn-inscribir mt-2" data-curso-id="3">Inscribirme</button>
              <button class="btn btn-comentario" data-bs-toggle="modal" data-bs-target="#modalComentario">
                Dejar Comentario
              </button>
            </div>
          </div>
        </div>

      </div>

      <div class="row g-4 mt-4">

        <!-- Curso 4 -->
        <div class="col-md-4">
          <div class="card promo-card h-100">
            <img src="{{ asset('img/catalogo4.jpeg') }}" alt="Curso de JavaScript">
            <div class="card-body text-center">
              <h5>JavaScript Moderno</h5>
              <p>Crea sitios web dinámicos e interactivos con JS moderno.</p>
              <button class="btn btn-inscribir mt-2" data-curso-id="4">Inscribirme</button>
              <button class="btn btn-comentario" data-bs-toggle="modal" data-bs-target="#modalComentario">
                Dejar Comentario
              </button>
            </div>
          </div>
        </div>

        <!-- Curso 5 -->
        <div class="col-md-4">
          <div class="card promo-card h-100">
            <img src="{{ asset('img/catalogo5.jpeg') }}" alt="Curso de Marketing Digital">
            <div class="card-body text-center">
              <h5>Marketing Digital</h5>
              <p>Domina las estrategias para crecer en redes sociales y posicionamiento web.</p>
              <button class="btn btn-inscribir mt-2" data-curso-id="5">Inscribirme</button>
              <button class="btn btn-comentario" data-bs-toggle="modal" data-bs-target="#modalComentario">
              Dejar Comentario
              </button>
            </div>
          </div>
        </div>

        <!-- Curso 6 -->
        <div class="col-md-4">
          <div class="card promo-card h-100">
            <img src="{{ asset('img/catalogo6.jpeg') }}" alt="Curso de Excel Avanzado">
            <div class="card-body text-center">
              <h5>Excel Avanzado</h5>
              <p>Aprende fórmulas, tablas dinámicas y automatiza tus tareas.</p>
              <button class="btn btn-inscribir mt-2" data-curso-id="6">Inscribirme</button>
              <button class="btn btn-comentario" data-bs-toggle="modal" data-bs-target="#modalComentario">
                Dejar Comentario
              </button>
            </div>
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
  <script src="{{ asset('js/script-catalogo.js') }}"></script>
  <script src="{{ asset('js/inscribir.js') }}" defer></script>


@include('components.comentarios')

</body>
</html>