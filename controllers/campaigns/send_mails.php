<?php
//1. Get campaign data
$campaign = retrieveDataFrom($c_website.'controllers/campaigns.php?uid='.$uid.'&cmid='.$cmid);
$cm_data = (isset($campaign->data) ? $campaign->data : []);

if (empty($cm_data->contacts)) {
    sendResponse(400, false, 'No contacts available for this campaign.');
    exit;
}
$contacts = explode(",", $cm_data->contacts);

//2. Process mails
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '../models/mail/phpmailer/src/Exception.php';
require '../models/mail/phpmailer/src/PHPMailer.php';
require '../models/mail/phpmailer/src/SMTP.php';

$noHtml = "You are getting this message because your mail client does not support HTML messages, hence you cannot receive emails from {$company}. Kindly update your email to avoid missing out on exciting offers.";
$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = $SMTP_Host;
$mail->SMTPAuth = true;
$mail->Username = $SMTP_Username;
$mail->Password = $SMTP_Password;
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->CharSet = 'UTF-8';

$e_msg = [];
$batchSize = 50;
$batchCount = 0;

foreach ($contacts as $c){
    $to_name    = generateNameFromEmail($c);
    $to_mail    = trim($c);
    $subject    = $cm_data->title;
    $htmlBody   = $cm_data->content;
    $from_name  = $cm_data->from_name;
    $from       = $cm_data->from_email;

    try {
        $mail->clearAddresses();
        $mail->setFrom($from, $from_name);
        $mail->addAddress($to_mail, $to_name);
        $mail->addReplyTo($from, $from_name);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $htmlBody;
        $mail->AltBody = $noHtml;

        if(!$mail->send()) {
            $e_msg['error'][] = "Mail sending to $to_mail failed. Error: {$mail->ErrorInfo}";
        } else {
            $e_msg['success'][] = "Email sent to $to_mail successfully.";
        }
    } catch (Exception $e) {
        $e_msg['error'][] = "Failed to send email to $to_mail. Error: {$mail->ErrorInfo}";
    }

    $batchCount++;
    if ($batchCount >= $batchSize) {
        sleep(10); // Pause to prevent server overload
        $batchCount = 0;
    }
}

//update record
$itemsArray = ['status', 'logs', 'updated'];
$status = 'Completed';
$logs = json_encode($e_msg);
$updated = date($mysql_dateformat);
$upd_tbl = 'tbl_campaigns';
$rid = $cmid;
include_once('common/update_record.php');

sendResponse(200, true, 'Email processing completed. Check for errors', $e_msg);
?>