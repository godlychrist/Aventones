<?php
require('../common/connection.php');
require('sendEmail.php');

$directorio_subida = '../images/';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
   
    
    $numerodeplaca = $_POST['plateNum'];
    $color = $_POST['color'];
    $marca = $_POST['brand'];
    $modelo = $_POST['model'];
    $año = $_POST['year'];
    $capacidad = $_POST['capacity'];
    $userid = $_POST['user_id'];
   


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
    $sql = "INSERT INTO vehicles (plateNum, color, brand, model, year, image, capacity, user_id)
            VALUES ('$numerodeplaca', '$color', '$marca', '$modelo', '$año', '$nombreImagen_DB', '$capacidad', '$userid')";

     if (mysqli_query($conn, $sql)) {
        header("Location: /index.php");
        exit();
    } else {
       
    }

    mysqli_close($conn);
}
?>