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

$vehicles = [];

if ($res = mysqli_query($conn, $sql)) {
  while ($row = mysqli_fetch_assoc($res)) {
    
    $yearTxt = '';
    if (!empty($row['year'])) {
      // si es DATE 'YYYY-MM-DD' → tomamos YYYY
      $yearValue = substr($row['year'], 0, 4);
      
      // 🔧 ARREGLO: Solo usar el año si NO es '0000' o '0'
      if ($yearValue !== '0000' && $yearValue !== '0' && (int)$yearValue > 0) {
        $yearTxt = $yearValue;
      }
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

    // 🔧 ARREGLO: Limpiar capacity de espacios
    $capacityValue = $capacityExists ? trim($row['capacity'] ?? '') : '';

    $vehicles[] = [
      'id'       => (int)($row['id'] ?? 0),
      'plateNum' => trim($row['plateNum'] ?? ''),
      'color'    => trim($row['color'] ?? ''),
      'brand'    => trim($row['brand'] ?? ''),
      'model'    => trim($row['model'] ?? ''),
      'year'     => $yearTxt, // 👈 Ahora estará vacío si es 0000
      'image'    => $imagePath,
      'capacity' => $capacityValue, // 👈 Sin espacios
    ];
  }
  mysqli_free_result($res);
} else {
  error_log('showvehicle query error: ' . mysqli_error($conn));
  $_GET['err'] = 'query';
}

mysqli_close($conn);

/** 3) Render de la vista que usa $vehicles */
require ('../pages/vehicle.php');
?>