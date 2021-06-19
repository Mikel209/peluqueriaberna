<?php
use PHPMailer\PHPMailer\PHPMailer;

require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

$mail = new PHPMailer(true);

$alert = '';
    
if(isset($_POST['submit'])){
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    try{
    //smtp settings
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = 'testmikel209@gmail.com';
    $mail->Password = 'Papito777';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = '587';

    //email settings
    $mail->setFrom('testmikel209@gmail.com');
    $mail->addAddress('testmikel209@gmail.com');
    
    $mail->isHTML(true);
    $mail->Subject = 'Message received (Contact Page)';
    $mail->Body = '<h3>Name : $nombre <br>Email: $email <br>Message : $mensaje</h3>';

    $mail->send();
    $alert = '<span>Message Sent! Thank you for contacting us.</span>';
    }catch (Exception $e){
        $alert = '<span>'.$e->getMessage().'</span>';

    }
       
}

?>