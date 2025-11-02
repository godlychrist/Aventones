<?php 

include ('../common/connection.php');


function getUsers() {
    global $conn;

    $sql = "SELECT cedula, name, mail, userType, state FROM usuarios WHERE state IN ('activa', 'inactive')";
    $resultado = mysqli_query($conn, $sql);

    if ($resultado) {
        $users = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        return $users;
    } else {
        return []; 
    }
}

function deactivateUser($cedula) {
    global $conn;

    $sql = "UPDATE usuarios SET state = 'inactive' WHERE cedula = '$cedula'";

    if (mysqli_query($conn, $sql)) {
        header( 'Location: /pages/users.php' );
        exit();
    } else {
        return false;
    }
}

function activateUser($cedula) {
    global $conn;

    $sql = "UPDATE usuarios SET state = 'activa' WHERE cedula = '$cedula'";

    if (mysqli_query($conn, $sql)) {
        header( 'Location: /pages/users.php' );
        exit();
    } else {
        return false;
    }
}

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' && isset( $_POST[ 'action' ] ) ) {
    if ( $_POST[ 'action' ] === 'disable' ) {
        // ✅ Pasamos el valor que viene en el POST directamente a la función
        // Asegúrate de que el valor exista antes de pasarlo.
        $cedula_post = $_POST['cedula'] ?? '';
        
        if (!empty($cedula_post)) {
            deactivateUser($cedula_post);
            
        } else {
            // Manejar error si no hay cédula en el POST
            header( 'Location: /pages/users.php?err=No se proporcionó cédula.' );
            exit();
        } 
    } else if ( $_POST[ 'action' ] === 'enable' ) {
        $cedula_post = $_POST['cedula'] ?? '';  
        if (!empty($cedula_post)) {
            activateUser($cedula_post);
        } else {
            // Manejar error si no hay cédula en el POST
            header( 'Location: /pages/users.php?err=No se proporcionó cédula.' );
            exit();
        } 
    }
} 

?>