<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Si YA hay sesión, no tiene sentido mostrar el login
if (!empty($_SESSION['cedula'])) {
  header('Location: /pages/main.php');
  exit();
}

// Mensaje de éxito opcional (por ejemplo, después de activar cuenta)
$alert = '';
if (isset($_GET['ok']) && $_GET['ok'] === 'activated') {
  $alert = '✅ Tu cuenta fue activada. Ya puedes iniciar sesión.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aventones | Login</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- Tu CSS -->
  <link rel="stylesheet" href="/css/logIn.css">
</head>
<body>
  <main class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="login-wrapper shadow border border-primary rounded p-4 p-md-5 text-center d-flex flex-column align-items-center gap-3" style="max-width: 460px; width:100%;">
      <h1 class="brand-title fw-bold text-primary m-0">AVENTONES</h1>

      <noscript>
        <div class="alert alert-warning w-100 text-start mt-3">
          Para iniciar sesión necesitas habilitar JavaScript.
        </div>
      </noscript>

      <div id="alertBox" class="alert w-100 text-start mt-3 d-none" role="alert"></div>

      <?php if ($alert): ?>
        <div class="alert alert-info w-100 text-start mt-3" role="alert">
          <?= $alert ?>
        </div>
      <?php endif; ?>

      <!-- El submit lo maneja /js/login.js -->
      <form id="loginForm" class="formulario-login text-start w-100 mt-3" novalidate>
        <div class="mb-3">
          <label for="cedula" class="form-label fw-bold text-dark">Cédula</label>
          <input type="text" id="cedula" name="cedula" class="form-control" placeholder="1-2345-6789" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label fw-bold text-dark">Contraseña</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="********" required>
        </div>

        <p class="register-text mb-1">
          ¿Quieres conducir? <a href="/pages/registration_driver.php">Regístrate como conductor</a>
        </p>
        <p class="register-text">
          ¿Solo deseas viajar? <a href="/pages/registration_passenger.php">Regístrate como pasajero</a>
        </p>

        <div class="d-flex justify-content-center mt-3">
          <button type="submit" class="login-btn btn btn-primary">Login</button>
        </div>
      </form>
    </div>
  </main>

  <footer class="footer text-center mt-4">
    <nav class="footer-nav mb-2">
      <a href="/pages/public_rides.php">Rides</a> |
      <a href="/pages/login.php">Login</a> |
      <a href="/pages/registration_passenger.php">Registro Pasajero</a> |
      <a href="/pages/registration_driver.php">Registro Conductor</a>
    </nav>
    <p class="footer-copy">© Aventones.com</p>
  </footer>

  <!-- JS de login (externo) -->
  <script src="/js/login.js"></script>
</body>
</html>