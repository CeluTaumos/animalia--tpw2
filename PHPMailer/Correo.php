<?php
//\\Exception\Exception
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer\Exception.php';
require_once 'PHPMailer\PHPMailer.php';
require_once 'PHPMailer\SMTP.php';

class Correo{
    private $correo;

    public function __construct($correo)    {
        $this->correo = $correo;
    }
    public function getCorreo($correo)
    {
        return new Correo($correo);
    }
    public function enviarCorreo($correo){
        $mail = new PHPMailer(true);
    
    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'axel.cabj.777@gmail.com';                     //SMTP username
        $mail->Password   = 'BOQUITA7';                               //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('axel.cabj.777@gmail.com', 'Mostro');
        $mail->addAddress('$correo');     //Add a recipient
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Bienvenido a Animalia';
        $mail->Body    = 'Correo de prueba';
    
        $mail->send();
        echo 'El mensaje ha sido enviado';
    } catch (Exception $e) {
        echo "Error, no se puedo enviar el mensaje. Mailer Error: {$mail->ErrorInfo}";
    }
    }
}


