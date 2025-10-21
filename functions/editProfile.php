<?php 

require ('../common/connection.php' );  

session_start();
$cedula = $_SESSION['cedula'];

$sql = "SELECT name, lastname, cedula, birthDate, mail, phoneNum, image FROM usuarios WHERE cedula = '$cedula'";
$resultado = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($resultado);

$user['image'] = $user['image'] ?? '/images/avatar_placeholder.png'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $birthDate = $_POST['birthDate'];
    $mail = $_POST['mail'];
    $phoneNum = $_POST['phoneNum'];
    $new_image = $_FILES['image'] ?? null;
    $image_update_sql = "";
    
    // Directorio donde se guardarán las imágenes
    // Asume que la carpeta 'images' está un nivel arriba del directorio actual (/functions)
    $upload_dir = __DIR__ . '/../images/'; 

    // =======================================================
    // 2. PROCESAMIENTO DE LA NUEVA IMAGEN
    // =======================================================
    if ($new_image && $new_image['error'] === UPLOAD_ERR_OK) {
        
        // Verificación de seguridad básica de tipo de archivo
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($new_image['type'], $allowed_types)) {
             // Redireccionar con error si el tipo no es válido
             header("Location: /pages/profile.php?err=invalid_image_type");
             exit();
        }

        // a) Generar nombre único y rutas
        $ext = pathinfo($new_image['name'], PATHINFO_EXTENSION);
        $new_file_name = uniqid() . '_' . substr(md5($new_image['name']), 0, 8) . '.' . $ext;
        $new_file_dest_server = $upload_dir . $new_file_name;
        
        // Ruta web para guardar en la BD (ej: /images/nombre_unico.jpg)
        $new_web_path = '/images/' . $new_file_name; 
        
        // b) Mover el archivo subido
        if (move_uploaded_file($new_image['tmp_name'], $new_file_dest_server)) {
            
            // c) Si la subida fue exitosa, eliminar la imagen antigua
            // $user['image'] trae la ruta antigua cargada en la sección GET
            $old_image_path = $user['image'] ?? null; 
            
            // Solo borrar si hay una ruta y no es el placeholder
            if ($old_image_path && strpos($old_image_path, 'avatar_placeholder') === false) {
                $old_file_name = basename($old_image_path); 
                $old_file_dest_server = $upload_dir . $old_file_name;
                
                if (file_exists($old_file_dest_server)) {
                    @unlink($old_file_dest_server); // @ suprime errores si no se puede borrar
                }
            }
            
            // d) Preparar la parte SQL para actualizar la imagen
            $image_update_sql = ", image = '$new_web_path'";

        } else {
             // Fallo al mover el archivo (ej. permisos)
             header("Location: /pages/profile.php?err=upload_failed");
             exit();
        }
    }


    $sql_update = "UPDATE usuarios SET 
        name = '$name',
        lastname = '$lastname',
        birthDate = '$birthDate',
        mail = '$mail',
        phoneNum = '$phoneNum'
        " . $image_update_sql . "
        WHERE cedula = '$cedula'";

    if (mysqli_query($conn, $sql_update)) {
        header("Location: /pages/profile.php");
        exit();
    } else {
        echo "Error al actualizar el perfil: " . mysqli_error($conn);
    }
}


























?>