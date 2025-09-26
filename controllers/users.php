<?php
require_once('__init__.php');

$tbl            = 'tbl_users';
$all_fields     = 'username,password,email,phone,fullname,active,kyc,balance,lastlogin,loginattempts,role,planid,createdon';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('users/create_user.php');
}

if(array_key_exists('reset', $_GET)){
    require_once('users/reset.php');
}

//check auth status here (user will not be logged in before self registration)

if(array_key_exists('userid', $_GET)){
    if(!$uid = validateNum($_GET['userid'])) {sendResponse(400, false, 'Invalid ID!'); exit();}

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        require_once('users/get_user_record.php'); //Get a user detail given id
    }
    if($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        //if request is DELETE: delete a user given id
    }
    if($_SERVER['REQUEST_METHOD'] === 'PATCH') {
        $jsonData = validateJsonRequest();
        if(array_key_exists('password', $_GET)){
            require_once('users/update_password.php');
        }
        if(array_key_exists('accounts', $_GET)){
            require_once('users/update_balances.php');
        } 
        else {
            require_once('users/update_userdata.php');
        }
    }
    else{
        sendResponse(401, false, 'Your request cannot be understood');
    }
}

//else get all users
else if (array_key_exists('aid', $_GET)){ 
    if(!$aid = authenticateAdmin($_GET['aid'])) {sendResponse(400, false, 'Authentication failed!'); exit();}

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        require_once("users/list_users.php");
    }
}

else {
    sendResponse(405, false, 'Invalid Request Method!');
}

?>