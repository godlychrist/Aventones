<?php
// /functions/showride.php

// 🛑 1. INICIAR SESIÓN Y OBTENER LA CÉDULA
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$cedula = $_SESSION['cedula'] ?? null;

// Seguridad: Si no hay cédula en la sesión, redirigimos.
if (!$cedula) {
    header('Location: /index.php?err=session_required');
    exit;
}

ini_set('display_errors', 1); // quita en producción
error_reporting(E_ALL);

require_once __DIR__ . '/../common/connection.php';

$sql = "
  SELECT
  r.id AS ride_id,
  r.name, 
  r.destination, 
  r.arrival, 
  r.date, 
  r.space, 
  r.space_cost, 
  r.user_id, 
  r.vehicle_id,
  v.brand,            
  v.model,            
  v.year,             
  v.plateNum,
  u.cedula 
  FROM rides r 
  INNER JOIN vehicles v ON v.id = r.vehicle_id 
  INNER JOIN usuarios u ON u.cedula = r.user_id 
  WHERE u.cedula = ?
";

$rides = [];

if ($st = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($st, "s", $cedula);
    mysqli_stmt_execute($st);
    $res = mysqli_stmt_get_result($st);
    
    while ($row = mysqli_fetch_assoc($res)) {

        // Normaliza campos
        $brand = trim($row['brand'] ?? '');
        $model = trim($row['model'] ?? '');
        $plate = isset($row['plateNum']) ? trim((string)$row['plateNum']) : '';
        $yearTxt = (!empty($row['year']) && $row['year'] !== '0000-00-00')
            ? substr($row['year'], 0, 4)
            : '';

        // Arma partes dinámicas del vehículo
        $vehParts = [];
        if ($brand !== '' || $model !== '') {
            $vehParts[] = trim("$brand $model");
        }
        if ($yearTxt !== '') {
            $vehParts[] = "($yearTxt)";
        }
        if ($plate !== '' && $plate !== '0') {
            $vehParts[] = "- Placa: $plate";
        }

        // Une todo; si no hay nada, pon un guion
        $vehText = count($vehParts) ? implode(' ', $vehParts) : '—';

        // Llena el array de rides - usar ride_id en lugar de id
        $rides[] = [
            'id'            => (int)($row['ride_id'] ?? 0),
            'name'          => trim($row['name'] ?? ''),
            'destination'   => trim($row['destination'] ?? ''),
            'arrival'       => trim($row['arrival'] ?? ''),
            'date'          => trim($row['date'] ?? ''),
            'space'         => (int)($row['space'] ?? 0),
            'space_cost'    => trim($row['space_cost'] ?? ''),
            'vehicle_id'    => (int)($row['vehicle_id'] ?? 0),
            'vehicle'       => $vehText,
        ];
    }
    mysqli_free_result($res);
    mysqli_stmt_close($st);
} else {
    error_log('showride query error: ' . mysqli_error($conn));
    $_GET['err'] = 'query';
}

mysqli_close($conn);

// Renderizar la vista que ya tienes (usa $rides)
require ('../pages/ride.php');