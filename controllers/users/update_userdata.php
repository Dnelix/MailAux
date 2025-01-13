<?php
    //1. validate mandatory fields
    $mandatoryFields = array('username', 'fullname', 'phone');
    $errorMsg = validateMandatoryFields($jsonData, $mandatoryFields);
    if (!empty($errorMsg)) {
        sendResponse(400, false, $errorMsg); exit();
    }

    $provided_fields = array();
    foreach($jsonData as $data => $value){
        $$data = $value;
        if (!empty($$data)) {$provided_fields[] = $data;}
    }

    //2. Check if key strings are empty or have values above the DB limits
    $fieldLengthMsg = validateFieldLength($jsonData->fullname, 2, 30, 'Full Name');
    $fieldLengthMsg .= validateFieldLength($jsonData->phone, 5, 15, 'Phone Number');
    if (!empty($fieldLengthMsg)) {
        sendResponse(400, false, $fieldLengthMsg); exit();
    }
    
    //3. Verify username
    $query = $writeDB -> prepare('SELECT id FROM '. $tbl .' WHERE username = :uname AND id != :uid');
    $query -> bindParam(':uname', $username, PDO::PARAM_STR);
    $query -> bindParam(':uid', $uid, PDO::PARAM_STR);
    $query -> execute();
    $rowCount = $query -> rowCount();
    if($rowCount > 0){
        sendResponse(400, false, 'Username already taken; try another name'); exit();
    }

    //clean up array
    if(in_array('userid', $provided_fields)){
        $provided_fields = array_diff($provided_fields, ['userid']);
        $provided_fields = array_values($provided_fields);
    }

    $returnData = array();
    //4. update user record
    $itemsArray = $provided_fields;
    $upd_tbl = 'tbl_users';
    $rid = $uid;
    include_once('common/update_record.php');

    //5. Return response
    sendResponse(201, true, 'Profile information updated! Changes will reflect as soon as they are approved', $returnData);
?>