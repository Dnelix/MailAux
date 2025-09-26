<?php
$jsonData = validateJsonRequest();

//1. validate mandatory fields
$mandatoryFields = array('password', 'email', 'bizname', 'accept_terms');
$errorMsg = validateMandatoryFields($jsonData, $mandatoryFields);
if (!empty($errorMsg)) {
    sendResponse(400, false, $errorMsg); exit();
}

//2. Check if key strings are empty or have values above the DB limits
$fieldLengthMsg = '';
$fieldLengthMsg .= validateFieldLength($jsonData->password, 6, 12, 'Password');
//$fieldLengthMsg .= validateFieldLength($jsonData->phone, 5, 15, 'Phone Number');
$fieldLengthMsg .= validateFieldLength($jsonData->email, 5, 100, 'Email');
if (!empty($fieldLengthMsg)) { 
    sendResponse(400, false, $fieldLengthMsg); exit(); 
}

//3. Collate data and strip off white spaces
$phone = isset($jsonData->phone) ? trim($jsonData->phone) : null;
$bizname = isset($jsonData->bizname) ? trim($jsonData->bizname) : null;
$username = isset($jsonData->username) ? preg_replace("/[^a-zA-Z0-9]+/", "", $jsonData->username) : null; //only alphanumeric characters
$email = (isset($jsonData->email) ? trim($jsonData->email) : "" );
$password = isset($jsonData->password) ? $jsonData->password : getRandomPassword(8); //generate a random 8-digit password
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    sendResponse(400, false, "Invalid email address!"); exit();
}

//4. Set defaults
$createdon = date($dateformat);
if ($email !== "" && empty($username)){
    $email_parts = explode("@", $email);
    $username = strtolower($email_parts[0]); //create temporal username from email
} else if(empty($email) && !empty($username)){
    $email = $username.'@'.$c_shortsite; // create temporal email from username
}

//5. Verify if user record already exists
$query = $writeDB -> prepare('SELECT id FROM '. $tbl .' WHERE phone = :phone OR email = :email');
$query -> bindParam(':phone', $phone, PDO::PARAM_STR);
$query -> bindParam(':email', $email, PDO::PARAM_STR);
$query -> execute();
$rowCount = $query -> rowCount();
if($rowCount > 0){
    sendResponse(400, false, 'This user record already exists. Please login instead or select forgot password to reset your password'); exit();
}

//6. Verify username
$query = $writeDB -> prepare('SELECT id FROM '. $tbl .' WHERE username = :uname');
$query -> bindParam(':uname', $username, PDO::PARAM_STR);
$query -> execute();
$rowCount = $query -> rowCount();
if($rowCount > 0){
    sendResponse(400, false, 'Username/email already taken; try another option'); exit();
}

//7. Verify referee (if set)
if(isset($jsonData -> referral) && !empty($jsonData -> referral)){
    $refcode = $jsonData -> referral; //Referral code is in the format $sitecode.$id
    $refid = intval(str_replace($sitecode, "", $refcode)); //extract refid from refcode
    $ref_username = getuserDataById($refid, 'username');
    if(!$refid || empty($refid) || !$ref_username || empty($ref_username)){
        sendResponse(400, false, 'Invalid referral code. Review or remove.'); exit();
    }
}

try{
    //8. Create User (You cannot use transaction rollback if a part of the code is waiting on last_insert_id)
    $hash_pass = password_hash($password, PASSWORD_DEFAULT); // hash password

    $default_role = "user"; $default_planID = 1;
    $fields = 'username, password, email, phone, active, role, planid, createdon';
    $values = ':username, :password, :email, :phone, "1", :role, :planid, STR_TO_DATE(:createdon, '.$write_dateformat.')';
    $query = $writeDB -> prepare('INSERT INTO '. $tbl .' ('.$fields.') VALUES('.$values.')');
    $query -> bindParam(':username', $username, PDO::PARAM_STR);
    $query -> bindParam(':password', $hash_pass, PDO::PARAM_STR);
    $query -> bindParam(':email', $email, PDO::PARAM_STR);
    $query -> bindParam(':phone', $phone, PDO::PARAM_STR);
    $query -> bindParam(':role', $default_role, PDO::PARAM_STR);
    $query -> bindParam(':planid', $default_planID, PDO::PARAM_INT);
    $query -> bindParam(':createdon', $createdon, PDO::PARAM_STR);
    $query -> execute();

    $rowCount = $query -> rowCount();
    if($rowCount === 0) {
        sendResponse(500, false, 'Unable to create user data in user DB'); exit();
    }

    $insertID = validateNum($writeDB->lastInsertId());
    ##### create other stuff using the insertID #####

    //create a business profile for the user
    $uid = $insertID;
    $ins_tbl = 'tbl_business';
    $itemsArray = ['userid', 'name', 'email'];
    $userid = $uid;
    $name = $bizname;
    $email = strtolower(str_replace(' ', '', $bizname)).'@'.$c_shortsite; //temporal business email
    require_once('business/insert_biz_record.php');

    //9. return the newly created user details
    $returnData = array();
    $returnData['uid'] = $insertID;
    $returnData['username'] = $username;
    $returnData['email'] = $email;
    $returnData['phone'] = $phone;
    $returnData['createdon'] = $createdon;

    //10. send emails
    $subject = "New signup on $company";
    $message = "Hi $username, thanks for signing up on $company. We hope your experience is awesome. Login to {$c_shortsite} to get started.";
    $sendMail = sendEmail('welcome', $subject, $email, $username, $message, $company);

    $messageAdm = "Hi Admin, the user $username ($email) just registered on $company. We are currently setting up his account. Login to {$c_shortsite} with your admin credentials to manage your users.";
    $sendAdm = sendEmail('welcome', $subject, $p_email, $username, $messageAdm, $company);

    $returnData['usermail'] = $sendMail;
    $returnData['adminmail'] = $sendAdm;

    //add referral information
    if(isset($jsonData -> referral) && !empty($jsonData -> referral)){
        $referee = $refid;
        $referral = $insertID;
        $commission = $referralBonus; //global
        
        require_once('referrals/insert_ref_info.php');
    }

    //Login user immediately
    $ret_id         = $insertID;
    $ret_username   = $username;
    $ret_role       = $default_role;
    require_once('sessions/login.php');

    sendResponse(201, true, 'Successfully logged in', $returnData);
    
}
catch(PDOException $e){
    responseServerException($e, 'There was an issue with user creation. Please try again');
}

?>