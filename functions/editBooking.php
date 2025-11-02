<?php

require ( '../common/connection.php' );
session_start();
$userType = $_SESSION[ 'userType' ] ?? '';

function acceptBooking() {
    // Lógica para aceptar la reserva
    global $conn;
    global $userType;

    if ( $userType == 'driver' ) {
        if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
            $bookingId = ( int )$_POST[ 'id' ];
            $ride_id = ( int )$_POST[ 'ride_id' ];

            $sql = "UPDATE bookings SET state = 'accepted' WHERE id = '$bookingId'";
            $sql2 = "UPDATE rides SET status = 'inactive' WHERE id = '$ride_id'";

            if ( mysqli_query( $conn, $sql ) && mysqli_query( $conn, $sql2 ) ) {
                header( 'Location: /pages/myBookings.php' );
                exit();
            } else {
                echo 'Error al aceptar la reserva: ' . mysqli_error( $conn );
            }
        }
        ;

    }

}

function rejectBooking() {
    // Lógica para rechazar la reserva
    global $conn;
    global $userType;

    if ( $userType == 'driver' ) {
        if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
            $bookingId = ( int )$_POST[ 'id' ];

            $sql = "UPDATE bookings SET state = 'rejected' WHERE id = '$bookingId'";

            if ( mysqli_query( $conn, $sql ) ) {
                header( 'Location: /pages/myBookings.php' );
                exit();
            } else {
                echo 'Error al rechazar la reserva: ' . mysqli_error( $conn );
            }
        }
        ;

    }

}

function rejectUserBooking() {
    // Lógica para aceptar la reserva
    global $conn;
    global $userType;

    if ( $userType == 'user' ) {
        if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
            $bookingId = ( int )$_POST[ 'id' ];
            $ride_id = ( int )$_POST[ 'ride_id' ];

            $sql = "UPDATE bookings SET state = 'rejected' WHERE id = '$bookingId'";
            $sql2 = "UPDATE rides SET status = 'active' WHERE id = '$ride_id'";

            if ( mysqli_query( $conn, $sql ) && mysqli_query( $conn, $sql2 ) ) {
                header( 'Location: /pages/myBookings.php' );
                exit();
            } else {
                echo 'Error al aceptar la reserva: ' . mysqli_error( $conn );
            }
        }
        ;

    }

}

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' && isset( $_POST[ 'action' ] ) ) {
    if ( $_POST[ 'action' ] === 'accept' ) {
        acceptBooking();
    } elseif ( $_POST[ 'action' ] === 'reject' ) {
        rejectBooking();
    } elseif ( $_POST[ 'action' ] === 'cancel' ) {
        rejectUserBooking();
    }
} else {
    // Si se intenta acceder directamente sin POST
    header( 'Location: /pages/bookings.php' );
    exit();
}

?>