<?php
require_once('__init__.php');

$tbl            = 'tbl_campaigns';
$all_fields     = 'id, userid, title, from_name, from_email, send_to, group_id, contacts, num_recipients, template_id, content, status, updated';


if(array_key_exists('uid', $_GET)){
    if(!$uid = validateNum($_GET['uid'])) {sendResponse(400, false, 'Invalid ID!'); exit();}

    if(array_key_exists('cmid', $_GET)){
        if(!$cmid = validateNum($_GET['cmid'])) {sendResponse(400, false, 'Invalid campaign ID!'); exit();}

        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            if(array_key_exists('logs', $_GET)){
                require_once('campaigns/get_campaign_logs.php');
            }
            require_once('campaigns/get_campaign_data.php');
        }
        if($_SERVER['REQUEST_METHOD'] === 'PATCH' || $_SERVER['REQUEST_METHOD'] === 'POST') {
            if(array_key_exists('send', $_GET)){
                require_once('campaigns/send_mails.php');
            }
            require_once('campaigns/update_campaign_data.php'); //equally update via POST
        }
        if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $d_id = $cmid;
            $del_tbl = $tbl;
            $add_condition = "AND userid = $uid";
            require_once('common/delete_record.php');
            sendResponse(201, true, "Successfully deleted!", $returnData); exit;
        }
        else{
            sendResponse(401, false, 'Invalid request for campaign');
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('campaigns/create_campaign.php');
    }

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        require_once('campaigns/list_user_campaigns.php');
    }

    if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        require_once('campaigns/delete_user_campaigns.php'); 
    }

    else{
        sendResponse(401, false, 'Invalid request for user');
    }
}


//else get all campaigns
else if (array_key_exists('aid', $_GET)){ 
    if(!$aid = authenticateAdmin($_GET['aid'])) {sendResponse(400, false, 'Authentication failed!'); exit();}

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        require_once("campaigns/list_all_campaigns.php");
    }

    else{
        sendResponse(401, false, 'Invalid request for admin');
    }
}

else {
    sendResponse(405, false, 'Invalid Request Method!');
}

?>