<?php
// /functions/editRide.php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (empty($_SESSION['cedula'])) {
  header('Location: /index.php?err=session'); exit;
}
$cedula = (int)$_SESSION['cedula'];

require_once __DIR__ . '/../common/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /functions/showride.php?err=method'); exit;
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

if ($ride_id<=0 || $name==='' || $destination==='' || $arrival==='' || $date==='' || $space<1 || $vehicle_id<=0) {
  header("Location: /functions/showride.php?err=required"); exit;
}

// 1) Validar límite 1..4
if ($space < 1 || $space > 4) {
  header('Location: /functions/showride.php?err=space_range'); exit;
}

// 2) Verificar que el ride sea del usuario
$sqlOwner = "SELECT user_id FROM rides WHERE id=? LIMIT 1";
if (!$st = mysqli_prepare($conn, $sqlOwner)) {
  header("Location: /functions/showride.php?err=prep0"); exit;
}
mysqli_stmt_bind_param($st, "i", $ride_id);
mysqli_stmt_execute($st);
$res = mysqli_stmt_get_result($st);
$row = mysqli_fetch_assoc($res);
mysqli_stmt_close($st);

if (!$row || (int)$row['user_id'] !== $cedula) {
  header("Location: /functions/showride.php?err=forbidden"); exit;
}

// 3) Verificar vehículo y capacidad (pertenece al usuario)
$sqlCap = "SELECT capacity FROM vehicles WHERE id=? AND user_id=? LIMIT 1";
if (!$st = mysqli_prepare($conn, $sqlCap)) {
  header('Location: /functions/showride.php?err=prep1'); exit;
}
mysqli_stmt_bind_param($st, "ii", $vehicle_id, $cedula);
mysqli_stmt_execute($st);
$res = mysqli_stmt_get_result($st);
$row = mysqli_fetch_assoc($res);
mysqli_stmt_close($st);

if (!$row) {
  header('Location: /functions/showride.php?err=veh'); exit;
}
$capacity = (int)$row['capacity'];
if ($space > $capacity) {
  header('Location: /functions/showride.php?err=cap'); exit;
}

// 4) Update
$sqlUpd = "UPDATE rides
           SET name=?, destination=?, arrival=?, date=?, space=?, space_cost=?, vehicle_id=?
           WHERE id=? AND user_id=?";
if (!$st = mysqli_prepare($conn, $sqlUpd)) {
  header("Location: /functions/showride.php?err=prep2"); exit;
}
mysqli_stmt_bind_param($st, "sssssiiii",
  $name, $destination, $arrival, $date, $space, $space_cost, $vehicle_id, $ride_id, $cedula
);
$ok = mysqli_stmt_execute($st);
mysqli_stmt_close($st);
mysqli_close($conn);

if ($ok) {
  header("Location: /functions/showride.php?ok=updated"); exit;
} else {
  header("Location: /functions/showride.php?err=update"); exit;
}
