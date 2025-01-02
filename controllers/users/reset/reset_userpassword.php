<?php
    $newPass = $jsonData->newPassword;
    $confPass = $jsonData->confPassword;
    $auth = $jsonData->auth;
    $uid = $jsonData->uid;

    $fieldLengthMsg = validateFieldLength($newPass, 5, 250, "Password");
    if($fieldLengthMsg){
        sendResponse(400, false, $fieldLengthMsg); exit();
    }
    
    if($confPass !== $newPass){
        sendResponse(400, false, 'Password mismatch! Please confirm and try again'); exit();
    }

    if(substr($auth, 0, 12) !== substr($ret_password, 0, 12)) { //compare 1st 12 chars
        sendResponse(401, false, 'Invalid authentication token!'); exit();
    }

    try{
        $hash_pass = password_hash($newPass, PASSWORD_DEFAULT);
    
        //update password and loginattempts
        $query = $writeDB -> prepare('UPDATE tbl_users SET password = :password, loginattempts = 0 WHERE id = :id');
        $query -> bindParam(':id', $uid, PDO::PARAM_INT);
        $query -> bindParam(':password', $hash_pass, PDO::PARAM_STR);
        $query -> execute();
    
        //return data
        $returnData = array();
        $returnData['userid'] = $uid;
    
        sendResponse(201, true, 'Account password successfully changed. Login with your new password.', $returnData);
    }
    catch(Exception $e){
        responseServerException($e, 'Failed to update record. Check for errors');
    }
?>