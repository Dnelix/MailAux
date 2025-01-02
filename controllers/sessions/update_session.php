<?php
// this script is typically used together with a cron job that runs regularly to delete sessions for users whose refresh token have expired

if(isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] !== 'application/json'){
    sendResponse(400, false, "Content type header is not set to JSON");
}

$rawPatchData = file_get_contents('php://input');

if(!$jsonData = json_decode($rawPatchData)){
    sendResponse(400, false, "Invalid JSON data in request body");
}

if(!isset($jsonData -> refreshtoken) || strlen($jsonData -> refreshtoken) < 1){
    sendResponse(400, false, "No refresh token provided or invalid refresh token");
}

//query db
try{
    $refreshtoken = $jsonData -> refreshtoken;

    // we query both the users table and the sessions table in one statement as below
    $query = $writeDB -> prepare('SELECT tbl_sessions.id AS sessionid, tbl_sessions.userid AS userid, accesstoken, refreshtoken, active, loginattempts, a_tokenexpiry, r_tokenexpiry FROM tbl_sessions, tbl_users WHERE tbl_users.id = tbl_sessions.userid AND tbl_sessions.id = :sessionid AND tbl_sessions.accesstoken = :accesstoken AND tbl_sessions.refreshtoken = :refreshtoken');
    $query -> bindParam(':sessionid', $sessionid, PDO::PARAM_INT);
    $query -> bindParam(':accesstoken', $accesstoken, PDO::PARAM_STR);
    $query -> bindParam(':refreshtoken', $refreshtoken, PDO::PARAM_STR);
    $query -> execute();

    $rowCount = $query -> rowCount();

    if ($rowCount === 0){
        sendResponse(401, false, "Access token or Refresh token is incorrect for the session ID");
    }

    $row = $query -> fetch(PDO::FETCH_ASSOC);

    $ret_sessionid = $row['sessionid'];
    $ret_userid = $row['userid'];
    $ret_accesstoken = $row['accesstoken'];
    $ret_refreshtoken = $row['refreshtoken'];
    $ret_active = $row['active'];
    $ret_loginattempts = $row['loginattempts'];
    $ret_a_tokenexpiry = $row['a_tokenexpiry'];
    $ret_r_tokenexpiry = $row['r_tokenexpiry'];

    if($ret_active !== 'Y'){
        sendResponse(401, false, "User not active");
    }
    if($ret_loginattempts >= $max_loginattempts){
        sendResponse(401, false, "User account locked out");
    }

    //if time in db is less than current time, that means it has expired
    if(strtotime($ret_r_tokenexpiry) < time()){
        sendResponse(401, false, "Refresh token has expired. Please login again");
    }

    // else generate a new access token
    $tokens = generateTokens();
    $accessToken = $tokens['access_token'];
    $refreshToken = $tokens['refresh_token'];
    $accessTokenExpiry = $tokens['access_token_expiry'];
    $refreshTokenExpiry = $tokens['refresh_token_expiry'];

    $query = $writeDB -> prepare('UPDATE tbl_sessions SET accesstoken = :accesstoken, a_tokenexpiry = date_add(NOW(), INTERVAL :a_tokenexpiry SECOND), refreshtoken = :refreshtoken, r_tokenexpiry = date_add(NOW(), INTERVAL :r_tokenexpiry SECOND) WHERE id = :sessionid AND userid = :userid AND accesstoken = :ret_accesstoken AND refreshtoken = :ret_refreshtoken');
    $query -> bindParam(':sessionid', $ret_sessionid, PDO::PARAM_INT);
    $query -> bindParam(':userid', $ret_userid, PDO::PARAM_INT);
    $query -> bindParam(':accesstoken', $accesstoken, PDO::PARAM_STR);
    $query -> bindParam(':a_tokenexpiry', $accesstoken_expiry, PDO::PARAM_INT);
    $query -> bindParam(':refreshtoken', $refreshtoken, PDO::PARAM_STR);
    $query -> bindParam(':r_tokenexpiry', $refreshtoken_expiry, PDO::PARAM_INT);
    $query -> bindParam(':ret_accesstoken', $ret_accesstoken, PDO::PARAM_STR);
    $query -> bindParam(':ret_refreshtoken', $ret_refreshtoken, PDO::PARAM_STR);
    $query -> execute();

    $rowCount = $query -> rowCount();

    if($rowCount === 0){
        sendResponse(401, false, "Access token could not be refreshed. Please log in again");
    }

    $returnData = array();
    $returnData['session_id'] = intval($ret_sessionid); //cast as integer
    $returnData['accesstoken'] = $accesstoken;
    $returnData['access_token_expires_in'] = $accesstoken_expiry;
    $returnData['refreshtoken'] = $refreshtoken;
    $returnData['refreshtoken_expires_in'] = $refreshtoken_expiry;

    sendResponse(201, true, 'Access token successfully refreshed', $returnData);

}
catch(PDOException $e){
    responseServerException($e, 'Problem with refreshing access token. Please login again');
}

?>