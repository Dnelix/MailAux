<?php
require_once('__init__.php');

$tbl            = 'tbl_contacts';
$all_fields     = 'id, userid, email, first_name, last_name, created';


if(array_key_exists('uid', $_GET)){
    if(!$uid = validateNum($_GET['uid'])) {sendResponse(400, false, 'Invalid ID!'); exit();}

    if(array_key_exists('cid', $_GET)){
        if(!$cid = validateNum($_GET['cid'])) {sendResponse(400, false, 'Invalid contact ID!'); exit();}

        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once('contacts/get_contact_data.php');
        }
        if($_SERVER['REQUEST_METHOD'] === 'PATCH' || $_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once('contacts/update_contact_data.php'); //equally update via POST
        }
        if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $d_id = $cid;
            $del_tbl = $tbl;
            $add_condition = "AND userid = $uid";
            require_once('common/delete_record.php');
            sendResponse(201, true, "Successfully deleted!", $returnData); exit;
        }
        else{
            sendResponse(401, false, 'Invalid request for contact');
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_GET['paste'])){
            require_once('contacts/add_paste_contacts.php');
        }
        require_once('contacts/add_contact.php');
    }

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(array_key_exists('contactgroups', $_GET)){
            require_once('contacts/list_contacts_with_groups.php');
        }
        require_once('contacts/list_user_contacts.php');
    }

    if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        require_once('contacts/delete_user_contacts.php'); 
    }

    else{
        sendResponse(401, false, 'Invalid request for user');
    }
}


//else get all contacts
else if (array_key_exists('aid', $_GET)){ 
    if(!$aid = authenticateAdmin($_GET['aid'])) {sendResponse(400, false, 'Authentication failed!'); exit();}

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        require_once("contacts/list_all_contacts.php");
    }

    else{
        sendResponse(401, false, 'Invalid request for admin');
    }
}

else {
    sendResponse(405, false, 'Invalid Request Method!');
}

?>