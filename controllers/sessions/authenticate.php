<?php
if(!isset($_SERVER['HTTP_AUTHORIZATION']) || strlen($_SERVER['HTTP_AUTHORIZATION']) < 1){
    sendResponse(401, false, 'Access token is missing or empty');
}

$accesstoken = $_SERVER['HTTP_AUTHORIZATION'];

try{
    //get the user id associated with the access token (query both user and sessions tables)
    $query = $writeDB -> prepare('SELECT tbl_sessions.id AS sessionid, userid, a_tokenexpiry, refreshtoken, r_tokenexpiry, active, loginattempts FROM tbl_sessions, tbl_users WHERE tbl_sessions.userid = tbl_users.id AND accesstoken = :accesstoken');
    $query -> bindParam(':accesstoken', $accesstoken, PDO::PARAM_STR);
    $query -> execute();

    $rowCount = $query -> rowCount();
    if($rowCount === 0){
        sendResponse(401, false, 'Invalid access token provided');
    }

    $row = $query -> fetch(PDO::FETCH_ASSOC);

    $ret_sessionid = $row['sessionid'];
    $ret_userid = $row['userid'];
    $ret_a_tokenexpiry = $row['a_tokenexpiry'];
    $ret_refreshtoken = $row['refreshtoken'];
    $ret_r_tokenexpiry = $row['r_tokenexpiry'];
    $ret_active = $row['active'];
    $ret_loginattempts = $row['loginattempts'];

    if($ret_active !== 'Y'){
        sendResponse(401, false, 'User account not active');
    }
    if($ret_loginattempts >= $max_loginattempts){
        sendResponse(401, false, 'User account currently locked out');
    }
    //if the access token expiry time is less than the current time, then it has expired
    if(strtotime($ret_a_tokenexpiry) < time()){
        if(strtotime($ret_r_tokenexpiry) >= time()){ 
            // Optional. Check if refresh token is still active.
            // Redirect to update_session.php

            $returnData = array();
            $returnData['sessionID'] = $ret_sessionid;
            $returnData['refresh_token'] = $ret_refreshtoken;
            sendResponse(401, false, 'Access token expired', $returnData);
        }
        sendResponse(401, false, 'Your login have expired. Please login again');
    }

}
catch (PDOException $e){
    responseServerException($e, 'There was an issue with authentication. Please try again');
}

?>