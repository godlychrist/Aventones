<?php
// /pages/vehicle_create.php
require ('../functions/showUsers.php');

session_start();
if (empty($_SESSION['cedula'])) {
  header('Location: /index.php?err=session'); exit;
}
$cedula = (int)$_SESSION['cedula'];

// /pages/rides.php
ini_set('display_errors', 1); // quita en prod
error_reporting(E_ALL);

$ok  = $_GET['ok']  ?? '';
$err = $_GET['err'] ?? '';

$users = getUsers($conn);


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Usuarios - Aventones</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tu CSS (opcional) -->
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
                        <!-- ✅ Apunta al loader que sí arma $rides -->
                        <a href="/functions/showride.php" class="fw-bold">Rides</a>
                        <a href="/functions/showvehicle.php">Vehículos</a>
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
                <h2 class="title text-center">Usuarios</h2>
                <hr class="divider" />

                <?php if ($ok): ?>
                <div class="alert alert-success"><?= htmlspecialchars($ok) ?></div>
                <?php endif; ?>
                <?php if ($err): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
                <?php endif; ?>

                <div class="d-flex justify-content-end mb-3">
                    <a href="/pages/createAdmin.php" class="btn btn-primary">➕ Nuevo Usuario</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Cedula</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Tipo de Usuario</th>
                                <th>Estado</th>
                                <th style="width: 180px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No tienes rides creados todavía.
                                </td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($users as $u): ?>
                            <tr>
                                <td><?= htmlspecialchars($u['cedula'] ?? '') ?></td>
                                <td><?= htmlspecialchars($u['name'] ?? '') ?></td>
                                <td><?= htmlspecialchars($u['mail'] ?? '') ?></td>
                                <td><?= htmlspecialchars($u['userType'] ?? '') ?></td>
                                <td><?= htmlspecialchars($u['state'] ?? '') ?></td>
                                <td>
                                    <form action="/functions/showUsers.php" method="post">
                                        <input type="hidden" name="cedula"
                                            value="<?= htmlspecialchars((string)($u['cedula'] ?? 0)) ?>">
                                        <input type="hidden" name="action" value="disable">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Inhabilitar
                                        </button>
                                    </form>
                                    <form action="/functions/showUsers.php" method="post">
                                        <input type="hidden" name="cedula"
                                            value="<?= htmlspecialchars((string)($u['cedula'] ?? 0)) ?>">
                                        <input type="hidden" name="action" value="enable">
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Habilitar
                                        </button>
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
            <!-- ✅ También aquí al loader -->
            <a href="/functions/showride.php" class="fw-bold">Rides</a> |
            <a href="/functions/showvehicle.php">Vehículos</a> |
            <a href="/pages/bookings.php">Reservas</a> |
            <a href="/index.php">Login</a> |
            <a href="/pages/registration_driver.php">Registro</a>
        </nav>
        <p class="footer-copy">© Aventones.com</p>
    </footer>
    </div>
</body>

</html>