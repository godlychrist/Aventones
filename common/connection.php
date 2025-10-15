<?php
// Datos de la conexión
$host = 'localhost'; 
$username = 'root';  
$password = '';      
$database = 'aventones'; 

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

?>

