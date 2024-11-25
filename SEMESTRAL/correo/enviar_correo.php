<?php
// Incluir los archivos de PHPMailer
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['enviar_correo'])) {
    $correo_destinatario = $_POST['correo'];
    $mensaje = $_POST['mensaje'];

    // Crear una instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->SMTPDebug = 2;                      //Enable verbose debug output
        $mail->isSMTP();
        $mail->Host       = 'smtp-mail.outlook.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'castulocastillo28@hotmail.com'; // Tu correo
        $mail->Password   = 'pqoiegadfxwfaqia';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Tipo de encriptación
        $mail->Port = 587;

     
        // Configuración del correo
        $mail->setFrom('castulocastillo28@hotmail.com', 'Castulo Alejandro Castillo Lamela');
        $mail->addAddress($correo_destinatario); // Destinatario

        $mail->isHTML(true);
        $mail->Subject = 'Asunto del Correo';
        $mail->Body = $mensaje; // Mensaje del formulario

        // Enviar el correo
        $mail->send();
        echo "Correo enviado correctamente a $correo_destinatario.";
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
?>