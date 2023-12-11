<?php

require('src/PHPMailer/src/Exception.php');
require 'src/PHPMailer/src/PHPMailer.php';
require 'src/PHPMailer/src/SMTP.php';
require("src/vendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class MailerService
{
    public function sendMailTicket($para, $mensaje)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP de Gmail
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Desactiva la salida de depuración (puedes cambiarlo según tus necesidades)
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Servidor SMTP de Gmail
            $mail->SMTPAuth   = true;
            $mail->Port       = 587; // Puerto SMTP de Gmail
            $mail->Username   = 'emiliosrestaurant16@gmail.com'; // Tu dirección de correo de Gmail
            $mail->Password   = 'omyhatsjargyhrce'; // Tu contraseña de Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilita el cifrado TLS

            // Configuración de los destinatarios y contenido del correo
            $mail->setFrom('ronbot1223@gmail.com', '¡Emilios Locuras Gastronómicas!
            '); // Tu dirección de correo y tu nombre
            $mail->addAddress($para); // Dirección de correo del destinatario y su nombre
            $mail->isHTML(true);
            $mail->Subject = 'GRACIAS POR SU COMPRA';
            $mail->Body = $mensaje;
            $mail->AltBody = 'Comprobante de pago';
            // Envía el correo
            $mail->send();
            echo 'El mensaje ha sido enviado';
        } catch (Exception $e) {
            echo "No se pudo enviar el mensaje. Error del remitente: {$mail->ErrorInfo}";
        }
    }
}

// Uso del método
//$mailer = new MailerService();
//$mailer->sendMail('deco14m@gmail.com', 'asdasdasdasdasd', 'dsasdasdas');
