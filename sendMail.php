<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function sendMail($to)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER; 
        $mail->isSMTP(); 
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'pranjulkushwaha048@gmail.com'; 
        $mail->Password = 'cgyapodakujweffo'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port = 465; 

        //Recipients
        $mail->setFrom('pranjulkushwaha048@gmail.com', 'Quizlet');
        $mail->addAddress($to); //Add a recipient

        //Content
        $mail->isHTML(true); 
        $mail->Subject = 'One time password - Quizlets.net';
        $OTP = random_int(100000, 999999);
        $message = 'Your OTP is ' . $OTP;
        $mail->Body = $message;
        $mail->AltBody = $message;

        $mail->send();
        
        return array('status' => true, 'otp' => $OTP, 'message' => 'OTP sent SuccessFully');

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return array('status' => false, 'otp' => null, 'message' => 'OTP not Sent');
    }


}

?>