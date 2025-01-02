<?php
$jsonData = validateJsonRequest();

//1. store jsondata into local variables. Also create an array to hold all available fields
$ins_fields = array();
foreach($jsonData as $data => $value){
    $$data = $value;
    if (!empty($$data)) {$ins_fields[] = $data;}
}
//2. validate required fields
$mandatoryFields = ['email'];
$errorMsg = validateMandatoryFields($jsonData, $mandatoryFields, 'group');
if (!empty($errorMsg)) {
    sendResponse(400, false, $errorMsg); exit();
}

//3. check that email does not already exist for customer
$contacts = retrieveDataFrom($c_website.'controllers/contacts.php?uid='.$uid);
$c_data = (isset($contacts->data) ? $contacts->data : []);
foreach($c_data as $contact){
    $e = $contact->email;
    if(strtolower($email) == $e){
        sendResponse(400, false, 'Contact already exists for user!'); exit();
    }
}

//Check Limits
$max_contacts = getPlanData($uid, 'uid', 'max_contacts');
$totalcontacts = countRecord('contacts', 'uid='.$uid);
if($totalcontacts >= $max_contacts){
    sendResponse(400, false, 'You have exceeded your plan limit for contacts. Please upgrade to add more contacts'); exit();
}

$returnData = array();
try{
    //clean up array
    if(!in_array('userid', $ins_fields)){
        array_push($ins_fields, 'userid');     //add uid if missing
        $userid = $uid;
    }
    if(in_array('group', $ins_fields)){ //remove group from ins_fields array
        $ins_fields = array_diff($ins_fields, ['group']);
        $ins_fields = array_values($ins_fields);
    }
    
    // Insert into table
    $itemsArray = $ins_fields;              // other inputs already set from form
    $ins_tbl    = $tbl;
    require('common/insert_record.php');

    
    // Handle contact grouping
    if(isset($group) && !empty($group)){ //from jsonData
        $itemsArray = ['contact_id', 'group_id'];
        $contact_id = $returnData['lastInsertID'];
        $group_id = $group;
        $ins_tbl = 'tbl_contact_group';
        require('common/insert_record.php');
    }
    
}
catch (PDOException $e){
    responseServerException($e, "Failed to create this record. Check for errors");
}

// 8. Return outputs
sendResponse(201, true, "Contact added for user", $returnData);

?>
