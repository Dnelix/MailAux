<?php
### External variables:
# $ret_id
# $ret_username
# $ret_role

// Three db functions are involved in the rollback: beginTransaction(); commit(); rollback();
    try{
        // generate accesstoken and refreshtoken
        $tokens = generateTokens();
        $accessToken = $tokens['access_token'];
        $refreshToken = $tokens['refresh_token'];
        $accessTokenExpiry = $tokens['access_token_expiry'];
        $refreshTokenExpiry = $tokens['refresh_token_expiry'];

        $writeDB -> beginTransaction(); //rollback to this point if an error is found

        $lastlogin = date('d/m/Y H:i'); //current date&time
        $user_ip = $_SERVER['REMOTE_ADDR']; //user IP address
        $user_agent = getuserDevice($_SERVER['HTTP_USER_AGENT']); //user device

        $query = $writeDB -> prepare('UPDATE tbl_users SET loginattempts = 0, lastlogin = STR_TO_DATE(:lastlogin, '. $write_dateformat .') WHERE id = :id');
        $query -> bindParam(':id', $ret_id, PDO::PARAM_INT);
        $query -> bindParam(':lastlogin', $lastlogin, PDO::PARAM_STR);
        $query -> execute();

        //Insert login record into sessions table
        //we use the date_add() SQL functn to get the current time and add to it the number of seconds before expiry. I.e.: date_add(currentTime, INTERVAL xxx SECOND)
        $query = $writeDB -> prepare('INSERT INTO tbl_sessions (userid, login_time, accesstoken, a_tokenexpiry, refreshtoken, r_tokenexpiry, device, ip) 
            VALUES (:id, STR_TO_DATE(:logintime, '. $write_dateformat .'), :accesstoken, date_add(NOW(), INTERVAL :a_tokenexpiry SECOND), :refreshtoken, date_add(NOW(), INTERVAL :r_tokenexpiry SECOND), :device, :ip)');
        $query -> bindParam(':id', $ret_id, PDO::PARAM_INT);
        $query -> bindParam(':logintime', $lastlogin, PDO::PARAM_STR);
        $query -> bindParam(':accesstoken', $accessToken, PDO::PARAM_STR);
        $query -> bindParam(':a_tokenexpiry', $accessTokenExpiry, PDO::PARAM_INT);
        $query -> bindParam(':refreshtoken', $refreshToken, PDO::PARAM_STR);
        $query -> bindParam(':r_tokenexpiry', $refreshTokenExpiry, PDO::PARAM_INT);
        $query -> bindParam(':device', $user_agent, PDO::PARAM_STR);
        $query -> bindParam(':ip', $user_ip, PDO::PARAM_STR);
        $query -> execute();

        $lastSessionID = $writeDB -> lastInsertId();

        $writeDB -> commit(); //if everything is fine so far, commit to database.

        $rowCount = $query -> rowCount();

        if($rowCount === 0){
            sendResponse(401, false, 'Some error occurred with login');
        }

        // store data in session variables
        $_SESSION[$sitecode."loggedin"] = true;
        $_SESSION[$sitecode."id"] = intval($lastSessionID);
        $_SESSION[$sitecode."userid"] = $ret_id;
        $_SESSION[$sitecode."username"] = $ret_username;
        $_SESSION[$sitecode."token"] = $accessToken;
        $_SESSION[$sitecode."role"] = $ret_role;

        $returnData['session_id'] = intval($lastSessionID); //cast as integer
        $returnData['accesstoken'] = $accessToken;
        $returnData['access_token_expires_in'] = $accessTokenExpiry;
        $returnData['refreshtoken'] = $refreshToken;
        $returnData['refresh_token_expires_in'] = $refreshTokenExpiry;
        $returnData['user_device'] = $user_agent;
        $returnData['user_ip'] = $user_ip;

    }
    catch(PDOException $e){
        
        $writeDB -> rollBack(); // rollback to beginning and return the db to former values if any error is caught in the processing

        responseServerException($e, 'There was an issue with logging in. Please try again');
    
    }

?>