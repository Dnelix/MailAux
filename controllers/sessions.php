<?php
require_once('__init__.php');

if(empty($_GET)){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        require_once('sessions/create_session.php');
    }
}
// if there's a specified ID, go ahead and check if it is a PATCH or DELETE request and perform operations accordingly
if(array_key_exists('sessionid', $_GET)){
    $sessionid = $_GET['sessionid'];
    if($sessionid === '' || !is_numeric($sessionid)){
        $message = (($sessionid === '') ? 'Session ID cannot be empty' : false);
        $message .= (!is_numeric($sessionid) ? 'Session ID must be an integer' : false);
        sendResponse(400, false, $message);
        exit(); 
    }
    
    //validate authorization
    if(!isset($_SERVER['HTTP_AUTHORIZATION']) || strlen($_SERVER['HTTP_AUTHORIZATION']) < 1){
        $message = 'Access token is not provided';
        sendResponse(400, false, $message);
        exit(); 
    }
    $accesstoken = $_SERVER['HTTP_AUTHORIZATION'];

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        // get details of a particular session (if necessary)
    }
    
    // if delete    
    if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
        require_once('sessions/delete_session.php');
    }

    // if update
    else if($_SERVER['REQUEST_METHOD'] === 'PATCH'){
        require_once('sessions/update_session.php');
    }

    //else invalid
    else{
        sendResponse(405, false, 'Invalid session request');
    }
}
else if(array_key_exists('userid', $_GET)){
    $userid = $_GET['userid'];
    if($userid === '' || !is_numeric($userid)){
        $message = (($userid === '') ? 'User ID cannot be empty' : false);
        $message .= (!is_numeric($userid) ? 'User ID must be an integer' : false);
        sendResponse(400, false, $message);
        exit(); 
    }

    require_once('sessions/list_user_sessions.php');
}
else if(array_key_exists('switchrole', $_GET)){
    require_once('sessions/switchrole.php');
}

//else invalid request
else{
    sendResponse(405, false, 'Invalid request method');
}