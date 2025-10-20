<?php
session_start();
require_once ('../functions/editRide.php' );

$cedula = $_SESSION['cedula'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Aventones | Crear Ride</title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

  
  <link rel="stylesheet" href="/css/logIn.css"/>
</head>
<body>
  <main class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="login-wrapper shadow border border-primary rounded p-4 p-md-5 text-center d-flex flex-column align-items-center gap-3" style="max-width: 700px; width:100%;">
      <h1 class="brand-title fw-bold text-primary m-0">AVENTONES</h1>
      <h2 class="h5 text-secondary m-0">Crear Ride</h2>

      <!-- FORMULARIO -->
      <form action="/functions/insertride.php" method="post" class="formulario-login text-start w-100 mt-3" style="max-width: 560px;">
        
        <!-- Nombre -->
        <div class="mb-3">
          <label for="name" class="form-label fw-bold text-dark">Nombre del Ride</label>
          <input type="text" id="name" name="name" class="form-control" placeholder="Viaje al trabajo" required>
        </div>

        <!-- Destino / Llegada -->
        <div class="row g-3">
          <div class="col-12 col-md-6">
            <label for="destination" class="form-label fw-bold text-dark">Lugar de salida</label>
            <input type="text" id="destination" name="destination" class="form-control" placeholder="San José" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="arrival" class="form-label fw-bold text-dark">Lugar de llegada</label>
            <input type="text" id="arrival" name="arrival" class="form-control" placeholder="Cartago" required>
          </div>
        </div>

        <!-- Fecha / Hora -->
        <div class="row g-3 mt-1">
          <div class="col-12 col-md-6">
            <label for="date" class="form-label fw-bold text-dark">Fecha y hora</label>
            <input type="datetime-local" id="date" name="date" class="form-control" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="space" class="form-label fw-bold text-dark">Espacios disponibles</label>
            <input type="number" id="space" name="space" min="1" class="form-control" placeholder="3" required>
          </div>
        </div>

        <!-- Costo / Vehículo -->
        <div class="row g-3 mt-1">
          <div class="col-12 col-md-6">
            <label for="space_cost" class="form-label fw-bold text-dark">Costo por espacio</label>
            <input type="text" id="space_cost" name="space_cost" class="form-control" placeholder="₡1000" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="vehicle_id" class="form-label fw-bold text-dark">Vehículo</label>
            <select id="vehicle_id" name="vehicle_id" class="form-select" required>
              <option value="">Seleccione vehículo</option>
             <?php
            
            // 🛑 PASO 3: Reemplaza el bloque PHP conflictivo con el bucle simple
            if (isset($vehicles) && is_array($vehicles)) {
            foreach ($vehicles as $vehiculo) {
            $nombre_vehiculo = htmlspecialchars($vehiculo['brand'] . ' ' . $vehiculo['model']);
            $valor_id = htmlspecialchars($vehiculo['id']);
        
        echo "<option value='{$valor_id}'>{$nombre_vehiculo}</option>";
    }
}
?>
              <!-- Aquí luego se llenará dinámicamente -->
            </select>
          </div>
        </div>

        <!-- Botón -->
        <div class="d-flex justify-content-center mt-4">
          <button type="submit" class="login-btn btn btn-primary">Crear Ride</button>
        </div>

        <!-- Link -->
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
