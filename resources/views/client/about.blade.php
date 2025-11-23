<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <title>Sobre Nosotros - Cursos</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/about.css') }}">
</head>
<body>
@include('components.navbar')

  <section class="hero-about d-flex align-items-center">
    <div class="container text-center">
      <h1 class="display-4">Conoce Nuestra Historia</h1>
      <p class="lead my-3">Somos más que una plataforma, somos una comunidad de aprendizaje.</p>
    </div>
  </section>

  <section class="bg-primary-purple values-section-spacing"> 
    <div class="container">
      <h2 class="fw-bold text-center text-white mb-5">Nuestros Valores</h2>
      
      <div class="row g-4">
        <div class="col-lg-4 col-md-6">
          <div class="value-card">
            <h4>Innovación</h4>
            <p>Fomentamos la creatividad en cada curso, buscando nuevas formas de enseñar y aprender para mantenernos siempre a la vanguardia.</p>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-6">
          <div class="value-card">
            <h4>Colaboración</h4>
            <p>Creemos en el poder de trabajar juntos. Creamos una comunidad donde se comparten conocimientos y experiencias.</p>
          </div>
        </div>

        <div class="col-lg-4 col-md-6">
          <div class="value-card">
            <h4>Accesibilidad</h4>
            <p>Garantizamos una educación en línea disponible para todos, sin importar el lugar o el tiempo, rompiendo barreras.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section-container"> 
    <div class="container">
      <div class="content-card shadow-lg">
        <div class="flex-grow-1">
          <h2 class="fw-bold text-purple mb-3">Nuestro Enfoque Práctico</h2>
          <p class="lead mb-3">
            Somos más que una plataforma; somos una comunidad de aprendizaje flexible. Nuestra filosofía se centra en la mentoría directa de expertos y recursos actualizados que te permiten estudiar a tu propio ritmo.
          </p>
          <p class="mb-4">
            Con este enfoque, garantizamos que el aprendizaje sea accesible y efectivo. Únete a miles de alumnos que están transformando su futuro profesional a través de nuestra metodología práctica.
          </p>
          <a href="{{route('promociones')}}" class="btn btn-outline-custom btn-lg">
            Ver nuestras promociones
          </a>
        </div>

        <div class="image-small-container">
          <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1471&q=80" 
               alt="Estudiantes colaborando" />
        </div>
      </div>
    </div>
  </section>

  <footer class="text-white text-center py-4">
    <div class="container">
      <p class="mb-0">© 2025 Cursos - Todos los derechos reservados</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
