<?php
$password_reset_link = $newPassword_link."&auth=".$ret_password."&i=".$ret_id;

$username = $ret_username;
$type    = "reset";
$subject = "Password Reset Request on $company";
$to_mail = $ret_email;
$to_name = $username;
$message = "Hi $username, you are getting this mail because you requested to reset your password on $company. If you did not initiate this request, simply delete this mail and do not share with anyone else. Else click on the link below (or copy and paste the link to your browser) to complete your password reset. <br><br> <a href='$password_reset_link'> $password_reset_link </a> <br>";
$sender  = $company;

$sendMail = sendEmail($type, $subject, $to_mail, $to_name, $message, $sender);
$returnData = array();
$returnData['sendmail'] = $sendMail;

sendResponse(200, true, "We have mailed you a link to reset your password. Please check your inbox at $to_mail or check your spam if you can't find the mail in your inbox.", $returnData);
?>