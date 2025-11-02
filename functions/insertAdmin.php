<?php
require('../common/connection.php');
require('sendEmail.php');

$directorio_subida = '../images/';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $cedula = $_POST['cedula'];
    $name = $_POST['name'];
    $lastName = $_POST['lastName'];
    $fecha_nac = $_POST['fecha_nac'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $password = md5($_POST['password']);
    $estado = 'activa';
    $tipo_usuario = 'admin';




    $nombreImagen_DB = null; 

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        
        $nombreArchivoUnico = uniqid() . '_' . basename($_FILES['foto']['name']);
        $rutaTemporal = $_FILES['foto']['tmp_name'];
        $rutaDestinoFinal = $directorio_subida . $nombreArchivoUnico; 
        
   
        if(move_uploaded_file($rutaTemporal, $rutaDestinoFinal)) {
            
            $rutaBaseWeb = '/Aventones/images/'; 
            $nombreImagen_DB = $rutaBaseWeb . $nombreArchivoUnico;

        } else {
        
             echo "ERROR: Falló move_uploaded_file. Revise permisos y rutas de la carpeta.";
             error_log("Fallo al mover archivo a: " . $rutaDestinoFinal);
      
        }
    }
    $sql = "INSERT INTO usuarios (cedula, name, lastName, birthDate, mail, phoneNum, password, image, state, userType, token, expiration_token)
            VALUES ('$cedula', '$name', '$lastName', '$fecha_nac', '$correo', '$telefono', '$password', '$nombreImagen_DB', '$estado', '$tipo_usuario', '', '')";

    if (mysqli_query($conn, $sql)) {
        header("Location: /index.php");
        exit();
    } else {
       
    }

    mysqli_close($conn);
}
?>