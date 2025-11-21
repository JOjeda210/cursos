<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Iniciar Sesión - Mi Aula</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Tipografía -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
  @include('components.navbar')
  <section class="banner">
    <h1>Inicio de Sesión</h1>
    <p>Accede a tu cuenta y continúa aprendiendo con Mi Aula</p>
  </section>

  <section class="login">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card form-card">
            <div class="card-body">
              <h3 class="text-center mb-4">Iniciar Sesión</h3>

              <form id="formLogin">
                <div class="mb-3">
                  <label for="correo" class="form-label">Correo electrónico</label>
                  <input type="email" class="form-control" id="correo" required>
                </div>

                <div class="mb-3">
                  <label for="contrasena" class="form-label">Contraseña</label>
                  <input type="password" class="form-control" id="contrasena" required>
                </div>

                <button type="submit" class="btn btn-miaula w-100">Entrar</button>

                <p class="text-center mt-3">
                  ¿No tienes una cuenta?
                  <a href="{{route('registro')}}" class="link">Regístrate aquí</a>
                </p>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    © 2025 Cursos - Todos los derechos reservados.
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS personalizado -->
  <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
