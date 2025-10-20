<?php
// /functions/showvehicle.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../common/connection.php';

/** 1) Detectar si la columna 'capacity' existe (opcional y seguro) */
$capacityExists = false;
$dbName = '';
if ($resDb = mysqli_query($conn, "SELECT DATABASE() AS db")) {
  if ($rowDb = mysqli_fetch_assoc($resDb)) {
    $dbName = $rowDb['db'] ?? '';
  }
  mysqli_free_result($resDb);
}
if ($dbName !== '') {
  $sqlCheck = "
    SELECT 1
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = ?
      AND TABLE_NAME = 'vehicles'
      AND COLUMN_NAME = 'capacity'
    LIMIT 1
  ";
  if ($stmtC = mysqli_prepare($conn, $sqlCheck)) {
    mysqli_stmt_bind_param($stmtC, "s", $dbName);
    mysqli_stmt_execute($stmtC);
    $resC = mysqli_stmt_get_result($stmtC);
    $capacityExists = (mysqli_fetch_assoc($resC) !== null);
    mysqli_stmt_close($stmtC);
  }
}

/** 2) Consulta */
$sql = $capacityExists
  ? "SELECT id, plateNum, color, brand, model, year, image, capacity FROM vehicles ORDER BY brand, model, plateNum"
  : "SELECT id, plateNum, color, brand, model, year, image FROM vehicles ORDER BY brand, model, plateNum";

// ... (código anterior)

$vehicles = [];

if ($res = mysqli_query($conn, $sql)) {
  while ($row = mysqli_fetch_assoc($res)) {
    
    $yearTxt = '';
    if (!empty($row['year'])) {
      // si es DATE 'YYYY-MM-DD' → tomamos YYYY
      $yearTxt = substr($row['year'], 0, 4);
    }
    
    // 🛑 ARREGLO PARA MOSTRAR LA FOTO (LIMPIAR LA RUTA)
    $imagePath = $row['image'] ?? '';
    
    // Si la ruta comienza con '/Aventones', la recortamos para que solo quede /images/...
    if (strpos($imagePath, '/Aventones') === 0) {
        $imagePath = substr($imagePath, strlen('/Aventones'));
    }
    // Asegurarse de que al menos tenga un '/' si no lo tiene.
    if (!empty($imagePath) && $imagePath[0] !== '/') {
        $imagePath = '/' . $imagePath;
    }


    $vehicles[] = [
      'id'       => (int)($row['id'] ?? 0),
      'plateNum' => $row['plateNum'] ?? '',
      'color'    => $row['color'] ?? '',
      'brand'    => $row['brand'] ?? '',
      'model'    => $row['model'] ?? '',
      'year'     => $yearTxt,
      'image'    => $imagePath, // 👈 Se pasa la ruta corregida a la vista
      'capacity' => $capacityExists ? ($row['capacity'] ?? '') : '',
    ];
  }
  mysqli_free_result($res);
} else {
// ... (código posterior)
  error_log('showvehicle query error: ' . mysqli_error($conn));
  $_GET['err'] = 'query';
}

mysqli_close($conn);

/** 3) Render de la vista que usa $vehicles */
require ('../pages/vehicle.php');