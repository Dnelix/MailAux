<?php
$jsonData = validateJsonRequest();

//1. store jsondata into local variables. Also create an array to hold all available fields
$ins_fields = array();
foreach($jsonData as $data => $value){
    $$data = $value;
    if (!empty($$data)) {$ins_fields[] = $data;}
}

//2. validate required fields
$requiredFields = array($content, $postedby);
$errorMsg = requiredFields($requiredFields, 'group');
if (!empty($errorMsg)) {
    sendResponse(400, false, $errorMsg); exit();
}

//Check Limits
$totalTestm = countRecord('testimonies', 'cid='.$cid);
if($totalTestm >= $maxTestimonies){
    sendResponse(400, false, 'You have exceeded your plan limit for testimonies. Please upgrade to add more'); exit();
}

$returnData = array();
try{
    //clean up array
    if(!in_array('cid', $ins_fields)){
        array_push($ins_fields, 'cid');     //add cid if missing
    }
    
    // Insert into table
    $itemsArray = $ins_fields;              // other inputs already set from form
    $ins_tbl    = $tbl;
    require('common/insert_record.php');
    
}
catch (PDOException $e){
    responseServerException($e, "Failed to create this record. Check for errors");
}

// 8. Return outputs
sendResponse(201, true, "Testimony posted successfully", $returnData);

?>
