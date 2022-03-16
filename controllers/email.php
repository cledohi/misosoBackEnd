<?php
namespace App\Controllers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Exception;
//From PHPMailer
require("../vendor/phpmailer/phpmailer/src/PHPMailer.php");
require("../vendor/phpmailer/phpmailer/src/SMTP.php");
require("../vendor/phpmailer/phpmailer/src/Exception.php");

use PDO;
use Slim\Http\UploadedFile;
//use Exception;

class EmailController
{

    public function sendEmail($request, $response, $args)
    {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer();

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.misoso.rw';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'info@misoso.rw';                     //SMTP username
            $mail->Password   = 'D,x$TFNXoDxx';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('misosoltd@gmail.com', 'Mailer');
            $mail->addAddress('misosoltd@gmail.com', 'MISOSO LTD');     //Add a recipient
            $mail->addAddress('misosoltd@gmail.com');               //Name is optional
            $mail->addReplyTo('cledohi@gmail.com', 'harerimana dominique');
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'OTP Verfication';
            $mail->Body    = 'Dear Misoso Visitor your code is 22612';
            $mail->AltBody = 'Welcome to misoso ltd';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$e->getMessage()}";
        }
    }
}
