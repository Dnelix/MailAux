<?php
$jsonData = validateJsonRequest();
$userData = $jsonData -> uname;     //data can be email or username

if(empty($userData)){ sendResponse(400, false, 'Invalid reset data'); exit();}

//confirm details
$query = $writeDB -> prepare('SELECT id, username, password, email, active FROM '. $tbl .' WHERE username = :uname OR email = :umail LIMIT 1');
$query -> bindParam(':uname', $userData, PDO::PARAM_STR);
$query -> bindParam(':umail', $userData, PDO::PARAM_STR);
$query -> execute();

$rowCount = $query -> rowCount();
if($rowCount === 0 || $rowCount > 1){
    sendResponse(401, false, 'We cannot find this record on our servers. Please check again or sign up for a new account'); exit();
}
$row  =  $query -> fetch(PDO::FETCH_ASSOC);
$ret_id             = $row['id'];
$ret_username       = $row['username'];
$ret_email          = $row['email'];
$ret_password       = $row['password'];
$ret_active         = $row['active'];

if($ret_active !== "1"){    
    sendResponse(401, false, 'User account is not active!'); exit();
}

//send to relevant endpoints
if(!isset($jsonData->newPassword)) {
    require_once('reset/send_reset_link.php');
} else if (isset($jsonData->newPassword)){
    require_once('reset/reset_userpassword.php');
} else {
    sendResponse(401, false, 'Invalid request method or parameters'); exit();
}

?>