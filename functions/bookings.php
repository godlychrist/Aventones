<?php
// /functions/insertBookings.php

require (__DIR__ . '/../common/connection.php' );
global $conn;


$sql = "SELECT DISTINCT destination FROM rides";
$resultado = mysqli_query($conn, $sql);
$destinations = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

$sql = "SELECT DISTINCT arrival FROM rides";
$results = mysqli_query($conn, $sql);
$data = mysqli_fetch_all($results, MYSQLI_ASSOC); 

$filter_origin = $_GET['origin'] ?? '';
$filter_arrival = $_GET['arrival'] ?? ''; 
$filter_date = $_GET['date'] ?? ''; 

$sql_rides_filtered = "SELECT 
    r.*, 
    v.model, 
    v.brand,
    YEAR(v.year) AS vehicle_year,
    r.user_id
FROM rides r 
INNER JOIN vehicles v ON r.vehicle_id = v.id
WHERE 1";

if (!empty($filter_origin)) {
    $safe_origin = mysqli_real_escape_string($conn, $filter_origin);
    $sql_rides_filtered .= " AND r.destination = '{$safe_origin}'"; 
}


if (!empty($filter_arrival)) {
    $safe_arrival = mysqli_real_escape_string($conn, $filter_arrival);
    $sql_rides_filtered .= " AND r.arrival = '{$safe_arrival}'"; 
}

if (!empty($filter_date)) {
    $safe_date = mysqli_real_escape_string($conn, $filter_date);
    $sql_rides_filtered .= " AND DATE(r.date) = '{$safe_date}'"; 
}

// 4. Ejecutar la Consulta (ya sea filtrada o completa)
$resultado_rides = mysqli_query($conn, $sql_rides_filtered);

if($resultado_rides) {
    $rides = mysqli_fetch_all($resultado_rides, MYSQLI_ASSOC);
} else {
    $rides = []; 
    // Si quieres ver el error de SQL: echo "Error: " . mysqli_error($conn);
}
    
?>