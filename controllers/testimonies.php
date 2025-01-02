<?php
require_once('__init__.php');

$tbl            = 'tbl_testimonies';
$all_fields     = 'id, cid, status, content, postedby, date';


if(array_key_exists('uid', $_GET)){
    if(!$uid = validateNum($_GET['uid'])) {sendResponse(400, false, 'Invalid ID!'); exit();}

    if($_SERVER['REQUEST_METHOD'] === 'GET') { //get all for the user's latest church
        $churchList = retrieveDataFrom($appURL.'controllers/church.php?latest&uid='.$uid, false, true);
        $latest = !empty($churchList) ? $churchList->data : null;

        if(!$cid = validateNum($latest->id)) {sendResponse(400, false, 'Invalid Church ID!'); exit();}
        require_once('testimonies/list_all.php');
    }

    else{
        sendResponse(401, false, 'Invalid request for user');
    }
}

if(array_key_exists('cid', $_GET)){
    if(!$cid = validateNum($_GET['cid'])) {sendResponse(400, false, 'Invalid ID!'); exit();}

    if(array_key_exists('tid', $_GET)){
        if(!$tid = validateNum($_GET['tid'])) {sendResponse(400, false, 'Invalid announce ID!'); exit();}

        if(array_key_exists('approve', $_GET)){
            $itemsArray = ['status'];
            $status = 1;
            $upd_tbl = $tbl;
            $rid = $anid;
            include_once('common/update_record.php');
            sendResponse(201, true, "Testimony approved for display!", $returnData); exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once('testimonies/get_details.php');
        }
        if($_SERVER['REQUEST_METHOD'] === 'PATCH') {
            require_once('testimonies/update.php');
        }
        if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $d_id = $tid;
            $del_tbl = $tbl;
            $add_condition = "AND cid = $cid";
            require_once('common/delete_record.php');
            sendResponse(201, true, "Successfully deleted!", $returnData); exit;
        }
        else{
            sendResponse(401, false, 'Invalid request for member');
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(array_key_exists('type', $_GET)){
            $type = ucwords($_GET['type']);
            $limit = isset( $_GET['limit'] ) ? 'LIMIT '.intval( $_GET['limit'] ) : '';
            require_once('testimonies/list_conditional.php');
        }
        else require_once('testimonies/list_all.php');
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('testimonies/add_new.php');
    }

    if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        require_once('testimonies/delete_all.php'); 
    }
    
    else{
        sendResponse(401, false, 'Your request cannot be understood');
    }
}

//else get all
else if (array_key_exists('aid', $_GET)){ 
    if(!$aid = authenticateAdmin($_GET['aid'])) {sendResponse(400, false, 'Authentication failed!'); exit();}

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        require_once("church/list_all_testimonies.php");
    }

    else{
        sendResponse(401, false, 'Invalid request for admin');
    }
}

else {
    sendResponse(405, false, 'Invalid Request Method!');
}

?>