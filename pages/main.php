<?php
session_start();

if (empty($_SESSION['cedula'])) {
  header('Location: /index.php');
  exit();
}

$cedula   = $_SESSION['cedula'];
$name     = $_SESSION['name']     ?? '';
$lastname = $_SESSION['lastname'] ?? '';
$userType = $_SESSION['userType'] ?? '';

// Normaliza una sola vez en servidor
$isDriver = (strtolower(trim($userType)) === 'driver');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aventones | Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/logIn.css">
</head>

<body class="bg-light">

    <main class="container min-vh-100 py-5">
        <div class="text-center mb-5">
            <h1 class="brand-title fw-bold text-primary mb-2">AVENTONES</h1>
            <h2 class="text-secondary m-0">Panel Principal</h2>
            <p class="text-muted mt-2">
                Bienvenido, <?= htmlspecialchars($name . ' ' . $lastname) ?>.
            </p>
        </div>

        <!-- GRID PRINCIPAL -->
        <div class="row g-4 justify-content-center">

            <!-- Columna: Rides -->
            <div class="col-12 col-md-4">
                <div class="card h-100 shadow-sm border-primary">
                    <div class="card-body">
                        <h3 class="h5 text-primary mb-3">Rides</h3>
                        <div class="d-grid gap-3">
                            <a href="/pages/ride_create.php"
                                class="btn btn-primary w-100 <?= $isDriver ? '' : 'd-none' ?>" id="botonConductor">➕
                                Crear Ride</a>

                            <a href="/index.php" class="btn btn-info w-100 text-white">🔍 Buscar Rides Disponibles</a>


                            <a href="/functions/showride.php"
                                class="btn btn-outline-primary w-100 <?= $isDriver ? '' : 'd-none' ?>">👀 Ver Mis
                                Rides</a>
                            <a href="/index.php" class="btn btn-outline-primary w-100 <?= $isDriver ? '' : 'd-none' ?>">
                                👀 Hacer Reservas</a>

                            <a href="/pages/myBookings.php" class="btn btn-outline-primary w-100">👀 Ver Mis
                                Reservas</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna: Vehículos -->
            <div class="col-12 col-md-4">
                <div class="card h-100 shadow-sm border-success">
                    <div class="card-body">
                        <h3 class="h5 text-success mb-3">Vehículos</h3>
                        <div class="d-grid gap-3">
                            <a href="/pages/vehicle_create.php"
                                class="btn btn-success w-100 <?= $isDriver ? '' : 'd-none' ?>"
                                id="botoncrearvehiculo">🚗 Crear Vehículo</a>

                            <a href="/functions/showvehicle.php"
                                class="btn btn-info w-100 text-white <?= $isDriver ? '' : 'd-none' ?>">👀 Ver Mis
                                Vehículos</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Columna: Perfil -->
            <div class="col-12 col-md-4">
                <div class="card h-100 shadow-sm border-info">
                    <div class="card-body">
                        <h3 class="h5 text-info mb-3">Perfil</h3>
                        <div class="d-grid gap-3">
                            <a href="/pages/profile.php" class="btn btn-info w-100 text-white">👤 Ver Perfil</a>
                            <a href="/functions/logout.php" class="btn btn-outline-secondary w-100">🚪 Cerrar sesión</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <footer class="footer text-center mt-5">
        <nav class="footer-nav mb-2">
            <a href="/index.php">Buscar Rides</a> |
            <a href="/pages/bookings.php">Mis Reservas</a> |
            <a href="/functions/showride.php">Mis Rides</a> |
            <a href="/functions/showvehicle.php">Mis Vehículos</a>
        </nav>
        <p class="footer-copy">© Aventones.com</p>
    </footer>

    <!-- (Opcional) Dejo el JS como refuerzo -->
    <script>
    window.session_data = {
        userType: "<?= htmlspecialchars(strtolower(trim($userType))) ?>"
    };
    </script>
    <script src="/js/hide_pages.js"></script>
</body>

</html>