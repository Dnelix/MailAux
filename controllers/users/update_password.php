<?php
try{
    $password       =   $jsonData->currentpassword;
    $new_pass       =   $jsonData->newpassword;
    $new_pass_conf  =   $jsonData->confirmpassword;
    // Hash Password
    $hash_old = password_hash($password, PASSWORD_DEFAULT);
    $hash_new = password_hash($new_pass, PASSWORD_DEFAULT);

    if ($new_pass == '' || $password == ''){
        sendResponse(400, false, 'You must provide your old password and a new password to proceed'); exit();
    }
    if ($new_pass !== $new_pass_conf){
        sendResponse(400, false, 'Password mismatch. Please confirm and retry'); exit();
    }

    //Check if key strings are empty or have values above the DB limits
    $fieldLengthMsg = validateFieldLength($new_pass, 4, 200, 'New Password');
    if (!empty($fieldLengthMsg)) { 
        sendResponse(400, false, $fieldLengthMsg); exit();
    }

    //confirm details
    $query = $writeDB -> prepare('SELECT password, active, loginattempts FROM tbl_users WHERE id = :userid');
    $query -> bindParam(':userid', $uid, PDO::PARAM_STR);
    $query -> execute();

    $rowCount = $query -> rowCount();
    if($rowCount === 0 || $rowCount > 1){
        sendResponse(401, false, 'Account not found or invalid!'); exit();
    }
    $row  =  $query -> fetch(PDO::FETCH_ASSOC);
    $ret_password       = $row['password'];
    $ret_active         = $row['active'];
    $ret_loginattempts  = $row['loginattempts'];

    //Other checks
    if($ret_active !== "1"){    
        sendResponse(401, false, 'User account is not active!'); exit();
    }

    if($ret_loginattempts >= $max_loginattempts){
        sendResponse(401, false, 'Number of attempts exceeded! User account have been locked out.'); exit();
    }

    if(!password_verify($password, $ret_password)) { 
        // increment login attempts
        $query = $writeDB->prepare('UPDATE tbl_users set loginattempts = loginattempts+1 WHERE id = :id');
        $query -> bindParam(':id', $uid, PDO::PARAM_INT);
        $query -> execute();

        sendResponse(401, false, 'Current password is incorrect! Your account will be locked if you enter an incorrect password '. $max_loginattempts .' times');
    }

    //update password and loginattempts
    $query = $writeDB -> prepare('UPDATE tbl_users SET password = :password, loginattempts = 0 WHERE id = :id');
    $query -> bindParam(':id', $uid, PDO::PARAM_INT);
    $query -> bindParam(':password', $hash_new, PDO::PARAM_STR);
    $query -> execute();

    //return data
    $returnData = array();
    $returnData['user_id'] = $uid;

    sendResponse(201, true, 'Account password successfully changed', $returnData);
}
catch(Exception $e){
    responseServerException($e, 'Failed to update record. Check for errors');
}

?>