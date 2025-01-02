<?php
    $jsonData = validateJsonRequest();

    //1. store jsondata into local variables. Also create an array to hold all available fields
    $provided_fields = array();
    foreach($jsonData as $data => $value){
        $$data = $value;
        if (isset($$data)) {$provided_fields[] = $data;}
    }
    
    //handle checkboxes
    $checkboxes = ['testimonies', 'sermons', 'giving', 'webstatus'];
    foreach ($checkboxes as $checkbox) {
        $$checkbox = isset($$checkbox) ? (($$checkbox === false) ? 0 : 1) : null;
    }
    //sendResponse(401, false, $sermons, $provided_fields); exit();

    //generate URL
    if(isset($webtheme) && !empty($webtheme)){
        $weburl = $c_website.'church/?theme='.$webtheme.'&cid='.$cid;
        if(!in_array('weburl', $provided_fields)){
            array_push($provided_fields, 'weburl');     //add weburl if missing
        }
    }

    $returnData = array();
    try{
        //clean up array
        if(in_array('cid', $provided_fields)){
            $provided_fields = array_diff($provided_fields, ['cid']);
            $provided_fields = array_values($provided_fields);
        }
        
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
    sendResponse(201, true, "Successfully updated preferences for this $church. Some changes may take time to reflect.", $returnData);
?>