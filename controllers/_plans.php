<?php
require_once('__init__.php');

$tbl            = 'tbl_plans';
$all_fields     = 'id, plan, max_business, max_contacts, max_groups, max_campaigns, max_templates';


if(array_key_exists('uid', $_GET)){
    if(!$uid = validateNum($_GET['uid'])) {sendResponse(400, false, 'Invalid ID!'); exit();}

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        $pid = getuserDataById($uid, 'planid');
        require_once('_plans/plan_data.php');
    }
    else{
        sendResponse(401, false, 'Invalid request for user');
    }
}

if(array_key_exists('pid', $_GET)){
    if(!$pid = validateNum($_GET['pid'])) {sendResponse(400, false, 'Invalid ID!'); exit();}

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        require_once('_plans/plan_data.php');
    }
    
    else{
        sendResponse(401, false, 'Your request cannot be understood');
    }
}

//else get all
else if (array_key_exists('aid', $_GET)){ 
    if(!$aid = authenticateAdmin($_GET['aid'])) {sendResponse(400, false, 'Authentication failed!'); exit();}

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        require_once("_plans/all_plans.php");
    }
    else{
        sendResponse(401, false, 'Invalid request for admin');
    }
}

else {
    sendResponse(405, false, 'Invalid Request Method!');
}

?>