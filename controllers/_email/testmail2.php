<?php
require_once '../../_base/_constants.php';
require_once '../../_base/_functions.php';

// Include the PHPMailer library
require '../../models/mail/phpmailer/src/PHPMailer.php';
require '../../models/mail/phpmailer/src/Exception.php';
require '../../models/mail/phpmailer/src/SMTP.php';

// Email configuration
$subject = 'New Email Testing';
$to_mail = 'chinelix05@gmail.com';
$to_name = 'Felix';
$sender_name = 'Jailer';
$message = "<p>This is a <b>test email</b> to confirm that $company email works <i> CONGRATULATIONS</i>.";

// Call the function to send the email and test how long it takes to execute
$start = microtime(true);
    $e_msg = sendEmail2($subject, $to_mail, $to_name, $message, $sender_name, false);
$end = microtime(true);

echo "Execution Time: " . ($end - $start) . " seconds";
print_r($e_msg);
?>