<?php
#### Get from outside this file
## $itemsArray = array(); //with thier values (must contain $name)
## $uid
## $ins_tbl
$uid=isset($uid) ? $uid : (isset($userid)?$userid : $loguserid);

$returnData = array();
try{    
    // Insert into table
    require('common/insert_record.php');
    
    // Send mails
    $username = getuserDataById($uid, 'username');
    $email    = getuserDataById($uid, 'email');
    $subject = "Business profile created on $company";
    $message = "We have set up a business profile for you on $company. Thanks for choosing us, we are happy to support you all the way if you have any issues.";

    $sendMail = sendEmail('general', $subject, $email, "$company Customer Service", $message, $company);
    $returnData['sendmail'] = $sendMail;
}
catch (PDOException $e){
    responseServerException($e, "Failed to create this $church. Check for errors");
}

?>