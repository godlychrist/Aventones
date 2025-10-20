<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require ('../common/connection.php' );

$cedula = $_SESSION['cedula'];

$sql = "SELECT id, brand, model, user_id FROM vehicles WHERE user_id = '$cedula'";
$resultado = mysqli_query($conn, $sql);
$vehicles = mysqli_fetch_all($resultado, MYSQLI_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$ride_id = $_POST['ride_id'];
$name = $_POST['name']; // El nombre que le pusiste al primer parámetro
$destination = $_POST['destination']; // ✅ CORREGIR EL TIPOGRÁFICO A 'destination'

$arrival = $_POST['arrival'];
$date = $_POST['date'];
$space = $_POST['space'];
$space_cost = $_POST['space_cost'];
$vehicle_id = $_POST['vehicle_id'];


$sql_edit = "UPDATE rides SET name = '$name', destination = '$destination', arrival = '$arrival',
 date = '$date', space = '$space', space_cost = '$space_cost', vehicle_id = '$vehicle_id' WHERE id = '$ride_id'";

 if (mysqli_query($conn, $sql_edit)) {
    header("Location: /pages/ride.php");
    exit();
} else {
   echo "Error al actualizar el ride: " . mysqli_error($conn); 
}

}
?>


