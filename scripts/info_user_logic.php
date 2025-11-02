<?php

include ('../common/connection.php');
require __DIR__ . '/sendEmail.php';

function getAllPendingBookings() {
    global $conn;

    $sql = "SELECT 
    b.id,
    u.mail AS driver_email, 
    b.date AS created_at 
    FROM usuarios u
    INNER JOIN bookings b ON u.cedula = b.driver_id
    WHERE b.state = 'pending'";

    $resultado = mysqli_query($conn, $sql);
    
    if ($resultado) {
        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    } else {
        error_log("Error en la consulta DB: " . mysqli_error($conn));
        return []; 
    }
}

function processAlerts($minutes_threshold) {
    
    $now = new DateTime(); 
    $drivers_to_notify = []; 

    echo "Iniciando script de alerta...\n";
    echo "Buscando reservas pendientes con > $minutes_threshold minutos...\n";

    $pending_bookings = getAllPendingBookings();

    // 🎯 CÁLCULO Y FILTRADO
    foreach ($pending_bookings as $booking) {
        $email = $booking['driver_email'];
        $booking_time = new DateTime($booking['created_at']);
        
        $interval = $now->diff($booking_time);
        $minutes_old = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

        if ($minutes_old >= $minutes_threshold) {
            if (!isset($drivers_to_notify[$email])) {
                $drivers_to_notify[$email] = 0;
            }
            $drivers_to_notify[$email]++;
        }
    }

    if (empty($drivers_to_notify)) {
        echo "✅ No hay choferes a notificar (ninguna reserva supera los $minutes_threshold minutos).\n";
        return;
    }

    echo "Enviando alertas a " . count($drivers_to_notify) . " choferes...\n";

    // 🎯 BUCLE DE ENVÍO
    foreach ($drivers_to_notify as $email => $count) {
        // Aquí generamos SUBJECT y BODY (con los minutos)
        $subject = "🚨 Alerta: Tienes $count solicitudes de reserva pendientes";
        $body = "Hola Chofer,\n\nHemos detectado que tienes $count solicitudes de reserva que se crearon hace más de $minutes_threshold minutos y aún no han sido gestionadas.\n";
        
        // Llamamos a la función de envío (que solo acepta 3 parámetros)
        $success = sendNotificationEmail($email, $subject, $body);

        if ($success) {
            echo "   [OK] Notificación enviada a: $email ($count reservas).\n";
        } else {
            echo "   [FALLO] Error al enviar a: $email.\n";
        }
    }

    echo "Proceso finalizado.\n";
}
// Fin del archivo.
?>