<?php
// sendEmail.php (Contiene SOLO la función de envío de correo)

require __DIR__ . '/../vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// 1. La función acepta solo los tres parámetros que necesita para enviar un correo.
function sendNotificationEmail($correo, $subject, $body) { 
    $mail = new PHPMailer(true); 

    try {
        // ... (Tu configuración SMTP) ...
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->isHTML(false); 
        $mail->Username = 'isw.asociados@gmail.com';
        $mail->Password = 'xnjh yfqx xkte gssx'; 
        
        $mail->SetFrom('isw.asociados@gmail.com', 'Aventones');
        $mail->AddAddress($correo);
        
        // Uso de los parámetros correctos
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = strip_tags($body); 
        
        $mail->Send();
        return true; 
    } catch (Exception $e) {
        error_log("El mensaje a $correo no pudo ser enviado. Error de PHPMailer: {$mail->ErrorInfo}");
        return false; 
    }
}
// Fin del archivo. No hay código ejecutable aquí.