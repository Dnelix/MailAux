<?php
require_once('__init__.php');

$tbl            = 'tbl_templates';
$all_fields     = 'id, level, name, description, image, content, status';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('templates/create_template.php');
}

if(array_key_exists('uid', $_GET)){
    if(!$uid = validateNum($_GET['uid'])) {sendResponse(400, false, 'Invalid ID!'); exit();}
    
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        require_once('templates/user_templates.php');
    }
    else{
        sendResponse(401, false, 'Invalid request for user');
    }
}

if(array_key_exists('tid', $_GET)){
    if(!$tid = validateNum($_GET['tid'])) {sendResponse(400, false, 'Invalid template ID!'); exit();}

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        require_once('templates/get_template_data.php');
    }
    if($_SERVER['REQUEST_METHOD'] === 'PATCH' || $_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('templates/update_template_data.php');
    }
    if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $d_id = $tid;
        $del_tbl = $tbl;
        require_once('common/delete_record.php');
        sendResponse(201, true, "Successfully deleted!", $returnData); exit;
    }
    else{
        sendResponse(401, false, 'Invalid request for template');
    }
}

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once('templates/list_templates.php');
}

else {
    sendResponse(405, false, 'Invalid Request Method!');
}

?>