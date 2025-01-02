<?php
$jsonData = validateJsonRequest();

//1. store jsondata into local variables. Also create an array to hold all available fields
$ins_fields = array();
foreach($jsonData as $data => $value){
    $$data = $value;
    $ins_fields[] = $data;
}

//2. validate required fields
$mandatoryFields = ['name'];
$errorMsg = validateMandatoryFields($jsonData, $mandatoryFields, 'group');
if (!empty($errorMsg)) {
    sendResponse(400, false, $errorMsg); exit();
}

if(!isset($jsonData -> createdon)){
    array_push($ins_fields, 'createdon');   //add createdon field to the array
    $createdon  = date($mysql_dateformat);  //set createdon
}

//Check Limits
$maxBiz = getPlanData($uid, 'uid', 'max_business');
$totalBiz = countRecord('business', 'uid='.$uid);

if($totalBiz >= $maxBiz){
    sendResponse(400, false, 'You have exceeded your plan limit for businesses. Please upgrade to add more'); exit();
}

$itemsArray = $ins_fields;
$ins_tbl    = $tbl;
require_once('insert_biz_record.php');

// 8. Return outputs
sendResponse(201, true, "Awesome! You are good to go. Click PROCEED to continue", $returnData);

?>