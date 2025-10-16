<?php
// sendEmail.php

require __DIR__ . '/../vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function sendEmail($correo, $token) { 
    $mail = new PHPMailer(); 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->isHTML(); 
    $mail->Username = 'isw.asociados@gmail.com';
    $mail->Password = 'xnjh yfqx xkte gssx';
    $mail->SetFrom('isw.asociados@gmail.com', 'Aventones');
    $mail->AddAddress($correo);
    $mail->Subject = 'Verificación de cuenta - Aventones';
    $url_verificacion = "http://www.aventones.com/functions/verify.php?token=" . urlencode($token);
    $mail->Body = 'Gracias por registrarte en Aventones. Por favor, haz clic en el siguiente enlace para verificar tu cuenta: <a href="' . $url_verificacion . '">Verificar Cuenta</a>';

    if(!$mail->Send()) {
        error_log('Error al enviar el correo: ' . $mail->ErrorInfo);
    } else {
        error_log('Correo de verificación enviado a: ' . $correo);
    }
}
?>