<?php
// /functions/insertvehicle.php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (empty($_SESSION['cedula'])) { header('Location: /index.php?err=session'); exit; }
$cedula = (int)$_SESSION['cedula'];

require_once __DIR__ . '/../common/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /functions/showvehicle.php?err=method'); exit;
}

$plateNum = trim($_POST['plateNum'] ?? '');
$color    = trim($_POST['color'] ?? '');
$brand    = trim($_POST['brand'] ?? '');
$model    = trim($_POST['model'] ?? '');
$yearRaw  = trim($_POST['year'] ?? '');
$capacity = (int)($_POST['capacity'] ?? 0);

// valida capacidad 1..4
if ($capacity < 1 || $capacity > 4) {
  header('Location: /pages/vehicle_create.php?err=capacity_range'); exit;
}

// valida obligatorios
if ($plateNum==='' || $brand==='' || $model==='' || $color==='' || $yearRaw==='') {
  header('Location: /pages/vehicle_create.php?err=required'); exit;
}

// normaliza year (si tu columna es DATE en BD)
$yearForDB = preg_match('/^\d{4}$/', $yearRaw) ? ($yearRaw . '-01-01') : $yearRaw;

// manejar imagen (opcional)
$webImagePath = null;
if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
  $allowed = ['image/jpeg','image/png','image/gif'];
  if (!in_array($_FILES['image']['type'], $allowed)) {
    header('Location: /pages/vehicle_create.php?err=bad_image_type'); exit;
  }
  $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
  $fname = uniqid().'_'.substr(md5($_FILES['image']['name']),0,8).'.'.$ext;
  $destServer = __DIR__ . '/../images/' . $fname;
  if (!move_uploaded_file($_FILES['image']['tmp_name'], $destServer)) {
    header('Location: /pages/vehicle_create.php?err=upload_fail'); exit;
  }
  $webImagePath = '/images/' . $fname;
}

// INSERT
$sql = $webImagePath
  ? "INSERT INTO vehicles (plateNum, color, brand, model, year, capacity, user_id, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
  : "INSERT INTO vehicles (plateNum, color, brand, model, year, capacity, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)";

$st = mysqli_prepare($conn, $sql);
if (!$st) { header('Location: /functions/showvehicle.php?err=prep'); exit; }

if ($webImagePath) {
  mysqli_stmt_bind_param($st, "sssssiis",
    $plateNum, $color, $brand, $model, $yearForDB, $capacity, $cedula, $webImagePath
  );
} else {
  mysqli_stmt_bind_param($st, "sssssis",
    $plateNum, $color, $brand, $model, $yearForDB, $capacity, $cedula
  );
}

$ok = mysqli_stmt_execute($st);
mysqli_stmt_close($st);
mysqli_close($conn);

if ($ok) {
  header('Location: /functions/showvehicle.php?ok=created'); 
} else {
  header('Location: /pages/vehicle_create.php?err=insert'); 
}
exit;
