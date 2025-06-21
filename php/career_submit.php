<?php
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtpout.secureserver.net';         // Use your SMTP provider
        $mail->SMTPAuth   = true;
        $mail->Username   = 'shivani@firststepadvisors.in';    // ✅ Your Gmail ID
       $mail->Password = 'Jorsa@123'; // Your SMTP password
       $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Use ENCRYPTION_SMTPS for port 465
        $mail->Port = 465; // TCP port to connect to


        // Sender & recipient
        $mail->setFrom('yourgmail@gmail.com', 'Career Form');
        $mail->addAddress('Office@firststepadvisors.in');

        // Form fields
        $name = htmlspecialchars($_POST['name']);
        $message = htmlspecialchars($_POST['message']);

        // Email body
        $mail->Subject = 'New Career Application';
        $mail->Body    = "Name: $name\nMessage:\n$message";

        // Attach the resume
        if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
            $mail->addAttachment($_FILES['resume']['tmp_name'], $_FILES['resume']['name']);
        }

        $mail->send();
        echo "Application sent successfully.";
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}