<?php

$ok  = $_GET['ok']  ?? '';
$err = $_GET['err'] ?? '';

$vehicles = $vehicles ?? [];

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Mis Vehículos - Aventones</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Tu CSS -->
  <link rel="stylesheet" href="/css/logIn.css" />
</head>
<body>
  <div class="wrapper container-fluid px-3">
    <header class="main-header text-center my-3">
      <div class="header-box mt-3">
        <div class="header-content d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
          <nav class="nav-bar d-flex flex-column flex-sm-row align-items-center gap-3">
            <a href="/pages/main.php">Panel</a>
            <a href="/pages/rides.php">Rides</a>
            <a href="/pages/vehicles.php" class="fw-bold">Vehículos</a>
            <a href="/pages/bookings.php">Reservas</a>
          </nav>
          <div class="d-flex align-items-center gap-3">
            <a href="/pages/profile.php" class="btn btn-sm btn-outline-secondary">Perfil</a>
            <a href="/index.php" class="btn btn-sm btn-outline-secondary">Cerrar sesión</a>
          </div>
        </div>
      </div>
    </header>

    <main class="container">
      <div class="content-body">
        <h2 class="title text-center">Mis Vehículos</h2>
        <hr class="divider" />

        <?php if ($ok): ?>
          <div class="alert alert-success"><?= htmlspecialchars($ok) ?></div>
        <?php endif; ?>
        <?php if ($err): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
        <?php endif; ?>

        <!-- Botón para agregar vehículo -->
        <div class="d-flex justify-content-end mb-3">
          <a href="/pages/vehicle_create.php" class="btn btn-primary">➕ Nuevo Vehículo</a>
        </div>

        <!-- Tabla de vehículos -->
        <div class="table-responsive">
          <table class="table table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th>Número de Placa</th>
                <th>Color</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Capacidad de Asientos</th>
                <th>Fotografía</th>
                <th style="width: 200px;">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($vehicles)): ?>
                <tr>
                  <td colspan="8" class="text-center text-muted py-4">
                    No tienes vehículos registrados todavía.
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($vehicles as $v): ?>
                  <tr>
                    <td><?= htmlspecialchars($v['plateNum'] ?? '') ?></td>
                    <td><?= htmlspecialchars($v['color'] ?? '') ?></td>
                    <td><?= htmlspecialchars($v['brand'] ?? '') ?></td>
                    <td><?= htmlspecialchars($v['model'] ?? '') ?></td>
                    <td><?= htmlspecialchars($v['year'] ?? '') ?></td>
                    <td><?= htmlspecialchars($v['capacity'] ?? '') ?></td>
                    <td>
                      <?php if (!empty($v['image'])): ?>
                        <img src="<?= htmlspecialchars($v['image']) ?>" alt="Foto vehículo" style="max-width: 80px; max-height: 60px; object-fit: cover;">
                      <?php else: ?>
                        <span class="text-muted">Sin foto</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <div class="d-flex gap-2">
                        <!-- Editar: solo link -->
                        <a class="btn btn-sm btn-outline-primary"
                           href="/pages/vehicle_edit.php?id=<?= urlencode((string)($v['id'] ?? 0)) ?>">
                          ✏️ Editar
                        </a>

                        <!-- Eliminar: funcional -->
                        <form action="/functions/vehicle_delete.php" method="post" onsubmit="return confirm('¿Deseas eliminar este vehículo?');">
                          <input type="hidden" name="vehicle_id" value="<?= htmlspecialchars((string)($v['id'] ?? 0)) ?>">
                          <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Eliminar</button>
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
        <a href="/pages/rides.php">Rides</a> |
        <a href="/pages/vehicles.php" class="fw-bold">Vehículos</a> |
        <a href="/pages/bookings.php">Reservas</a> |
        <a href="/index.php">Login</a> |
        <a href="/pages/registration_driver.php">Registro</a>
      </nav>
      <p class="footer-copy">© Aventones.com</p>
    </footer>
  </div>
</body>
</html>
