<?php
require('../common/connection.php');
require('sendEmail.php');

$directorio_subida = '../images/';
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
   
    
    $numerodeplaca = $_POST['plateNum'];
    $color = $_POST['color'];
    $marca = $_POST['brand'];
    $modelo = $_POST['model'];
    $año = $_POST['year'];
    $capacidad = $_POST['capacity'];
    $cedula = $_SESSION['cedula'];


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
    $sql = "INSERT INTO vehicles (plateNum, color, brand, model, year, image, user_id, capacity)
            VALUES ('$numerodeplaca', '$color', '$marca', '$modelo', '$año', '$nombreImagen_DB', '$cedula', '$capacidad')";

     if (mysqli_query($conn, $sql)) {
        header("Location: /pages/vehicle.php");
    } else {
       
    }

    mysqli_close($conn);
}
?>