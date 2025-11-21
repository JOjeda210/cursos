<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro - Mi Aula</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
</head>

<body>
  @include('components.navbar')

  <section class="banner">
    <h1>Registro de Usuario</h1>
    <p>Crea tu cuenta para acceder a todos los cursos</p>
  </section>

  <section class="registro">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card form-card">
            <div class="card-body">
              <h3 class="text-center mb-4">Formulario de Registro</h3>

              <form id="formRegistro">
                <div class="mb-3">
                  <label for="nombre" class="form-label">Nombre</label>
                  <input type="text" class="form-control" id="nombre" required>
                </div>

                <div class="mb-3">
                  <label for="apellido" class="form-label">Apellido</label>
                  <input type="text" class="form-control" id="apellido" required>
                </div>

                <div class="mb-3">
                  <label for="correo" class="form-label">Correo electrónico</label>
                  <input type="email" class="form-control" id="correo" required>
                </div>

                <div class="mb-3">
                  <label for="contrasena" class="form-label">Contraseña</label>
                  <input type="password" class="form-control" id="contrasena" required>
                </div>

                <div class="mb-3">
                  <label for="confirmar" class="form-label">Confirmar contraseña</label>
                  <input type="password" class="form-control" id="confirmar" required>
                </div>

                <button type="submit" class="btn btn-miaula w-100">Registrarse</button>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/registro.js') }}"></script>
</body>
</html>
