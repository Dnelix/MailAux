<?php
$jsonData = validateJsonRequest();

//1. store jsondata into local variables. Also create an array to hold all available fields
$ins_fields = array();
foreach($jsonData as $data => $value){
    $$data = $value;
    if (!empty($$data)) {$ins_fields[] = $data;}
}

//2. validate required fields
$mandatoryFields = ['contacts'];
$errorMsg = validateMandatoryFields($jsonData, $mandatoryFields, 'group');
if (!empty($errorMsg)) {
    sendResponse(400, false, $errorMsg); exit();
}
//## Extract emails from form
$email_extract = extractAndValidateEmails($contacts);
$emails = $email_extract['validEmails'];
$e_error = $email_extract['error'];

//3. check that emails does not already exist for customer
$contacts = retrieveDataFrom($c_website.'controllers/contacts.php?uid='.$uid);
$c_data = (isset($contacts->data) ? $contacts->data : []);

$existingEmails = [];
foreach ($c_data as $contact) {
    $existingEmails[] = strtolower($contact->email);
}
$existingEmails = array_flip($existingEmails); // Flip to use as a lookup set

//## Remove emails that already exist
$newEmails = [];
foreach ($emails as $email) {
    if (!isset($existingEmails[$email])) {
        $newEmails[] = $email;
    }
}

$emails = $newEmails;

//4. Check Limits
$max_contacts = getPlanData($uid, 'uid', 'max_contacts');
$totalcontacts = countRecord('contacts', 'uid='.$uid) + count($emails);
if($totalcontacts >= $max_contacts){
    sendResponse(400, false, 'Creating these contacts exceeds your plan limit. Please upgrade to add more contacts'); exit();
}

$returnData = array();
try{
    foreach($emails as $e){
        // Insert into table
        $itemsArray = ['userid','email','created'];
        $userid     = $uid;
        $email      = $e;
        $created    = date($mysql_dateformat);
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
    
}
catch (PDOException $e){
    responseServerException($e, "Failed to create this record. Check for errors");
}

// 8. Return outputs
sendResponse(201, true, "Contacts added for user. $e_error", $returnData);

?>
