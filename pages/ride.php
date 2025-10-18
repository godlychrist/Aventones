<?php

$ok  = $_GET['ok']  ?? '';
$err = $_GET['err'] ?? '';


$rides = $rides ?? []; 

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Mis Rides - Aventones</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- CSS opcional (usa el tuyo) -->
  <link rel="stylesheet" href="/css/logIn.css" />
  <!-- Si tienes un CSS específico para esta página, descomenta: -->
  <!-- <link rel="stylesheet" href="/css/RidesR.css" /> -->
</head>
<body>
  <div class="wrapper container-fluid px-3">
    <header class="main-header text-center my-3">
      <!-- Pon tu logo si lo tienes -->
      <!-- <img src="/images/Logo.png" alt="Logo Aventones" class="logo-header img-fluid" style="max-height:64px;" /> -->
      <div class="header-box mt-3">
        <div class="header-content d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
          <nav class="nav-bar d-flex flex-column flex-sm-row align-items-center gap-3">
            <a href="/pages/main.php">Panel</a>
            <a href="/pages/rides.php" class="fw-bold">Rides</a>
            <a href="/pages/bookings.php">Bookings</a>
          </nav>
          <div class="d-flex align-items-center gap-3">
            <a href="/pages/profile.php" class="btn btn-sm btn-outline-secondary">Perfil</a>
            <a href="/index.php" class="btn btn-sm btn-outline-secondary">Logout</a>
          </div>
        </div>
      </div>
    </header>

    <main class="container">
      <div class="content-body">
        <h2 class="title text-center">My rides</h2>
        <hr class="divider" />

        <?php if ($ok): ?>
          <div class="alert alert-success"><?= htmlspecialchars($ok) ?></div>
        <?php endif; ?>
        <?php if ($err): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
        <?php endif; ?>

        <div class="d-flex justify-content-end mb-3">
          <a href="/pages/ride_create.php" class="btn btn-primary">➕ New Ride</a>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th>Nombre del Ride</th>
                <th>Lugar de salida</th>
                <th>Lugar de llegada</th>
                <th>Fecha y hora</th>
                <th>Espacios disponibles</th>
                <th>Costo por espacio</th>
                <th>Vehículo</th>
                <th style="width: 180px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($rides)): ?>
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">
                    No tienes rides creados todavía.
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($rides as $r): ?>
                  <tr>
                    <td><?= htmlspecialchars($r['name'] ?? '') ?></td>
                    <td><?= htmlspecialchars($r['destination'] ?? '') ?></td>
                    <td><?= htmlspecialchars($r['leaving'] ?? '') ?></td>
                    <td><?= htmlspecialchars($r['space'] ?? '') ?></td>
                    <td><?= htmlspecialchars($r['platenumber'] ?? '') ?></td>
                    <td><?= htmlspecialchars($r['space_cost'] ?? '') ?></td>
                     <td><?= htmlspecialchars($r['dayxhour'] ?? '') ?></td>
                    <td>
                      <div class="d-flex gap-2">
                        <!-- Editar: solo link (sin funcionalidad) -->
                        <a class="btn btn-sm btn-outline-primary"
                           href="/pages/edit_rides.php?id=<?= urlencode((string)($r['id'] ?? 0)) ?>">
                          ✏️ Edit
                        </a>

                        <!-- Eliminar: ÚNICO funcional (form POST) -->
                        <form action="/functions/rides_delete.php" method="post" onsubmit="return confirm('¿Eliminar este ride?');">
                          <input type="hidden" name="ride_id" value="<?= htmlspecialchars((string)($r['id'] ?? 0)) ?>">
                          <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Delete</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>

    <footer class="footer text-center mt-4">
      <nav class="footer-nav mb-2">
        <a href="/pages/main.php">Panel</a> |
        <a href="/pages/rides.php" class="fw-bold">Rides</a> |
        <a href="/pages/bookings.php">Bookings</a> |
        <a href="/index.php">Login</a> |
        <a href="/pages/registration_driver.php">Register</a>
      </nav>
      <p class="footer-copy">© Aventones.com</p>
    </footer>
  </div>
</body>
</html>
