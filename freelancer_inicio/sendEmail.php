<?php
use PHPMailer\PHPMailer\PHPMailer;
if(isset($_POST['mame']) && isset($_POST['email'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $mensaje = $_POST['mensaje'];

    require_once "PHPMailer/PHPMailer.php";
    require_once "PHPMailer/SMTP.php";
    require_once "PHPMailer/Exception.php";

    $mail = new PHPMailer();
    
    //smtp settings
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "testmikel209@gmail.com";
    $mail->Password = 'Papito777';
    $mail->Port = 465;
    $mail->SMTPSecure = "ssl";

    //email settings
    $mail->isHTML(true);
    $mail->setFrom($email, $name);
    $mail->addAddress("testmikel209@gmail.com");
    $mail->Subject = ("$email ($subject)");
    $mail->mensaje = $mensaje;

    if($mail->send()){
        $status = "success";
        $response = "Email is sent!";
    }else{
        $status = "failed";
        $responde = "Something is worjng: <br>" . $mail->ErrorInfo;
    }

    exit(json_encode(array("status"=> $status, "response"=>$response)));
}

?>