<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <title>Aventones | Registro</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- Tu CSS (mismo que el del login) -->
  <link rel="stylesheet" href="/css/logIn.css"/>
</head>
<body>
  <main class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="login-wrapper shadow border border-primary rounded p-4 p-md-5 text-center d-flex flex-column align-items-center gap-3" style="max-width: 700px; width:100%;">
      <h1 class="brand-title fw-bold text-primary m-0">AVENTONES</h1>
      <h2 class="h5 text-secondary m-0">Registro Conductores</h2>

      <!-- FORMULARIO -->
      <form action="/functions/insertDriver.php" method="post" enctype="multipart/form-data" class="formulario-login text-start w-100 mt-3" style="max-width: 560px;">
        <!-- Nombres / Apellidos -->
        <div class="row g-3">
          <div class="col-12 col-md-6">
            <label for="name" class="form-label fw-bold text-dark">Nombre</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Juan" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="lastName" class="form-label fw-bold text-dark">Apellidos</label>
            <input type="text" id="lastName" name="lastName" class="form-control" placeholder="Pérez Solano" required>
          </div>
        </div>

        <!-- Cédula / Fecha Nacimiento -->
        <div class="row g-3 mt-1">
          <div class="col-12 col-md-6">
            <label for="cedula" class="form-label fw-bold text-dark">Cédula</label>
            <input type="text" id="cedula" name="cedula" class="form-control" placeholder="1-2345-6789" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="fecha_nac" class="form-label fw-bold text-dark">Fecha de Nacimiento</label>
            <input type="date" id="fecha_nac" name="fecha_nac" class="form-control" required>
          </div>
        </div>

        <!-- Correo / Teléfono -->
        <div class="row g-3 mt-1">
          <div class="col-12 col-md-6">
            <label for="correo" class="form-label fw-bold text-dark">Correo</label>
            <input type="email" id="correo" name="correo" class="form-control" placeholder="tu@correo.com" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="telefono" class="form-label fw-bold text-dark">Teléfono</label>
            <input type="tel" id="telefono" name="telefono" class="form-control" placeholder="8888-8888" required>
          </div>
        </div>

        <!-- Foto -->
        <div class="mt-3">
          <label for="foto" class="form-label fw-bold text-dark">Fotografía Personal</label>
          <input type="file" id="foto" name="foto" class="form-control" accept="image/*" required>
        </div>

        <!-- Password / Confirmación -->
        <div class="row g-3 mt-1">
          <div class="col-12 col-md-6">
            <label for="password" class="form-label fw-bold text-dark">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="********" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="password_confirm" class="form-label fw-bold text-dark">Repeat Password</label>
            <input type="password" id="password_confirm" name="password_confirm" class="form-control" placeholder="********" required>
          </div>
        </div>

        <!-- Acciones -->
        <div class="d-flex justify-content-center mt-4">
          <button type="submit" class="login-btn btn btn-primary">Register</button>
        </div>

        <!-- Links auxiliares -->
        <p class="register-text text-center mt-3">
          ¿Ya tienes cuenta? <a href="../index.php">Inicia sesión</a>
        </p>
      </form>
    </div>
  </main>

  <footer class="footer text-center mt-4">
    <nav class="footer-nav mb-2">
      <a href="/pages/public_rides.php">Rides</a> |
      <a href="../index_php">Login</a> |
      <a href="/pages/registration_passenger.php">Registro Pasajero</a> |
      <a href="/pages/registration_driver.php">Registro Conductor</a>
    </nav>
    <p class="footer-copy">© Aventones.com</p>
  </footer>
</body>
</html>
