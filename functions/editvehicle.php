<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require ('../common/connection.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: /pages/main.php'); exit;
}

$vehicle_id    = (int)($_POST['vehicle_id'] ?? 0);
$plateNum      = trim($_POST['plateNum'] ?? '');
$brand         = trim($_POST['brand'] ?? '');
$model         = trim($_POST['model'] ?? '');
$year          = trim($_POST['year'] ?? '');
$color         = trim($_POST['color'] ?? '');
$capacity      = (int)($_POST['capacity'] ?? 0);
$current_image = $_POST['current_image'] ?? '';

/* 🔒 Validación capacidad 1..4 */
if ($capacity < 1 || $capacity > 4) {
  header("Location: /pages/vehicle_edit.php?id=$vehicle_id&err=" . urlencode("La capacidad debe ser de 1 a 4.")); 
  exit;
}

/* Año a DATE si usas DATE en la BD */
$yearForDB = '';
if ($year !== '' && ctype_digit($year)) {
  $yearForDB = $year . '-01-01';
}

/* --- Manejo imagen (igual que ya tenías) --- */
$new_image = $_FILES['image'] ?? null;
$image_update_sql = "";
$new_web_path = $current_image;
$upload_dir = __DIR__ . '/../images/';

if ($new_image && $new_image['error'] === UPLOAD_ERR_OK) {
  $allowed_types = ['image/jpeg','image/png','image/gif'];
  if (!in_array($new_image['type'], $allowed_types)) {
    header("Location: /pages/vehicle_edit.php?id=$vehicle_id&err=" . urlencode("Tipo de imagen no válido.")); exit;
  }
  $ext = pathinfo($new_image['name'], PATHINFO_EXTENSION);
  $new_file_name = uniqid() . '_' . substr(md5($new_image['name']), 0, 8) . '.' . $ext;
  $new_file_dest_server = $upload_dir . $new_file_name;
  $new_web_path_for_db = '/images/' . $new_file_name;

  if (move_uploaded_file($new_image['tmp_name'], $new_file_dest_server)) {
    if ($current_image) {
      $old_file = $upload_dir . basename($current_image);
      if (is_file($old_file)) { @unlink($old_file); }
    }
    $image_update_sql = ", image = '$new_web_path_for_db'";
    $new_web_path = $new_web_path_for_db;
  } else {
    header("Location: /pages/vehicle_edit.php?id=$vehicle_id&err=" . urlencode("Fallo al subir el archivo.")); exit;
  }
}

/* --- UPDATE --- */
$sql_update = "
  UPDATE vehicles
     SET plateNum = '$plateNum',
         brand    = '$brand',
         model    = '$model',
         year     = " . ($yearForDB ? "'$yearForDB'" : "NULL") . ",
         color    = '$color',
         capacity = $capacity
         $image_update_sql
   WHERE id = $vehicle_id
";

if (mysqli_query($conn, $sql_update)) {
  header("Location: /functions/showvehicle.php?ok=updated");
  exit;
} else {
  header("Location: /pages/vehicle_edit.php?id=$vehicle_id&err=" . urlencode(mysqli_error($conn)));
  exit;
}
