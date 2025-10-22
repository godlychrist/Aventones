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
    $current_image = $_POST['current_image'] ?? '';
    
    // 🔧 CONVERTIR EL AÑO A FORMATO DATE (YYYY-MM-DD)
    // Si el campo year en la BD es DATE, necesitamos formato completo
    $yearForDB = '';
    if (!empty($year) && is_numeric($year) && $year > 0) {
        $yearForDB = $year . '-01-01'; // Convertir 2020 a 2020-01-01
    }
    
    // Variables para la imagen
    $new_image = $_FILES['image'] ?? null;
    $image_update_sql = "";
    $new_web_path = $current_image;
    
    $upload_dir = __DIR__ . '/../images/';
    
    // =======================================================
    // 2. PROCESAMIENTO DE LA NUEVA IMAGEN
    // =======================================================
    if ($new_image && $new_image['error'] === UPLOAD_ERR_OK) {
        
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($new_image['type'], $allowed_types)) {
            header("Location: /pages/vehicle_edit.php?id=$vehicle_id&err=" . urlencode("Tipo de imagen no válido. Solo se permiten JPG, PNG o GIF."));
            exit();
        }

        $ext = pathinfo($new_image['name'], PATHINFO_EXTENSION);
        $new_file_name = uniqid() . '_' . substr(md5($new_image['name']), 0, 8) . '.' . $ext;
        $new_file_dest_server = $upload_dir . $new_file_name;
        
        $new_web_path_for_db = '/images/' . $new_file_name;
        
        if (move_uploaded_file($new_image['tmp_name'], $new_file_dest_server)) {
            
            $old_image_path = $current_image;
            
            if ($old_image_path && strpos($old_image_path, 'placeholder') === false) {
                $old_file_name = basename($old_image_path);
                $old_file_dest_server = $upload_dir . $old_file_name;
                
                if (file_exists($old_file_dest_server)) {
                    @unlink($old_file_dest_server);
                }
            }
            
            $image_update_sql = ", image = '$new_web_path_for_db'";
            $new_web_path = $new_web_path_for_db;
            
        } else {
            header("Location: /pages/vehicle_edit.php?id=$vehicle_id&err=" . urlencode("Fallo al subir el archivo."));
            exit();
        }
    }

    // =======================================================
    // 3. CONSULTA SQL DE ACTUALIZACIÓN
    // =======================================================

    // 🔧 USAR EL AÑO CONVERTIDO A FORMATO DATE
    $sql_update = "UPDATE vehicles SET 
        plateNum = '$plateNum', 
        brand = '$brand', 
        model = '$model', 
        year = " . ($yearForDB ? "'$yearForDB'" : "NULL") . ", 
        color = '$color', 
        capacity = '$capacity'
        $image_update_sql
        WHERE id = '$vehicle_id'";

    // =======================================================
    // 4. EJECUCIÓN Y REDIRECCIÓN
    // =======================================================
    
    $redirect_params = [
        'id'       => $vehicle_id,
        'plateNum' => $plateNum,
        'brand'    => $brand,
        'model'    => $model,
        'year'     => $year, // Mantener el año simple para la URL
        'color'    => $color,
        'capacity' => $capacity,
        'image'    => $new_web_path
    ];

    if (mysqli_query($conn, $sql_update)) {
        $query_string = http_build_query($redirect_params) . "&ok=" . urlencode("Vehículo actualizado con éxito.");
        header("Location: /functions/showvehicle.php");
        exit();
    } else {
        $query_string = http_build_query($redirect_params) . "&err=" . urlencode(mysqli_error($conn));
        header("Location: /pages/vehicle_edit.php?" . $query_string);
        exit();
    }

} else {
    header('Location: /pages/main.php');
    exit;
}
?>