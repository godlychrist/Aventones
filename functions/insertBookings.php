<?php 

require ('../common/connection.php');




if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Set the default timezone (important for accurate time)
    date_default_timezone_set('America/Chicago'); // Replace with your desired timezone

    // Get the current date and time in a specific format
    $currentDateTime = date('Y-m-d H:i:s'); 
    echo "Current date and time: " . $currentDateTime . "\n";


    $cedula   = $_POST['cedula'] ?? '';
    $ride_id  = $_POST['ride_id']  ?? '';
    $estado   = 'pendiente';
    $driver_id = $_POST['driver_id'] ?? '';

    $sql = "INSERT INTO bookings (user_id, state, ride_id, date, driver_id) 
    VALUES ('$cedula', '$estado', '$ride_id', '$currentDateTime', '$driver_id')";
    
    if(mysqli_query($conn, $sql)) {
        header ('Location: /pages/myBookings.php');
        exit();
    }
}

?>