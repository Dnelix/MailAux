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
// Include the PHPMailer library
require '../models/mail/phpmailer/src/PHPMailer.php';
require '../models/mail/phpmailer/src/Exception.php';
require '../models/mail/phpmailer/src/SMTP.php';

$batchSize = 50;
$batchCount = 0;
$e_msg = [];

foreach ($contacts as $c){
    $to_name    = generateNameFromEmail($c);
    $to_mail    = trim($c);
    $subject    = $cm_data->title;
    $message    = $cm_data->content;
    $sender_name= $cm_data->from_name;

    $e_msg[] = sendEmail2($subject, $to_mail, $to_name, $message, $sender_name, false);

    $batchCount++;
    //##fixed sleeping
    // if ($batchCount >= $batchSize) {
    //     sleep(10); // Pause to prevent server overload
    //     $batchCount = 0;
    // }

    //## Throttle
    if ($batchCount >= $batchSize) {
        if ((microtime(true) - $startTime) < 60) {
            sleep(60 - (microtime(true) - $startTime));
        }
        $startTime = microtime(true);
        $batchCount = 0;
    }
}

//update record
$itemsArray = ['status', 'logs', 'updated'];
$status = 'Completed';
$logs = json_encode($e_msg, JSON_PARTIAL_OUTPUT_ON_ERROR);
$updated = date($mysql_dateformat);
$upd_tbl = 'tbl_campaigns';
$rid = $cmid;
include_once('common/update_record.php');

sendResponse(200, true, 'Email processing completed.', $e_msg);
?>