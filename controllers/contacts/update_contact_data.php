<?php
    $jsonData = !empty($_FILES) ? validateFileRequest() : validateJsonRequest();

    //1. store jsondata into local variables. Also create an array to hold all available fields
    $provided_fields = array();
    foreach($jsonData as $data => $value){
        $$data = $value;
        if (!empty($$data)) {$provided_fields[] = $data;}
    }

    //2. validate required fields
    $mandatoryFields = ['email'];
    $errorMsg = validateMandatoryFields($jsonData, $mandatoryFields, 'group');
    if (!empty($errorMsg)) {
        sendResponse(400, false, $errorMsg); exit();
    }
    
    $returnData = array();
    try{
        //clean up array
        $provided_fields = array_diff($provided_fields, ['cid', 'group']); 
        $provided_fields = array_values($provided_fields);

        // sendResponse(400, false, 'here', $provided_fields);
        //update record
        $itemsArray = $provided_fields;
        $upd_tbl = $tbl;
        $rid = $cid;
        include_once('common/update_record.php');

        // Handle contact grouping
        if(isset($group) && !empty($group)){ //from jsonData
            $contact_id = $cid;
            $group_id = $group;
            require('update_contact_group.php');
        }
    }
    catch (PDOException $e){
        responseServerException($e, "Failed to update data. Check for errors");
    }

    //5. Return response
    sendResponse(201, true, "Contact information updated successfully.", $returnData);
?>