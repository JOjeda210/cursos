<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Promociones - Mi Aula</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Tipografía -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>  

  <section class="banner">
    <h1>¡Cursos en Promoción Limitada!</h1>
    <p>Aprovecha descuentos especiales en tus cursos favoritos de Mi Aula</p>
  </section>

  <section class="promociones">
    <div class="container">
      <h2>Promociones destacadas</h2>
      <p class="descripcion">Aprende desde cualquier lugar con precios reducidos por tiempo limitado</p>
      <button class="btn btn-comentario" data-bs-toggle="modal" data-bs-target="#modalComentario">
          Dejar Comentario
      </button>

      <div class="row g-4">

        <!-- Curso 1 -->
        <div class="col-md-4">
          <div class="card promo-card h-100">
            <img src="{{ asset('img/1.jpeg') }}" alt="Curso de programación">
            <div class="card-body text-center">
              <h5>Introducción a la Programación</h5>
              <p class="precio-anterior">$999 MXN</p>
              <p class="precio-oferta">$499 MXN</p>
              <button class="btn btn-miaula mt-2">Inscribirme</button>
            </div>
          </div>
        </div>

        <!-- Curso 2 -->
        <div class="col-md-4">
          <div class="card promo-card h-100">
            <img src="{{ asset('img/3.jpeg') }}" alt="Curso de diseño web">
            <div class="card-body text-center">
              <h5>Diseño Web Profesional</h5>
              <p class="precio-anterior">$1,200 MXN</p>
              <p class="precio-oferta">$600 MXN</p>
              <button class="btn btn-miaula mt-2">Inscribirme</button>
            </div>
          </div>
        </div>

        <!-- Curso 3 -->
        <div class="col-md-4">
          <div class="card promo-card h-100">
            <img src="{{ asset('img/images.jpeg') }}" alt="Curso de marketing">
            <div class="card-body text-center">
              <h5>Marketing Digital Avanzado</h5>
              <p class="precio-anterior">$850 MXN</p>
              <p class="precio-oferta">$425 MXN</p>
              <button class="btn btn-miaula mt-2">Inscribirme</button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    © 2025 Mi Aula - Todos los derechos reservados.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
