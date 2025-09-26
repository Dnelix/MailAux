<?php
    $jsonData = isset($_FILES) ? validateFileRequest() : validateJsonRequest();

    //1. store jsondata into local variables. Also create an array to hold all available fields
    $provided_fields = array();
    foreach($jsonData as $data => $value){
        $$data = $value;
        if (!empty($$data)) {$provided_fields[] = $data;}
    }
    
    if($userid != $uid){ sendResponse(400, false, "Authentication Error!", [$userid, $uid]); exit();}

    //2. validate required fields
    $requiredFields = ['name', 'email', 'description', 'address'];
    $errorMsg = requiredFields($requiredFields, 'single');
    if (!empty($errorMsg)) {
        sendResponse(400, false, $errorMsg); exit();
    }

    $returnData = array();
    try{
        // upload images and return file URL
        if (!empty($_FILES)) {
            $img_filename  = "logo";
            
            if(!isset($bid)){sendResponse(400, false, 'Missing Folder Identifier'); exit();}
            $uploadFolderURL = $uploadPath.$bid."/";

            $newFileName = $img_filename;
            $img_path = uploadFile($img_filename, $uploadFolderURL, $newFileName);
            
            array_push($provided_fields, $img_filename);    //add field to the provided_fields array
            $$img_filename = $img_path;                     //set field value for insert
        }
        
        //update record
        $itemsArray = $provided_fields;
        $upd_tbl = $tbl;
        $rid = $bid;
        include_once('common/update_record.php');
    }
    catch (PDOException $e){
        responseServerException($e, "Failed to update data. Check for errors");
    }

    //5. Return response
    sendResponse(201, true, "Business information updated successfully. Some changes may take time to reflect.", $returnData);
?>