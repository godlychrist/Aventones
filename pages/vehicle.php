<?php
// /pages/vehicles.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$ok  = $_GET['ok']  ?? '';
$err = $_GET['err'] ?? '';

// Guard: si se abre directo sin pasar por el loader, redirige.
if (!isset($vehicles)) {
  header('Location: /functions/showvehicle.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Mis Vehículos - Aventones</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Tu CSS -->
  <link rel="stylesheet" href="/css/logIn.css" />
</head>
<body>
  <div class="wrapper container-fluid px-3">
    <!-- Header / Nav (igual estilo que Mis Rides) -->
    <header class="main-header text-center my-3">
      <div class="header-box mt-3">
        <div class="header-content d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
          <nav class="nav-bar d-flex flex-column flex-sm-row align-items-center gap-3">
            <a href="/pages/main.php">Panel</a>
            <a href="/functions/showride.php">Rides</a>
            <!-- ✅ apunta al loader y marcado como activo -->
            <a href="/functions/showvehicle.php" class="fw-bold">Vehículos</a>
            <a href="/pages/mybookings.php">Reservas</a>
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
          <div class="alert alert-danger">Ocurrió un error (<?= htmlspecialchars($err) ?>)</div>
        <?php endif; ?>

        <!-- Botón Nuevo -->
        <div class="d-flex justify-content-end mb-3">
          <a href="/pages/vehicle_create.php" class="btn btn-primary">➕ Nuevo Vehículo</a>
        </div>

        <?php if (empty($vehicles)): ?>
          <div class="alert alert-secondary">No hay vehículos en la base de datos.</div>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-bordered align-middle">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>Número de placa</th>
                  <th>Marca</th>
                  <th>Modelo</th>
                  <th>Año</th>
                  <th>Color</th>
                  <th>Capacidad</th>
                  <th>Fotografía</th>
                  <th style="width: 180px;">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($vehicles as $i => $v): ?>
                  <?php
                    // Los valores ya vienen normalizados desde showvehicle.php
                    $id       = $v['id']       ?? '0';
                    $plateNum = $v['plateNum'] ?? '';
                    $brand    = $v['brand']    ?? '';
                    $model    = $v['model']    ?? '';
                    $year     = $v['year']     ?? '';
                    $color    = $v['color']    ?? '';
                    $capacity = $v['capacity'] ?? '';
                    $image    = $v['image']    ?? '';
                  ?>
                  <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($plateNum) ?></td>
                    <td><?= htmlspecialchars($brand) ?></td>
                    <td><?= htmlspecialchars($model) ?></td>
                    <td><?= htmlspecialchars($year) ?></td>
                    <td><?= htmlspecialchars($color) ?></td>
                    <td><?= htmlspecialchars($capacity) ?></td>
                    <td>
                      <?php if (!empty($image)): ?>
                        <img src="<?= htmlspecialchars($image) ?>" alt="Foto vehículo"
                             style="width:70px;height:50px;object-fit:cover;border-radius:6px;">
                      <?php else: ?>
                        <span class="text-muted">—</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <div class="d-flex gap-2">
                        <a class="btn btn-sm btn-outline-primary"
                          href="/pages/vehicle_edit.php?id=<?= urlencode((string)$id) ?>
                            &plateNum=<?= urlencode((string)$plateNum) ?>
                            &brand=<?= urlencode((string)$brand) ?>
                            &model=<?= urlencode((string)$model) ?>
                            &year=<?= urlencode((string)$year) ?>
                            &color=<?= urlencode((string)$color) ?>
                            &capacity=<?= urlencode((string)$capacity) ?>
                            &image=<?= urlencode((string)$image) ?>">
                          ✏ Editar
                        </a>

                        <form action="/functions/vehicle_delete.php" method="post"
                              onsubmit="return confirm('¿Eliminar este vehículo?');">
                          <input type="hidden" name="vehicle_id" value="<?= htmlspecialchars((string)$id) ?>">
                          <button type="submit" class="btn btn-sm btn-outline-danger">🗑 Eliminar</button>
                        </form>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </main>

    <!-- Footer (igual al de Mis Rides, con Vehículos activo) -->
    <footer class="footer text-center mt-4">
      <nav class="footer-nav mb-2">
        <a href="/pages/main.php">Panel</a> |
        <a href="/functions/showride.php">Rides</a> |
        <a href="/functions/showvehicle.php" class="fw-bold">Vehículos</a> |
        <a href="/pages/myBookings.php">Reservas</a> |
        <a href="/login.php">Login</a> |
        <a href="/pages/registration_driver.php">Registro</a>
      </nav>
      <p class="footer-copy">© Aventones.com</p>
    </footer>
  </div>
</body>
</html>
