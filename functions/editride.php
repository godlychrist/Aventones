<?php
// /functions/editRide.php
if ( session_status() === PHP_SESSION_NONE ) {
    session_start();
}
if ( empty( $_SESSION[ 'cedula' ] ) ) {
    header( 'Location: /index.php?err=session' );
    exit;
}
$cedula = ( int )$_SESSION[ 'cedula' ];

require_once __DIR__ . '/../common/connection.php';

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
    $ride_id     = ( int )( $_POST[ 'ride_id' ] ?? 0 );
    $name        = trim( $_POST[ 'name' ] ?? '' );
    $destination = trim( $_POST[ 'destination' ] ?? '' );
    $arrival     = trim( $_POST[ 'arrival' ] ?? '' );
    $date        = trim( $_POST[ 'date' ] ?? '' );
    $space       = ( int )( $_POST[ 'space' ] ?? 0 );
    $space_cost  = trim( $_POST[ 'space_cost' ] ?? '' );
    $vehicle_id  = ( int )( $_POST[ 'vehicle_id' ] ?? 0 );

    $sqlUpd = "UPDATE rides SET name = '$name', destination = '$destination', arrival = '$arrival', date = '$date',
    space_cost = '$space_cost', space = '$space', vehicle_id = '$vehicle_id' WHERE id = '$ride_id' and user_id = '$cedula'";

    
    if (mysqli_query($conn, $sqlUpd)) {
        header("Location: /pages/ride.php");
        exit();
    } else {
        echo "Error al actualizar el ride: " . mysqli_error($conn);
    }

}

// 4 ) Update