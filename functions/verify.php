<?php
require('../common/connection.php');

if (isset($_GET['token']) && !empty($_GET['token'])) {
    $token = $_GET['token'];
    $ahora = date('Y-m-d H:i:s');
    
    // 1. Buscar el usuario por el token y verificar que no ha expirado
    $sql_verificar = "SELECT mail, expiration_token FROM usuarios WHERE token = '$token' AND state = 'pendiente'";
    $resultado = mysqli_query($conn, $sql_verificar);
    
    if (mysqli_num_rows($resultado) == 1) {
        $usuario = mysqli_fetch_assoc($resultado);
        
        // 2. Verificar expiración
        if ($usuario['expiration_token'] > $ahora) {
            
            // 3. Activar la cuenta y limpiar el token
            $sql_activar = "UPDATE usuarios 
                            SET state = 'activa', token = NULL, expiration_token = NULL 
                            WHERE token = '$token'";
            
            if (mysqli_query($conn, $sql_activar)) {
                echo "¡Tu cuenta ha sido verificada y activada! Ya puedes iniciar sesión.";
                
            } else {
                echo "Error al activar la cuenta. Inténtalo de nuevo.";
            }
        
        } else {
            // El token ha expirado
            echo "El enlace de verificación ha expirado. Por favor, regístrate de nuevo o solicita un nuevo enlace.";
        }
        
    } else {
        // Token no válido o la cuenta ya está activa
        echo "Token de verificación no válido o la cuenta ya está activa.";
    }

    mysqli_close($conn);

} else {
    // Si acceden sin token
    header("Location: /index.php");
    exit();
}
?>