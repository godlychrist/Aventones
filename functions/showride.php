<?php
// /functions/showride.php
ini_set('display_errors', 1); // quita en producción
error_reporting(E_ALL);

require_once __DIR__ . '/../common/connection.php';


$sql = "
  SELECT
    r.id,
    r.name,
    r.destination,
    r.arrival,
    r.date,
    r.space,
    r.space_cost,
    v.brand,
    v.model,
    v.year,
    v.plateNum
  FROM rides r
  LEFT JOIN vehicles v ON v.id = r.vehicle_id
  ORDER BY r.date ASC, r.id DESC
";

$rides = [];

if ($res = mysqli_query($conn, $sql)) {
  while ($row = mysqli_fetch_assoc($res)) {
// ... dentro del while ($row = mysqli_fetch_assoc($res)) {

// Normaliza campos
$brand = trim($row['brand'] ?? '');
$model = trim($row['model'] ?? '');
$plate = isset($row['plateNum']) ? (string)$row['plateNum'] : '';
$yearTxt = '';

// Si year es DATE 'YYYY-MM-DD' o string 'YYYY', toma los 4 primeros
if (!empty($row['year']) && $row['year'] !== '0000-00-00') {
  $yearTxt = substr($row['year'], 0, 4);
}

// Arma partes dinámicas
$vehParts = [];
if ($brand !== '' || $model !== '') {
  $vehParts[] = trim("$brand $model");           // "Toyota Corolla"
}
if ($yearTxt !== '') {
  $vehParts[] = "($yearTxt)";                    // "(2018)"
}
if ($plate !== '' && $plate !== '0') {
  $vehParts[] = "- Placa: $plate";               // "- Placa: 123456"
}

// Une todo; si no hay nada, pon un guion
$vehText = count($vehParts) ? implode(' ', $vehParts) : '—';

// y luego guardas:
$rides[] = [
  'id'          => (int)($row['id'] ?? 0),
  'name'        => $row['name'] ?? '',
  'destination' => $row['destination'] ?? '',
  'arrival'     => $row['arrival'] ?? '',
  'date'        => $row['date'] ?? '',
  'space'       => (int)($row['space'] ?? 0),
  'space_cost'  => $row['space_cost'] ?? '',
  'vehicle'     => $vehText,
];

  }
  mysqli_free_result($res);
} else {
  error_log('showride query error: ' . mysqli_error($conn));
  $_GET['err'] = 'query';
}

mysqli_close($conn);

// Renderizar la vista que ya tienes (usa $rides)
require ('../pages/ride.php');

