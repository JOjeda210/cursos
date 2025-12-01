<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro Instructor - Mi Aula</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
</head>

<body>
  @include('components.navbar')

  <section class="banner">
    <h1>Registro de Instructor</h1>
    <p>Crea tu cuenta como instructor y comparte tu conocimiento</p>
  </section>

  <section class="registro">
    <div class="container">
      <div class="registro-box">
        <h2 class="text-center mb-4">Completa tus datos</h2>
        
        <form id="registroInstructorForm">
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required>
            </div>
            <div class="col-md-6">
              <label for="apellido" class="form-label">Apellido</label>
              <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingresa tu apellido" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@correo.com" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Crea una contraseña segura" required>
          </div>

          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirma tu contraseña" required>
          </div>

          <button type="submit" class="btn btn-registrar w-100">Registrarme como Instructor</button>
        </form>

        <p class="text-center mt-3">
          ¿Ya tienes una cuenta? <a href="/login">Inicia sesión aquí</a>
        </p>
        <p class="text-center">
          ¿Eres estudiante? <a href="/registro">Regístrate como estudiante</a>
        </p>

        <div id="mensajeRegistro" class="mt-3"></div>
      </div>
    </div>
  </section>

  <footer>
    © 2025 Cursos - Todos los derechos reservados.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/registro-instructor.js') }}"></script>
</body>
</html>
