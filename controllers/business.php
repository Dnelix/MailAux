<?php
require_once('__init__.php');

$tbl            = 'tbl_business';
$all_fields     = 'id, userid, name, description, logo, phone, email, website, country, state, city, address, facebook, twitter, youtube, instagram, createdon';


if(array_key_exists('uid', $_GET)){
    if(!$uid = validateNum($_GET['uid'])) {sendResponse(400, false, 'Invalid ID!'); exit();}

    if(array_key_exists('bid', $_GET)){
        if(!$bid = validateNum($_GET['bid'])) {sendResponse(400, false, 'Invalid business ID!'); exit();}
    
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once('business/details.php');
        }

        if($_SERVER['REQUEST_METHOD'] === 'PATCH' || $_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once('business/update.php'); //update via POST request
        }
    
        if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            //remove upload folder for business
            //delete any emails campaigns, etc for business
        }
        
        else{
            sendResponse(401, false, 'Your request cannot be understood');
        }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('business/create_business.php');
    }

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        require_once('business/user_business_list.php');
    }

    else{
        sendResponse(401, false, 'Invalid request for user');
    }
}

//else get all business
else if (array_key_exists('aid', $_GET)){ 
    if(!$aid = authenticateAdmin($_GET['aid'])) {sendResponse(400, false, 'Authentication failed!'); exit();}

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        require_once("business/list_businesses.php");
    }
}

else {
    sendResponse(405, false, 'Invalid Request Method!');
}

?>