<?php

require (__DIR__ . '/functions/bookings.php');
session_start();
$is_logged_in = isset($_SESSION['cedula']);
  

$ok  = $_GET['ok']  ?? '';
$err = $_GET['err'] ?? '';




?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Rides - Aventones</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/logIn.css" />
</head>

<body>
    <div class="wrapper container-fluid px-3">
        <header class="main-header text-center my-3">
            <div class="header-box mt-3">
                <div
                    class="header-content d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <nav class="nav-bar d-flex flex-column flex-sm-row align-items-center gap-3">
                        <a href="/pages/main.php">Panel</a>
                        <a href="/functions/showride.php" class="fw-bold">Rides</a>
                        <a href="/functions/showvehicle.php">Vehículos</a>
                        <a href="/pages/myBookings.php">Reservas</a>
                    </nav>
                    <div class="d-flex align-items-center gap-3">
                        <a href="/pages/profile.php" class="btn btn-sm btn-outline-secondary">Perfil</a>
                        <a href="login.php" class="btn btn-sm btn-outline-secondary">Sign In</a>
                    </div>
                </div>
            </div>
        </header>

        <main class="container">
            <div class="content-body">
                <h2 class="title text-center">Rides Disponibles</h2>
                <hr class="divider" />

                <?php if ($ok): ?>
                <div class="alert alert-success"><?= htmlspecialchars($ok) ?></div>
                <?php endif; ?>
                <?php if ($err): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
                <?php endif; ?>

                <form action="" method="get" class="mb-4 p-3 border rounded shadow-sm bg-light">
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-4">
                            <label for="filter_origin" class="form-label fw-bold">Lugar de Salida (Origen)</label>
                            <select id="filter_origin" name="origin" class="form-select">
                                <option value="">— Todos los Orígenes —</option>
                                <?php 
                        
                        foreach ($destinations as $destino) {
                            $valor = htmlspecialchars($destino['destination'] ?? '');
                            echo "<option value=\"{$valor}\">$valor</option>";
                        }
                        
                        ?>

                            </select>
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="filter_destination" class="form-label fw-bold">Lugar de Llegada
                                (Destino)</label>
                            <select id="filter_destination" name="destination" class="form-select">
                                <option value="">— Todos los Destinos —</option>
                                <?php

                            foreach($data as $arrivalPlace) {
                                $valor = htmlspecialchars($arrivalPlace['arrival'] ?? '');
                                echo "<option value=\"{$valor}\">$valor</option>";
                            }

                        ?>
                            </select>
                        </div>

                        <div class="col-12 col-md-4">
                            <label for="filter_date" class="form-label fw-bold">Fecha</label>
                            <input type="date" id="filter_date" name="date" class="form-control">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-secondary me-2">Buscar / Filtrar</button>
                        <a href="/index.php" class="btn btn-outline-secondary">Limpiar Filtros</a>
                    </div>
                </form>
                <div class="d-flex justify-content-end mb-3">
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
                                <th style="width: 180px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($rides)): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No tienes rides creados todavía.
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($rides as $r): ?>
                            <tr>
                                <td><?= htmlspecialchars($r['name'] ?? '') ?></td>
                                <td><?= htmlspecialchars($r['destination'] ?? '') ?></td>
                                <td><?= htmlspecialchars($r['arrival'] ?? '') ?></td>
                                <td><?= htmlspecialchars($r['date'] ?? '') ?></td>
                                <td><?= htmlspecialchars((string)($r['space'] ?? '')) ?></td>
                                <td><?= htmlspecialchars($r['space_cost'] ?? '') ?></td>
                                <td><?= htmlspecialchars($r['brand'] ?? '') . ' ' . htmlspecialchars($r['model'] ?? '') . '  (' . htmlspecialchars($r['vehicle_year']) . ')'?>
                                </td>
                                <td style="width: 180px;">
                                    <div class="d-flex gap-2">
                                        <?php if ($is_logged_in): ?>
                                        <a href="/pages/showBookings.php?ride_id=<?= htmlspecialchars($r['id'] ?? '') ?>
                            &name=<?=urlencode((string)($r['name'] ?? ''))?>
                          &destination=<?=urlencode((string)($r['destination'] ?? ''))?>
                          &arrival=<?=urlencode((string)($r['arrival'] ?? ''))?>
                          &date=<?=urlencode((string)($r['date'] ?? ''))?>
                          &space=<?=urlencode((string)($r['space'] ?? ''))?>
                          &space_cost=<?=urlencode((string)($r['space_cost'] ?? ''))?>
                          &vehicle_id=<?=urlencode((string)($r['vehicle_id'] ?? ''))?>
                          &cedula=<?=urlencode((string)($_SESSION['cedula'] ?? ''))?>
                        &user_id=<?=urlencode((string)($r['user_id'] ?? ''))?>" class="btn btn-sm btn-info text-white"
                                            title="Ver Reservas">
                                            Reservar Ride
                                        </a>
                                        <?php else: ?>
                                        <button type="button" class="btn btn-sm btn-info text-white"
                                            onclick="alertAndRedirect('/index.php');"
                                            title="Iniciar sesión para reservar">
                                            Reservar Ride
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            </div>
            </form>
        </main>

        <footer class="footer text-center mt-4">
            <nav class="footer-nav mb-2">
                <a href="/pages/main.php">Panel</a> |
                <a href="/functions/showride.php" class="fw-bold">Rides</a> |
                <a href="/functions/showvehicle.php">Vehículos</a> |
                <a href="/pages/myBookings.php">Reservas</a> |
                <a href="/login.php">Login</a> |
                <a href="/pages/registration_driver.php">Registro</a>
            </nav>
            <p class="footer-copy">© Aventones.com</p>
        </footer>
    </div>
    <script>
    // Función simple que muestra la alerta y redirige
    function alertAndRedirect(url) {
        alert("⚠️ Debes iniciar sesión para poder reservar un ride.");
        window.location.href = url;
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>