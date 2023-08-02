<?php
// Show PHP errors (Disable in production)
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Include library PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Start
$mail = new PHPMailer(true);

try {
    // Configuration SMTP
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                         // Show output (Disable in production)
    $mail->isSMTP();                                               // Activate SMTP sending
    $mail->Host  = 'smtp.titan.email';                     // SMTP Server
    $mail->SMTPAuth  = true;                                       // SMTP Identification
    $mail->Username  = 'info@thecodecrushers.com';                  // SMTP User
    $mail->Password  = 'jPWarvGVEH';	                    // SMTP Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port  = 587;
    $mail->setFrom('info@thecodecrushers.com', 'Task Manager');                // Mail sender

    // Recipients
    $mail->addAddress('majeed544@gmail.com', 'Yasir Majeed');  // Email and recipient's name

    // Mail content
    $mail->isHTML(true);
    $mail->Subject = 'There is an update to the Loan File';
    $mail->Body  = 'Mail content <b>in HTML!</b>';
    $mail->AltBody = 'Mail content in plain text for mail clients that do not support HTML';
    $mail->send();
    echo 'The message has been sent';
} catch (Exception $e) {
    echo "Message has not been sent. Mailer Error: {$mail->ErrorInfo}";
}