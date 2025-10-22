<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
if (empty($_SESSION['cedula'])) {
  header('Location: /index.php?err=session'); exit;
}
$cedula = (int)$_SESSION['cedula'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Aventones | Crear Vehículo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="/css/logIn.css"/>
</head>
<body class="bg-light">
  <main class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="login-wrapper shadow border border-primary rounded p-4 p-md-5 text-center d-flex flex-column align-items-center gap-3" style="max-width: 700px; width:100%;">
      <h1 class="brand-title fw-bold text-primary m-0">AVENTONES</h1>
      <h2 class="h5 text-secondary m-0">Crear Vehículo</h2>

      <form action="/functions/insertvehicle.php" method="post" enctype="multipart/form-data" class="formulario-login text-start w-100 mt-3" style="max-width: 560px;">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars((string)$cedula) ?>">

        <div class="row g-3">
          <div class="col-12 col-md-6">
            <label for="plateNum" class="form-label fw-bold text-dark">Número de placa</label>
            <input type="text" id="plateNum" name="plateNum" class="form-control" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="color" class="form-label fw-bold text-dark">Color</label>
            <input type="text" id="color" name="color" class="form-control" required>
          </div>
        </div>

        <div class="row g-3 mt-1">
          <div class="col-12 col-md-6">
            <label for="brand" class="form-label fw-bold text-dark">Marca</label>
            <input type="text" id="brand" name="brand" class="form-control" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="model" class="form-label fw-bold text-dark">Modelo</label>
            <input type="text" id="model" name="model" class="form-control" required>
          </div>
        </div>

        <div class="row g-3 mt-1">
          <div class="col-12 col-md-6">
            <label for="year" class="form-label fw-bold text-dark">Año</label>
            <input type="date" id="year" name="year" class="form-control" required>
          </div>
          <div class="col-12 col-md-6">
            <label for="capacity" class="form-label fw-bold text-dark">Capacidad de asientos</label>
            <input type="number" id="capacity" name="capacity" min="1" max="4" class="form-control" required>
            <small class="text-muted">De 1 a 4 asientos.</small>
          </div>
        </div>

        <div class="mt-3">
          <label for="image" class="form-label fw-bold text-dark">Fotografía del automotor</label>
          <input type="file" id="image" name="image" class="form-control" accept="image/*">
        </div>

        <div class="d-flex justify-content-center mt-4">
          <button type="submit" class="login-btn btn btn-success">Crear vehículo</button>
        </div>

        <p class="register-text text-center mt-3">
          <a href="/functions/showvehicle.php">Volver a mis vehículos</a>
        </p>
      </form>
    </div>
  </main>

  <!-- JS externo que “clampa” capacity a 1..4 -->
  <script src="/js/vehicle_form.js"></script>
</body>
</html>
