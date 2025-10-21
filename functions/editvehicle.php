<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require ('../common/connection.php' );

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. OBTENER DATOS DEL FORMULARIO
    $vehicle_id = $_POST['vehicle_id'];
    $plateNum   = $_POST['plateNum'];
    $brand      = $_POST['brand'];
    $model      = $_POST['model'];
    $year       = $_POST['year'];
    $color      = $_POST['color'];
    $capacity   = $_POST['capacity'];
    $current_image = $_POST['current_image'] ?? ''; // La ruta de la imagen actual (la que está en la BD)
    
    // Variables para la imagen
    $new_image = $_FILES['image'] ?? null;
    $image_update_sql = "";
    $new_web_path = $current_image; // Por defecto, mantenemos la imagen actual
    
    // Directorio donde se guardarán las imágenes (Ajustar según la estructura de tu proyecto)
    // Asume que la carpeta 'images' está un nivel arriba del directorio actual (/functions)
    $upload_dir = __DIR__ . '/../images/';
    
    // =======================================================
    // 2. PROCESAMIENTO DE LA NUEVA IMAGEN
    // =======================================================
    if ($new_image && $new_image['error'] === UPLOAD_ERR_OK) {
        
        // Verificación de seguridad básica de tipo de archivo
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($new_image['type'], $allowed_types)) {
            // Redirigir de vuelta al formulario con error
            header("Location: /pages/vehicle_edit.php?id=$vehicle_id&err=" . urlencode("Tipo de imagen no válido. Solo se permiten JPG, PNG o GIF."));
            exit();
        }

        // a) Generar nombre único y rutas
        $ext = pathinfo($new_image['name'], PATHINFO_EXTENSION);
        $new_file_name = uniqid() . '_' . substr(md5($new_image['name']), 0, 8) . '.' . $ext;
        $new_file_dest_server = $upload_dir . $new_file_name;
        
        // Ruta web para guardar en la BD (ej: /images/nombre_unico.jpg)
        $new_web_path_for_db = '/images/' . $new_file_name;
        
        // b) Mover el archivo subido
        if (move_uploaded_file($new_image['tmp_name'], $new_file_dest_server)) {
            
            // c) Si la subida fue exitosa, eliminar la imagen antigua
            $old_image_path = $current_image;
            
            // Solo borrar si hay una ruta y no es un placeholder genérico
            if ($old_image_path && strpos($old_image_path, 'placeholder') === false) {
                $old_file_name = basename($old_image_path);
                $old_file_dest_server = $upload_dir . $old_file_name;
                
                if (file_exists($old_file_dest_server)) {
                    @unlink($old_file_dest_server); // @ suprime errores si no se puede borrar
                }
            }
            
            // d) Preparar la parte SQL y actualizar la ruta para la redirección
            $image_update_sql = ", image = '$new_web_path_for_db'";
            $new_web_path = $new_web_path_for_db; // Actualiza la ruta para la redirección
            
        } else {
            // Fallo al mover el archivo (ej. permisos)
            header("Location: /pages/vehicle_edit.php?id=$vehicle_id&err=" . urlencode("Fallo al subir el archivo (permisos o error de servidor)."));
            exit();
        }
    }


    // =======================================================
    // 3. CONSULTA SQL DE ACTUALIZACIÓN
    // =======================================================

    // Nota: $image_update_sql será una cadena vacía "" si no se subió una nueva imagen.
    $sql_update = "UPDATE vehicles SET 
        plateNum = '$plateNum', 
        brand = '$brand', 
        model = '$model', 
        year = '$year', 
        color = '$color', 
        capacity = '$capacity'
        $image_update_sql
        WHERE id = '$vehicle_id'";

    // =======================================================
    // 4. EJECUCIÓN Y REDIRECCIÓN
    // =======================================================
    
    // Prepara los parámetros para la redirección (mantener los campos llenos)
    $redirect_params = [
        'id'       => $vehicle_id,
        'plateNum' => $plateNum,
        'brand'    => $brand,
        'model'    => $model,
        'year'     => $year,
        'color'    => $color,
        'capacity' => $capacity,
        'image'    => $new_web_path // Usa la nueva ruta de la imagen o la actual
    ];

    if (mysqli_query($conn, $sql_update)) {
        // Redirige DE VUELTA a la página de edición con un mensaje OK
        $query_string = http_build_query($redirect_params) . "&ok=" . urlencode("Vehículo actualizado con éxito.");
        header("Location: /pages/vehicle_edit.php?" . $query_string);
        exit();
    } else {
        // Redirige DE VUELTA a la página de edición con un mensaje de error
        $query_string = http_build_query($redirect_params) . "&err=" . urlencode(mysqli_error($conn));
        header("Location: /pages/vehicle_edit.php?" . $query_string);
        exit();
    }

} else {
    // Si no es un POST, redirige al panel principal.
    header('Location: /pages/main.php');
    exit;
}
?>