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
    //sendResponse(400, false, 'You have exceeded your plan limit for campaigns. Please upgrade to add more campaigns'); exit();
}

//4. determine method for contacts retrieval
$group_id = !empty($group_id) ? $group_id : 0;
$contacts_array = [];

if($send_to == 'group'){
    include_once('create/getgroupcontacts.php');
} else if ($send_to == 'contacts'){
    $contacts_array = $jsonData->contacts; //contact array from JS
} else if ($send_to == 'manual'){
    sendResponse(401, false, 'Contacts', $jsonData->contacts); exit(); //to be updated
} else {
    sendResponse(401, false, 'Invalid category. Unable to proceed'); exit();
}

$num_recipients = count($contacts_array);
if($num_recipients < 1) {
    sendResponse(401, false, 'You must create at least one contact to set up a campaign'); exit();
}

//5. Get FROM data ($from_name; $from_email;)
$biz = retrieveDataFrom($c_website.'controllers/business.php?data&uid='.$uid);
$biz_data = (isset($biz->data) ? $biz->data : []);
$from_name = $biz_data->name;
$from_email = $biz_data->email;

$returnData = array();
try{
    // Insert into table
    $itemsArray = ['userid','title','from_name','from_email','send_to','group_id','contacts','num_recipients','status','updated'];
    $userid = $uid;  // title, send_to already set from form. from_name, from_email, group_id, contacts, set in code
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
