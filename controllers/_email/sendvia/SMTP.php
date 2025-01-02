<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../models/mail/phpmailer/src/Exception.php';
require '../models/mail/phpmailer/src/PHPMailer.php';
require '../models/mail/phpmailer/src/SMTP.php';

$noHtml = "You are getting this message because your mail client does not support HTML messages, hence you cannot receive emails from {$company}. Kindly update your email to avoid missing out on exciting offers.";
$mail = new PHPMailer(true);
try{
    //Server settings
    $mail->SMTPDebug  = SMTP::DEBUG_SERVER;                     //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $SMTP_Host;                             //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication. Set to false if you don't want to use username and password
    $mail->Username   = $SMTP_Username;                         //SMTP username
    $mail->Password   = $SMTP_Password;                         //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
    $mail->Port       = $SMTP_Port;                             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`or 465 for ENCRYPTION_SMTPS
    
    //Recipients
    $mail->setFrom($from, $from_name);
    $mail->addAddress($to_mail, $to_name);                      //Add a recipient. Name is optional. You can also add multiple recipients
    //$mail->addAddress('ellen@example.com');
    $mail->addReplyTo($from, $from_name);
    //$mail->addCC('cc@example.com');
    $mail->addBCC($bcc);
    
    //Attachments
    // $mail->addAttachment('images/phpmailer_mini.png');       //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');       //Optional name

    //Content
    $mail->isHTML(true);                                        //Set email format to HTML
    $mail->Subject = $subject;
    //$mail->Body    = $htmlBody;                               //HTML file
    $mail->msgHTML($htmlBody, __DIR__);                         //Read HTML from external file, convert referenced images to embedded. Convert HTML into a basic plain-text alternative body
    $mail->AltBody = $noHtml;
    
    //$responseData = array();
    // $responseData['type'] = $type;
    // $responseData['subject'] = $subject;
    // $responseData['from'] = "{$from_name} ({$from})";
    // $responseData['to'] = "{$to_name} ({$to_mail})";
    //$responseData['message'] = $htmlBody;

    if(!$mail->send()) { //echo $mail->ErrorInfo; 
        sendResponse(401, false, 'Mail sending failed!', $mail->ErrorInfo);
    } else {
        sendResponse(200, true, 'Mail has been sent successfully');
    }
}
catch(Exception  $e){
    $msg = "Failed to send email. Mailer Error: {$mail->ErrorInfo}";
    sendResponse(400, false, $msg);
}
?>