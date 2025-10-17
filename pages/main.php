
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aventones | Panel</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Tu CSS -->
  <link rel="stylesheet" href="/css/logIn.css">
</head>
<body>
  <main class="container d-flex flex-column justify-content-center align-items-center min-vh-100 text-center">
    <h1 class="brand-title fw-bold text-primary mb-4">AVENTONES</h1>
    <h2 class="text-secondary mb-5">Panel principal</h2>

    <!-- Botones principales -->
    <div class="d-flex flex-column flex-md-row flex-wrap justify-content-center gap-3">
      <!-- Rides -->
      <a href="/pages/ride_create.php" class="btn btn-primary btn-lg px-5">
        ➕ Crear Ride
      </a>
      <a href="/pages/ride_edit.php" class="btn btn-outline-primary btn-lg px-5">
        ✏️ Editar Ride
      </a>

      <!-- Vehículos -->
      <a href="/pages/vehicle_create.php" class="btn btn-success btn-lg px-5">
        🚗 Crear Vehículo
      </a>
      <a href="/pages/vehicle_edit.php" class="btn btn-outline-success btn-lg px-5">
        🛠️ Editar Vehículo
      </a>

      <!-- Perfil -->
      <a href="/pages/profile.php" class="btn btn-info btn-lg px-5 text-white">
        👤 Ver Perfil
      </a>
    </div>

    <div class="mt-5">
      <a href="/index.php" class="btn btn-link text-secondary">Cerrar sesión</a>
    </div>
  </main>

  <footer class="footer text-center mt-5">
    <nav class="footer-nav mb-2">
      <a href="/pages/public_rides.php">Rides</a> |
      <a href="/index.php">Login</a> |
      <a href="/pages/registration_passenger.php">Registro Pasajero</a> |
      <a href="/pages/registration_driver.php">Registro Conductor</a>
    </nav>
    <p class="footer-copy">© Aventones.com</p>
  </footer>
</body>
</html>




