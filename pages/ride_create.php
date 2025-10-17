
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Aventones | Editar Ride</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- Tu CSS -->
  <link rel="stylesheet" href="/css/logIn.css"/>
</head>
<body>
  <main class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="login-wrapper shadow border border-primary rounded p-4 p-md-5 text-center d-flex flex-column align-items-center gap-3" style="max-width: 700px; width:100%;">
      <h1 class="brand-title fw-bold text-primary m-0">AVENTONES</h1>
      <h2 class="h5 text-secondary m-0">Editar Ride</h2>

      <!-- FORMULARIO -->
      <form action="/functions/rides_update.php" method="post" class="formulario-login text-start w-100 mt-3" style="max-width: 560px;">
        
        <!-- ID oculto -->
        <input type="hidden" name="ride_id" value="1"><!-- Se llenará dinámicamente -->

        <!-- Nombre -->
        <div class="mb-3">
          <label for="name" class="form-label fw-bold text-dark">Nombre del Ride</label>
          <input type="text" id="name" name="name" class="form-control" placeholder="Viaje al trabajo" value="Viaje al trabajo" required>
        </div>

        
        <div class="row g-3">
          <div class="col-12 col-md-6">
            <label for="destination" class="form-label fw-bold text-dark">Lugar de salida</label>
            <input type="text" id="destination" name="destination" class="form-control" placeholder="San José" value="San José" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="arrival" class="form-label fw-bold text-dark">Lugar de llegada</label>
            <input type="text" id="arrival" name="arrival" class="form-control" placeholder="Cartago" value="Cartago" required>
          </div>
        </div>

       
        <div class="row g-3 mt-1">
          <div class="col-12 col-md-6">
            <label for="date" class="form-label fw-bold text-dark">Fecha y hora</label>
            <input type="datetime-local" id="date" name="date" class="form-control" value="2025-10-17T08:00" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="space" class="form-label fw-bold text-dark">Espacios disponibles</label>
            <input type="number" id="space" name="space" class="form-control" value="3" required>
          </div>
        </div>

        
        <div class="row g-3 mt-1">
          <div class="col-12 col-md-6">
            <label for="space_cost" class="form-label fw-bold text-dark">Costo por espacio</label>
            <input type="text" id="space_cost" name="space_cost" class="form-control" value="1000" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="vehicle_id" class="form-label fw-bold text-dark">Vehículo</label>
            <select id="vehicle_id" name="vehicle_id" class="form-select" required>
              <option value="1" selected>Toyota Corolla</option>
              <option value="2">Hyundai Tucson</option>
            </select>
          </div>
        </div>

        <
        <div class="d-flex justify-content-center mt-4">
          <button type="submit" class="login-btn btn btn-primary">Guardar Cambios</button>
        </div>

       
        <p class="register-text text-center mt-3">
          <a href="/pages/rides_list.php">Volver a mis Rides</a>
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
