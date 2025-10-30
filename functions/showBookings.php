<?php 
// This file should contain the function logic.

include ('../common/connection.php');

session_start();
$cedula = $_SESSION['cedula'] ?? '';
$userType = $_SESSION['userType'] ?? '';


    $sql = null; 

    if ($userType == 'user') {
        $sql = "SELECT
        r.name AS ride_name,        
        b.state AS booking_state,    
        d.name AS driver_name,
        b.id      
        FROM
            bookings b
        INNER JOIN
            usuarios u ON u.cedula = b.user_id    
        INNER JOIN
            usuarios d ON d.cedula = b.driver_id   
        INNER JOIN
            rides r ON r.id = b.ride_id             
        WHERE
            b.user_id = '$cedula' AND r.status IN ('active', 'inactive')
            AND b.state IN ('accepted', 'pendiente', 'rejected')" ; 

    } elseif ($userType == 'driver') {
                $sql = "SELECT
            r.name AS ride_name,
            b.state AS booking_state,
            u.name AS user_name,  
            r.id AS ride_id,
            u.cedula AS user_cedula, -- To identify which user to accept/reject
            b.id
        FROM
            bookings b
        INNER JOIN
            rides r ON b.ride_id = r.id
        INNER JOIN
            usuarios u ON u.cedula = b.user_id 
        WHERE
            b.driver_id = '$cedula' AND r.status IN ('active', 'inactive')
            AND b.state IN ('accepted', 'pendiente', 'rejected')" ;
    }

    if ($sql && $cedula) {
        $resultado = mysqli_query($conn, $sql);
        
        if ($resultado) {
            $bookings = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
        } else {
            // En caso de error de SQL o resultado vacío
            $bookings = []; 
        }
    }



?>