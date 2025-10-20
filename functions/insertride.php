<?php
require('../common/connection.php');
require('sendEmail.php');

$directorio_subida = '../images/';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
   
    
    $nombre = $_POST['name'];
    $lugardesalida = $_POST['destination'];
    $lugardellegada = $_POST['arrival'];
    $horaydia = $_POST['date'];
    $costoxespacio = $_POST['space_cost'];
    $cantidad = $_POST['space'];
    $cedula = $_SESSION ['cedula'];  
    $vehicle = $_POST['vehicle_id'];
   

    $nombreImagen_DB = null; 

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        
        $nombreArchivoUnico = uniqid() . '_' . basename($_FILES['image']['name']);
        $rutaTemporal = $_FILES['image']['tmp_name'];
        $rutaDestinoFinal = $directorio_subida . $nombreArchivoUnico; 
        
   
        if(move_uploaded_file($rutaTemporal, $rutaDestinoFinal)) {
            
            $rutaBaseWeb = '/Aventones/images/'; 
            $nombreImagen_DB = $rutaBaseWeb . $nombreArchivoUnico;

        } else {
        
             echo "ERROR: Falló move_uploaded_file. Revise permisos y rutas de la carpeta.";
             error_log("Fallo al mover archivo a: " . $rutaDestinoFinal);
      
        }
    }
    $sql = "INSERT INTO rides (name, destination, arrival, date, space_cost, space ,user_id, vehicle_id)
            VALUES ('$nombre', '$lugardesalida', '$lugardellegada', '$horaydia', '$costoxespacio','$cantidad', '$cedula', '$vehicle')";

     if (mysqli_query($conn, $sql)) {
        header("Location: /index.php");
        exit();
    } else {
       
    }

    mysqli_close($conn);
}
?>