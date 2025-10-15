<?php
require('../common/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $cedula = $_POST['cedula'];
    $name = $_POST['name'];
    $lastName = $_POST['lastName'];
    $fecha_nac = $_POST['fecha_nac'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $foto = $_POST['foto'];
    $password = md5($_POST['password']);
    $estado = 'pendiente';
    $tipo_usuario = 'user';

    $sql = "INSERT INTO usuarios (cedula, name, lastName, birthDate, mail, phoneNum, image, state, userType)
            VALUES ('$cedula', '$name', '$lastName', '$fecha_nac', '$correo', '$telefono', '$foto', '$estado', '$tipo_usuario')";

    if (mysqli_query($conn, $sql)) {
        header("Location: /index.php?success=registration_complete");
        exit();
    } else {
        header("Location: /index.php?errors=registraton_failed");
        exit();
    }

    mysqli_close($conn);
}
?>