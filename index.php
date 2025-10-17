<?php
// /pages/login.php
ini_set('display_errors', 1); // quita en prod
error_reporting(E_ALL);

session_start();
if (!empty($_SESSION['cedula'])) {
  header('Location: /principal.php');
  exit;
}

// Mensajes por ?err=
$alert = '';
if (isset($_GET['err'])) {
  switch ($_GET['err']) {
    case 'pendiente':
      $alert = 'Tu cuenta está <strong>Pendiente</strong>. Revisa tu correo y activa la cuenta.';
      break;
    case 'inactivo':
      $alert = 'Tu cuenta está <strong>Inactiva</strong>. Contacta al administrador.';
      break;
    case 'cred':
    default:
      $alert = 'Cédula o contraseña incorrectos.';
      break;
  }
}

// Mensaje de éxito (por ejemplo, después de activar cuenta)
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

      <?php if ($alert): ?>
        <div class="alert alert-info w-100 text-start mt-3" role="alert">
          <?= $alert ?>
        </div>
      <?php endif; ?>

      <form action="/functions/login.php" method="post" class="formulario-login text-start w-100 mt-3">
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
</body>
</html>
