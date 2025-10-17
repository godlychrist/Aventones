<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Aventones | Editar Vehículo</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- Tu CSS -->
  <link rel="stylesheet" href="/css/logIn.css"/>
</head>
<body>
  <main class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="login-wrapper shadow border border-primary rounded p-4 p-md-5 text-center d-flex flex-column align-items-center gap-3" style="max-width: 700px; width:100%;">
      <h1 class="brand-title fw-bold text-primary m-0">AVENTONES</h1>
      <h2 class="h5 text-secondary m-0">Editar Vehículo</h2>

      <!-- FORMULARIO -->
      <form action="/functions/vehicle_update.php" method="post" enctype="multipart/form-data" class="formulario-login text-start w-100 mt-3" style="max-width: 560px;">

        <!-- ID oculto del vehículo (se completa dinámicamente) -->
        <input type="hidden" name="vehicle_id" value="1">

        <div class="row g-3">
          <div class="col-12 col-md-6">
            <label for="plateNum" class="form-label fw-bold text-dark">Número de placa</label>
            <input type="text" id="plateNum" name="plateNum" class="form-control" value="123456" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="color" class="form-label fw-bold text-dark">Color</label>
            <input type="text" id="color" name="color" class="form-control" value="Azul" required>
          </div>
        </div>

        <div class="row g-3 mt-1">
          <div class="col-12 col-md-6">
            <label for="brand" class="form-label fw-bold text-dark">Marca</label>
            <input type="text" id="brand" name="brand" class="form-control" value="Toyota" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="model" class="form-label fw-bold text-dark">Modelo</label>
            <input type="text" id="model" name="model" class="form-control" value="Yaris" required>
          </div>
        </div>

        <div class="row g-3 mt-1">
          <div class="col-12 col-md-6">
            <label for="year" class="form-label fw-bold text-dark">Año</label>
            <input type="number" id="year" name="year" class="form-control" value="2020" min="1900" max="2100" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="capacity" class="form-label fw-bold text-dark">Capacidad de asientos</label>
            <input type="number" id="capacity" name="capacity" class="form-control" value="4" min="1" required>
          </div>
        </div>

        <div class="mt-3">
          <label for="image" class="form-label fw-bold text-dark">Fotografía del automotor</label>
          <input type="file" id="image" name="image" class="form-control" accept="image/*">
          <small class="text-muted">Deja vacío si no deseas cambiar la foto.</small>
        </div>

        <div class="d-flex justify-content-center mt-4">
          <button type="submit" class="login-btn btn btn-primary">Guardar Cambios</button>
        </div>

        <p class="register-text text-center mt-3">
          <a href="/pages/vehicles_list.php">Volver a mis vehículos</a>
        </p>
      </form>
    </div>
  </main>

  <footer class="footer text-center mt-4">
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
