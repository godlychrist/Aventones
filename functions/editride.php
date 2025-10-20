<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require ('../common/connection.php' );

$cedula = $_SESSION['cedula'];

$sql = "SELECT id, brand, model, user_id FROM vehicles WHERE user_id = '$cedula'";
$resultado = mysqli_query($conn, $sql);
$vehicles = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

?>


