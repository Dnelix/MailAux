<?php
    // a safe action is to delay a session request by 1 sec to slow down hacking attempts
    sleep(1); //delay by 1 sec

    //check if the content is JSON and retrieve
    $jsonData = validateJsonRequest();

    //data validation checks. We are only sending username and password to create a session
    if(empty($jsonData->username) || empty($jsonData->password)){
        $message = (!empty($jsonData->username) ? 'Email/Username not set ' : false);
        $message .= (!empty($jsonData->password) ? 'Password not set ' : false);
        sendResponse(400, false, $message);
        exit(); 
    }

    //2. check if the strings are empty or have values above the DB limits
    $fieldLengthMsg = validateFieldLength($jsonData->username, 2, 50, 'Email/Username');
    $fieldLengthMsg .= validateFieldLength($jsonData->password, 2, 255, 'Password');
    if (!empty($fieldLengthMsg)) { 
        sendResponse(400, false, $fieldLengthMsg); exit(); 
    }

    //3. Check if user exists
    try{

        $username = $jsonData->username;
        $password = $jsonData->password;
        $all = 'id,username,password,email,active,lastlogin,loginattempts,role';

        $query = $writeDB -> prepare('SELECT '. $all .' FROM tbl_users WHERE username = :username OR email = :email');
        $query -> bindParam(':username', $username, PDO::PARAM_STR);
        $query -> bindParam(':email', $username, PDO::PARAM_STR);
        $query -> execute();

        $rowCount = $query -> rowCount();

        if($rowCount === 0 || $rowCount > 1){
            sendResponse(401, false, 'Invalid login credentials! Select SIGNUP to create an account or use the FORGOT PASSWORD option if you already have an account');
        }
        
        //no need for while statement since it's only going to be a single record
        $row = $query -> fetch(PDO::FETCH_ASSOC);

        $ret_id = $row['id'];
        $ret_username = $row['username'];
        $ret_password = $row['password'];
        $ret_email = $row['email'];
        $ret_active = $row['active'];
        $ret_loginattempts = $row['loginattempts'];
        $ret_lastlogin = $row['lastlogin'];
        $ret_role = $row['role'];

        // Hash Password
        $hash_pass = password_hash($password, PASSWORD_DEFAULT); //hash using the standard PHP hashing

        if($ret_active !== "1"){    
            sendResponse(401, false, 'User account is not active!');
        }

        if($ret_loginattempts >= $max_loginattempts){
            sendResponse(401, false, 'Number of attempts exceeded! User account have been locked out.');
        }

        if(!password_verify($password, $ret_password)) { 
            // increment login attempts
            $query = $writeDB->prepare('UPDATE tbl_users set loginattempts = loginattempts+1 WHERE id = :id');
            $query -> bindParam(':id', $ret_id, PDO::PARAM_INT);
            $query -> execute();

            sendResponse(401, false, 'Password is incorrect! Your account will be locked if you enter an incorrect password '. $max_loginattempts .' times');
        }

        //else login is successful
    }
    catch (PDOException $e){
        responseServerException($e, 'Problem with logging in. Please try again');
    }


    //use a separate try and catch for the login updates so that we can perform a rollback in case of failure.
    $returnData = array();
    require_once('login.php');

    sendResponse(201, true, 'User successfully logged in', $returnData);

?>