<?php
## Get externally
// $to_name, $to_mail, $subject, $htmlBody, $from_name, $from, $reply_to
    try{
        $to = "$to_name <$to_mail>";
        $subject = $subject;
        $message = $htmlBody;
        $headers = "From: $from_name <$from>";
        $headers .= "\r\nReply-To: $reply_to";
        $headers .= "\r\nMIME-Version: 1.0";
        $headers .= "\r\nContent-Type: text/html; charset=UTF-8";
        $headers .= "\r\nX-Mailer: PHP/" . phpversion();
    
        $mailSuccess = mail($to, $subject, $message, $headers);
    
        if ($mailSuccess) {
            sendResponse(200, true, 'Mail has been sent successfully');
        } else {
            sendResponse(401, false, 'Mail sending failed!', error_get_last());
        }
    }
    catch(Exception  $e){
        $msg = "Failed to send email. Mailer Error: {$e}";
        sendResponse(400, false, $msg);
    }
?>