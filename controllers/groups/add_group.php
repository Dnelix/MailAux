<?php
$jsonData = validateJsonRequest();

//1. store jsondata into local variables. Also create an array to hold all available fields
$ins_fields = array();
foreach($jsonData as $data => $value){
    $$data = $value;
    if (!empty($$data)) {$ins_fields[] = $data;}
}
//2. validate required fields
$mandatoryFields = ['group_name'];
$errorMsg = validateMandatoryFields($jsonData, $mandatoryFields, 'group');
if (!empty($errorMsg)) {
    sendResponse(400, false, $errorMsg); exit();
}

//Check Limits
$max_groups = getPlanData($uid, 'uid', 'max_groups');
$totalgroups = countRecord('groups', 'uid='.$uid);

if($totalgroups >= $max_groups){ //from auth
    sendResponse(400, false, 'You have exceeded your plan limit for user groups. Please upgrade to add more groups'); exit();
}

$returnData = array();
try{
    //clean up array
    if(!in_array('userid', $ins_fields)){
        array_push($ins_fields, 'userid');     //add uid if missing
        $userid = $uid;
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
sendResponse(201, true, "Mailing group created successfully", $returnData);

?>
