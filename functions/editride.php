<?php
// /functions/editRide.php
if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
}

if (empty($_SESSION['cedula'])) {
    header('Location: /index.php?err=session'); 
    exit;
}

$cedula = $_SESSION['cedula']; // NO convertir a int aquí

require_once __DIR__ . '/../common/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /functions/showride.php?err=method'); 
    exit;
}

// Capturar inputs
$ride_id     = (int)($_POST['ride_id'] ?? 0);
$name        = trim($_POST['name'] ?? '');
$destination = trim($_POST['destination'] ?? '');
$arrival     = trim($_POST['arrival'] ?? '');
$date        = trim($_POST['date'] ?? '');
$space       = (int)($_POST['space'] ?? 0);
$space_cost  = trim($_POST['space_cost'] ?? '');
$vehicle_id  = (int)($_POST['vehicle_id'] ?? 0);

// 🔍 DEBUG - ELIMINAR después de probar
error_log("=== DEBUG editRide.php ===");
error_log("ride_id recibido: " . var_export($ride_id, true));
error_log("cedula de sesión: " . var_export($cedula, true));
error_log("POST completo: " . print_r($_POST, true));
error_log("========================");

// Validar campos requeridos
if ($ride_id<=0 || $name==='' || $destination==='' || $arrival==='' || $date==='' || $space<1 || $vehicle_id<=0) {
    header("Location: /functions/showride.php?err=required"); 
    exit;
}

// 1) Validar límite 1..4
if ($space < 1 || $space > 4) {
    header('Location: /functions/showride.php?err=space_range'); 
    exit;
}

// 2) Verificar que el ride sea del usuario (user_id puede ser VARCHAR o INT)
$sqlOwner = "SELECT user_id FROM rides WHERE id=? LIMIT 1";
if (!$st = mysqli_prepare($conn, $sqlOwner)) {
    header("Location: /functions/showride.php?err=prep0"); 
    exit;
}
mysqli_stmt_bind_param($st, "i", $ride_id);
mysqli_stmt_execute($st);
$res = mysqli_stmt_get_result($st);
$row = mysqli_fetch_assoc($res);
mysqli_stmt_close($st);

if (!$row) {
    mysqli_close($conn);
    error_log("❌ Ride no encontrado. ride_id: $ride_id");
    header("Location: /functions/showride.php?err=ride_not_found&ride_id=$ride_id"); 
    exit;
}

// Comparar como strings para evitar problemas de tipo
$owner_id = (string)$row['user_id'];
$current_user = (string)$cedula;

error_log("✅ Ride encontrado. Owner: $owner_id | Usuario actual: $current_user");

if ($owner_id !== $current_user) {
    mysqli_close($conn);
    header("Location: /functions/showride.php?err=forbidden&owner=$owner_id&user=$current_user"); 
    exit;
}

// 3) Verificar vehículo y capacidad (usando cedula como string)
$sqlCap = "SELECT capacity FROM vehicles WHERE id=? AND user_id=? LIMIT 1";
if (!$st = mysqli_prepare($conn, $sqlCap)) {
    mysqli_close($conn);
    header('Location: /functions/showride.php?err=prep1'); 
    exit;
}
mysqli_stmt_bind_param($st, "is", $vehicle_id, $cedula);
mysqli_stmt_execute($st);
$res = mysqli_stmt_get_result($st);
$row = mysqli_fetch_assoc($res);
mysqli_stmt_close($st);

if (!$row) {
    mysqli_close($conn);
    header('Location: /functions/showride.php?err=vehicle_not_found'); 
    exit;
}

$capacity = (int)$row['capacity'];
if ($space > $capacity) {
    mysqli_close($conn);
    header('Location: /functions/showride.php?err=cap_exceeded'); 
    exit;
}

// 4) Update con cedula como string
$sqlUpd = "UPDATE rides
           SET name=?, destination=?, arrival=?, date=?, space=?, space_cost=?, vehicle_id=?
           WHERE id=? AND user_id=?";
if (!$st = mysqli_prepare($conn, $sqlUpd)) {
    mysqli_close($conn);
    header("Location: /functions/showride.php?err=prep2"); 
    exit;
}

// user_id (cedula) es string, así que: ssssissis
mysqli_stmt_bind_param($st, "ssssissis",
    $name, $destination, $arrival, $date, $space, $space_cost, $vehicle_id, $ride_id, $cedula
);

$ok = mysqli_stmt_execute($st);
mysqli_stmt_close($st);
mysqli_close($conn);

if ($ok) {
    header("Location: /functions/showride.php?ok=updated"); 
    exit;
} else {
    header("Location: /functions/showride.php?err=update_failed"); 
    exit;
}