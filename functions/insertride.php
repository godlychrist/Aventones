<?php
// /functions/insertride.php
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
$name        = trim($_POST['name'] ?? '');
$destination = trim($_POST['destination'] ?? '');
$arrival     = trim($_POST['arrival'] ?? '');
$date        = trim($_POST['date'] ?? '');
$space       = (int)($_POST['space'] ?? 0);
$space_cost  = trim($_POST['space_cost'] ?? '');
$vehicle_id  = (int)($_POST['vehicle_id'] ?? 0);

if ($name==='' || $destination==='' || $arrival==='' || $date==='' || $space<1 || $vehicle_id<=0) {
  header('Location: /functions/showride.php?err=required'); exit;
}

// 1) Validar límite 1..4
if ($space < 1 || $space > 4) {
  header('Location: /functions/showride.php?err=space_range'); exit;
}

// 2) Verificar vehículo y capacidad (pertenece al usuario)
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

// 3) Insert
$sql = "INSERT INTO rides (name, destination, arrival, date, space_cost, space, user_id, vehicle_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
if (!$st = mysqli_prepare($conn, $sql)) {
  header('Location: /functions/showride.php?err=prep2'); exit;
}
mysqli_stmt_bind_param($st, "sssssiii", $name, $destination, $arrival, $date, $space_cost, $space, $cedula, $vehicle_id);
$ok = mysqli_stmt_execute($st);
mysqli_stmt_close($st);
mysqli_close($conn);

if ($ok) {
  header("Location: /functions/showride.php?ok=created"); exit;
} else {
  header("Location: /functions/showride.php?err=insert"); exit;
}
