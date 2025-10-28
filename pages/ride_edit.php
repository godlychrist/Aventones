<?php
// /pages/ride_edit.php
session_start();
if (empty($_SESSION['cedula'])) {
  header('Location: /index.php?err=session'); exit;
}
$cedula = $_SESSION['cedula']; // Mantener como está en sesión

require_once __DIR__ . '/../common/connection.php';

// Datos recibidos por GET (del listado) - TRIM para eliminar espacios
$ride_id     = isset($_GET['id']) ? (int)trim($_GET['id']) : 0;
$name        = trim($_GET['name'] ?? '');
$destination = trim($_GET['destination'] ?? '');
$arrival     = trim($_GET['arrival'] ?? '');
$date        = trim($_GET['date'] ?? '');
$space       = isset($_GET['space']) ? (int)trim($_GET['space']) : 1;
$space_cost  = trim($_GET['space_cost'] ?? '');
$vehicle_id  = isset($_GET['vehicle_id']) ? (int)trim($_GET['vehicle_id']) : 0;

// Validar que ride_id exista
if ($ride_id <= 0) {
  header('Location: /functions/showride.php?err=invalid_ride_id');
  exit;
}

// Normalizar fecha para input datetime-local (YYYY-MM-DDTHH:MM)
if (!empty($date)) {
  $date = str_replace(' ', 'T', substr($date, 0, 16));
}

// Cargar vehículos del usuario
$vehicles = [];
$sql = "SELECT id, brand, model, capacity FROM vehicles WHERE user_id = ? ORDER BY brand, model";
if ($st = mysqli_prepare($conn, $sql)) {
  mysqli_stmt_bind_param($st, "s", $cedula); // "s" porque cedula puede ser string
  mysqli_stmt_execute($st);
  $res = mysqli_stmt_get_result($st);
  while ($row = mysqli_fetch_assoc($res)) {
    $vehicles[] = $row;
  }
  mysqli_stmt_close($st);
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="es">  
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Aventones | Editar Ride</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="/css/logIn.css"/>
</head>
<body>
  <main class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="login-wrapper shadow border border-primary rounded p-4 p-md-5 text-center d-flex flex-column align-items-center gap-3" style="max-width: 700px; width:100%;">
      <h1 class="brand-title fw-bold text-primary m-0">AVENTONES</h1>
      <h2 class="h5 text-secondary m-0">Editar Ride</h2>

      <form action="/functions/editRide.php" method="post" class="formulario-login text-start w-100 mt-3" style="max-width: 560px;">

        <input type="hidden" name="ride_id" value="<?= htmlspecialchars((string)$ride_id) ?>">

        <div class="mb-3">
          <label for="name" class="form-label fw-bold text-dark">Nombre del Ride</label>
          <input type="text" id="name" name="name" class="form-control"
                 value="<?= htmlspecialchars($name) ?>" required>
        </div>

        <div class="row g-3">
          <div class="col-12 col-md-6">
            <label for="destination" class="form-label fw-bold text-dark">Lugar de salida</label>
            <input type="text" id="destination" name="destination" class="form-control"
                   value="<?= htmlspecialchars($destination) ?>" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="arrival" class="form-label fw-bold text-dark">Lugar de llegada</label>
            <input type="text" id="arrival" name="arrival" class="form-control"
                   value="<?= htmlspecialchars($arrival) ?>" required>
          </div>
        </div>

        <div class="row g-3 mt-1">
          <div class="col-12 col-md-6">
            <label for="date" class="form-label fw-bold text-dark">Fecha y hora</label>
            <input type="datetime-local" id="date" name="date" class="form-control"
                   value="<?= htmlspecialchars($date) ?>" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="space" class="form-label fw-bold text-dark">Espacios disponibles</label>
            <input type="number" id="space" name="space" class="form-control"
                   min="1" max="4" value="<?= htmlspecialchars((string)$space) ?>" required>
            <small class="text-muted">Máximo 4, también validado contra la capacidad del vehículo.</small>
          </div>
        </div>

        <div class="row g-3 mt-1">
          <div class="col-12 col-md-6">
            <label for="space_cost" class="form-label fw-bold text-dark">Costo por espacio</label>
            <input type="text" id="space_cost" name="space_cost" class="form-control"
                   value="<?= htmlspecialchars($space_cost) ?>" required>
          </div>

          <div class="col-12 col-md-6">
            <label for="vehicle_id" class="form-label fw-bold text-dark">Vehículo</label>
            <select id="vehicle_id" name="vehicle_id" class="form-select" required>
              <option value="">-- Seleccione un vehículo --</option>
              <?php foreach ($vehicles as $v): 
                  $selected = ($vehicle_id === (int)$v['id']) ? 'selected' : '';
              ?>
                <option value="<?= htmlspecialchars($v['id']) ?>"
                        data-capacity="<?= (int)$v['capacity'] ?>"
                        <?= $selected ?>>
                  <?= htmlspecialchars($v['brand'] . ' ' . $v['model']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
          <button type="submit" class="login-btn btn btn-primary">Guardar Cambios</button>
        </div>

        <p class="register-text text-center mt-3">
          <a href="/functions/showride.php">Volver a mis Rides</a>
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

  <script>
    // Ajusta el máximo de "space" según capacidad del vehículo (y límite 4)
    const vehicleSelect = document.getElementById('vehicle_id');
    const spaceInput = document.getElementById('space');
    function adjustMax() {
      const cap = parseInt(vehicleSelect.selectedOptions[0]?.dataset.capacity || '4', 10);
      const maxAllowed = Math.min(4, isNaN(cap) ? 4 : cap);
      spaceInput.max = String(maxAllowed);
      if (parseInt(spaceInput.value || '0', 10) > maxAllowed) {
        spaceInput.value = String(maxAllowed);
      }
    }
    vehicleSelect?.addEventListener('change', adjustMax);
    adjustMax(); // al cargar
  </script>
</body>
</html>