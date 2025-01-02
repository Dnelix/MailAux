<?php
    $jsonData = !empty($_FILES) ? validateFileRequest() : validateJsonRequest();

    //1. store jsondata into local variables. Also create an array to hold all available fields
    $provided_fields = array();
    foreach($jsonData as $data => $value){
        $$data = $value;
        if (!empty($$data)) {$provided_fields[] = $data;}
    }
    
    //handle checkboxes
    $checkboxes = ['testimonies', 'sermons', 'giving', 'webstatus'];
    foreach ($checkboxes as $checkbox) {
        $$checkbox = isset($$checkbox) ? (($$checkbox === false) ? 0 : 1) : null;
    }
    //sendResponse(401, false, $webtheme, $sermons); exit();

    //generate URL
    if(isset($webtheme) && !empty($webtheme)){
        $weburl = $c_website.'church/?theme='.$webtheme.'&cid='.$cid;
        if(!in_array('weburl', $provided_fields)){
            array_push($provided_fields, 'weburl');     //add weburl if missing
        }
    }

    $returnData = array();
    try{
        // upload images and return file URL
        if (!empty($_FILES)) {
            $img_filename  = "logo";
            
            if(!isset($churchid)){sendResponse(400, false, 'Missing Folder Identifier'); exit();}
            $uploadFolderURL = $uploadPath.$churchid."/";

            $newFileName = $img_filename;
            $img_path = uploadFile($img_filename, $uploadFolderURL, $newFileName);
            
            array_push($provided_fields, $img_filename);    //add field to the provided_fields array
            $$img_filename = $img_path;                     //set field value for insert
        }
        
        //clean up array
        if(in_array('cid', $provided_fields)){
            $provided_fields = array_diff($provided_fields, ['cid']);   // Remove the cid field from the array as we don't want to update the cid
            $provided_fields = array_values($provided_fields);          // Reindex the array to maintain numeric keys
        }
        //sendResponse(401, false, $$img_filename, $provided_fields); exit();
        
        //update record
        $itemsArray = $provided_fields;
        $upd_tbl = $tbl;
        $rid = $cid;
        include_once('common/update_record.php');
    }
    catch (PDOException $e){
        responseServerException($e, "Failed to update data. Check for errors");
    }

    //5. Return response
    sendResponse(201, true, "Information updated successfully for this $church. Some changes may take time to reflect.", $returnData);
?>