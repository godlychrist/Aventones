<?php
// /pages/vehicles.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$ok  = $_GET['ok']  ?? '';
$err = $_GET['err'] ?? '';

// Si se abre directo sin pasar por el loader, redirige al loader.
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="/css/logIn.css" />
</head>
<body class="bg-light">
  <div class="container py-4">

    <!-- Header / Nav -->
    <header class="d-flex justify-content-between align-items-center mb-4">
      <nav class="d-flex gap-3">
        <a href="/pages/main.php">Panel</a>
        <a href="/functions/showride.php">Rides</a>
        <!-- ✅ apunta al loader -->
        <a href="/functions/showvehicle.php" class="fw-bold">Vehículos</a>
        <a href="/pages/bookings.php">Reservas</a>
      </nav>
      <div class="d-flex gap-2">
        <a class="btn btn-sm btn-outline-secondary" href="/pages/profile.php">Perfil</a>
        <a class="btn btn-sm btn-outline-secondary" href="/index.php">Cerrar sesión</a>
      </div>
    </header>

    <h1 class="h3 mb-3">Mis Vehículos</h1>

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
              <tr>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($v['plateNum'] ?? '') ?></td>
                <td><?= htmlspecialchars($v['brand'] ?? '') ?></td>
                <td><?= htmlspecialchars($v['model'] ?? '') ?></td>
                <td><?= htmlspecialchars($v['year'] ?? '') ?></td>
                <td><?= htmlspecialchars($v['color'] ?? '') ?></td>
                <td><?= htmlspecialchars($v['capacity'] ?? '') ?></td>
                <td>
                  <?php if (!empty($v['image'])): ?>
                    <img src="<?= htmlspecialchars($v['image']) ?>" alt="Foto vehículo" style="width:70px;height:50px;object-fit:cover;border-radius:6px;">
                  <?php else: ?>
                    <span class="text-muted">—</span>
                  <?php endif; ?>
                </td>
                <td>
                  <div class="d-flex gap-2">
                    <!-- Editar: solo enlace (sin funcionalidad) -->
                    <a class="btn btn-sm btn-outline-primary"
                       href="/pages/vehicle_edit.php?id=<?= urlencode((string)($v['id'] ?? 0)) ?>">
                      ✏️ Editar
                    </a>

                    <!-- Eliminar: funcional (POST) -->
                    <form action="/functions/vehicle_delete.php" method="post" onsubmit="return confirm('¿Eliminar este vehículo?');">
                      <input type="hidden" name="vehicle_id" value="<?= htmlspecialchars((string)($v['id'] ?? 0)) ?>">
                      <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Eliminar</button>
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
</body>
</html>
