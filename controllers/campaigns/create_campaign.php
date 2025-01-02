<?php
$jsonData = validateJsonRequest();

//1. store jsondata into local variables. Also create an array to hold all available fields
$ins_fields = array();
foreach($jsonData as $data => $value){
    $$data = $value;
    if (!empty($$data)) {$ins_fields[] = $data;}
}
//2. validate required fields
$mandatoryFields = ['title', 'send_to'];
$errorMsg = validateMandatoryFields($jsonData, $mandatoryFields, 'group');
if (!empty($errorMsg)) {
    sendResponse(400, false, $errorMsg); exit();
}

//3. Check Limits
$max_campaigns = getPlanData($uid, 'uid', 'max_campaigns');
$totalcampaigns = countRecord('campaigns', 'uid='.$uid);
if($totalcampaigns >= $max_campaigns){
    sendResponse(400, false, 'You have exceeded your plan limit for campaigns. Please upgrade to add more campaigns'); exit();
}

// $from_name;
// $from_email;
// -template_id
// -content
$group_id = !empty($group_id) ? $group_id : 0;
$contacts_array = [];

//4. determine actions
if($send_to == 'group'){
    include_once('create/getgroupcontacts.php');
} else if ($send_to == 'contacts'){
    $contacts_array = $jsonData->contacts; //contact array from JS
} else if ($send_to == 'manual'){
    sendResponse(401, false, 'Contact', $jsonData->contacts); exit();
} else {
    sendResponse(401, false, 'Invalid category. Unable to proceed'); exit();
}

$returnData = array();
try{
    // Insert into table
    $itemsArray = ['userid','title','send_to','group_id','contacts','num_recipients','status','updated'];
    $userid = $uid;  // title, send_to already set from form. group_id, contacts, set in code
    $num_recipients = count($contacts_array);
    $contacts = implode(',', $contacts_array);
    $status = 'draft';
    $updated = date($mysql_dateformat);
   
    $ins_tbl = $tbl;
    require('common/insert_record.php');
    
}
catch (PDOException $e){
    responseServerException($e, "Failed to create this record. Check for errors");
}

// 8. Return outputs
sendResponse(201, true, "Campaign created! Click proceed to continue.", $returnData);

?>
