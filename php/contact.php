<?php
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "contact_send") {

    // Collect form data with null coalescing operator for safety
    $name    = $_POST['contact']['name']['required'] ?? '';
    $email   = $_POST['contact']['email']['required'] ?? '';
    $phone   = $_POST['contact']['phone'] ?? '';
    $subject = $_POST['contact']['subject']['required'] ?? '';
    $message = $_POST['contact']['message'] ?? '';

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        die("Please fill in all required fields.");
    }

    $mail = new PHPMailer(true); // Passing `true` enables exceptions

    try {
        // SMTP server configuration
        $mail->isSMTP();
        $mail->Host       = 'smtpout.secureserver.net';         // Your SMTP server (e.g., Gmail)
        $mail->SMTPAuth   = true;
        $mail->Username   = 'Csshivani2014@gmail.com';   // Your SMTP username (your email)
        $mail->Password   = 'Shivani@9899';      // Your SMTP password (app password for Gmail)
       $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // or ENCRYPTION_STARTTLS for port 587
        $mail->Port       = 465;                      // TCP port to connect to

        // Sender and recipient settings
        $mail->setFrom($email, $name);                 // From the user's email
        $mail->addAddress('office@firststepadvisors.in', 'Shivani');  // Your email to receive the message
        $mail->addReplyTo($email, $name);              // Reply to user's email

        // Email content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "
            <h3>New Contact Form Submission</h3>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Phone:</strong> {$phone}</p>
            <p><strong>Subject:</strong> {$subject}</p>
            <p><strong>Message:</strong><br>" . nl2br(htmlspecialchars($message)) . "</p>
        ";
        $mail->SMTPDebug = 2; 
        $mail->Debugoutput = 'html';
        $mail->send();
        echo "Message has been sent successfully!";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

} else {
    echo "Invalid request.";
}