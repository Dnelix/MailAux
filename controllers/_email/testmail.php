<?php
// Include the PHPMailer library
require '../../models/mail/phpmailer/src/PHPMailer.php';
require '../../models/mail/phpmailer/src/Exception.php';
require '../../models/mail/phpmailer/src/SMTP.php';

// Email configuration
$sender_email = 'mail@mailaux.com';
$sender_password = 'mailaux_mail1';
$recipient_email = 'chinelix05@gmail.com';
$subject = 'Testing email script';
$body = 'This is a test email sent from a PHP script.';

// SMTP (sending) server details
$smtp_server = 'smtp.titan.email';
$smtp_port = 587;

// IMAP (receiving) server details
$imap_server = 'imap.titan.email';
$imap_port = 993;

function send_email() {
    global $sender_email, $sender_password, $recipient_email, $subject, $body, $smtp_server, $smtp_port, $imap_server, $imap_port;

    // Create a PHPMailer object
    $mail = new \PHPMailer\PHPMailer\PHPMailer();

    try {
        // Configure the SMTP settings
        $mail->isSMTP();
        $mail->Host = $smtp_server;
        $mail->Port = $smtp_port;
        $mail->SMTPAuth = true;
        $mail->Username = $sender_email;
        $mail->Password = $sender_password;
        $mail->SMTPSecure = 'tls';

        // Set the email content
        $mail->setFrom($sender_email);
        $mail->addAddress($recipient_email);
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Send the email
        if ($mail->send()) {
        echo 'Email sent successfully.';
        } else {
        echo 'Error sending email: ' . $mail->ErrorInfo;
        return;
        }

        // Append the sent email to the IMAP server's "Sent" folder
        // Enable the IMAP extension from your php.ini file
        $imap_stream = imap_open("{" . $imap_server . ":" . $imap_port . "/ssl/novalidate-cert}", $sender_email, $sender_password);
        if ($imap_stream) {
        imap_append($imap_stream, "{" . $imap_server . ":" . $imap_port . "/ssl/novalidate-cert}Sent", $mail->getSentMIMEMessage());
        echo 'Email appended to "Sent" folder.';
        imap_close($imap_stream);
        } else {
        echo 'Error appending email to "Sent" folder.';
        }
    } catch (Exception $e) {
        echo 'Error sending email: ' . $e->getMessage();
    }
}

// Call the function to send the email and append it to the "Sent" folder
send_email();
?>