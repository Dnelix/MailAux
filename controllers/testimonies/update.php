<?php
    $jsonData = validateJsonRequest();

    //1. store jsondata into local variables. Also create an array to hold all available fields
    $provided_fields = array();
    foreach($jsonData as $data => $value){
        $$data = $value;
        if (!empty($$data)) {$provided_fields[] = $data;}
    }
    
    //2. validate required fields
    $requiredFields = array($content);
    $errorMsg = requiredFields($requiredFields, 'group');
    if (!empty($errorMsg)) {
        sendResponse(400, false, $errorMsg); exit();
    }
    
    $returnData = array();
    try{
        //update record
        $itemsArray = $provided_fields;
        $upd_tbl = $tbl;
        $rid = $tid;
        include_once('common/update_record.php');
    }
    catch (PDOException $e){
        responseServerException($e, "Failed to update data. Check for errors");
    }

    //5. Return response
    sendResponse(201, true, "Announcement updated successfully!", $returnData);
?>