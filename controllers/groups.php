<?php
require_once('__init__.php');

$tbl            = 'tbl_groups';
$all_fields     = 'id, userid, group_name, description, created';


if(array_key_exists('uid', $_GET)){
    if(!$uid = validateNum($_GET['uid'])) {sendResponse(400, false, 'Invalid ID!'); exit();}

    if(array_key_exists('gid', $_GET)){
        if(!$gid = validateNum($_GET['gid'])) {sendResponse(400, false, 'Invalid group ID!'); exit();}

        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once('groups/get_group_data.php');
        }
        if($_SERVER['REQUEST_METHOD'] === 'PATCH' || $_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once('groups/update_group_data.php');
        }
        if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $d_id = $gid;
            $del_tbl = $tbl;
            $add_condition = "AND userid = $uid";
            require_once('common/delete_record.php');
            sendResponse(201, true, "Successfully deleted!", $returnData); exit;
        }
        else{
            sendResponse(401, false, 'Invalid request for group');
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('groups/add_group.php');
    }

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(array_key_exists('members', $_GET)){
            require_once('groups/list_group_members.php');
        }
        if(array_key_exists('countmembers', $_GET)){
            require_once('groups/list_groups_count_members.php');
        }
        require_once('groups/list_user_groups.php');
    }

    if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        require_once('groups/delete_user_groups.php'); 
    }

    else{
        sendResponse(401, false, 'Invalid request for user');
    }
}


//else get all groups
else if (array_key_exists('aid', $_GET)){ 
    if(!$aid = authenticateAdmin($_GET['aid'])) {sendResponse(400, false, 'Authentication failed!'); exit();}

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        require_once("groups/list_all_groups.php");
    }

    else{
        sendResponse(401, false, 'Invalid request for admin');
    }
}

else {
    sendResponse(405, false, 'Invalid Request Method!');
}

?>