<?php
    try{
        $query = $writeDB -> prepare('DELETE FROM tbl_sessions WHERE id = :id AND accesstoken = :accesstoken LIMIT 1');
        $query -> bindParam(':id', $sessionid, PDO::PARAM_INT);
        $query -> bindParam(':accesstoken', $accesstoken, PDO::PARAM_STR);
        $query -> execute();

        $rowCount = $query->rowCount();

        if($rowCount === 0){
            sendResponse(404, false, 'Session not found');
        }

        $returnData = array();
        $returnData['session_id'] = intval($sessionid);

        $_SESSION[$sitecode."loggedin"] = false;
        $_SESSION = array(); // unset all session variables
        session_destroy(); // destroy the session

        sendResponse(200, true, 'Successfully logged out', $returnData);

    } 
    catch(PDOException $e){
        responseServerException($e, 'Unable to logout. Please try again');
    } 
?>