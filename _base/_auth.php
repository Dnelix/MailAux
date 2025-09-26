<?php
    //if session is not set, redirect to login
    $externalPages = array($authPage, "", "otherfrontPages");

    if(isset($_SESSION[$sitecode.'loggedin']) && $_SESSION[$sitecode.'loggedin'] === true){
        $userloggedin   = (isset($_SESSION[$sitecode."loggedin"])   ? $_SESSION[$sitecode."loggedin"]:false);
        $logsessionid   = (isset($_SESSION[$sitecode."id"])         ? $_SESSION[$sitecode."id"]:false);
        $loguserid      = (isset($_SESSION[$sitecode."userid"])     ? $_SESSION[$sitecode."userid"]:false);
        $logusername    = (isset($_SESSION[$sitecode."username"])   ? $_SESSION[$sitecode."username"]:false);
        $logtoken       = (isset($_SESSION[$sitecode."token"])      ? $_SESSION[$sitecode."token"]:false);
        $logrole        = (isset($_SESSION[$sitecode."role"])       ? $_SESSION[$sitecode."role"]:false);

        //get user data if logged in
        $user = getuserDataById($loguserid);
        $logName = (!empty($user->fullname) ? $user->fullname : $user->username);
        $userplan = getPlanData($user->planid);

        //redirect to dashboard if already logged in
        $pageurl        = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $pageurlParts   = explode('/', $pageurl);
        if(!empty($user) && end($pageurlParts) == $authPage){
            echo '<script> window.location.href = "dashboard"; </script>';
        }

        //providing variables for the js files
        echo '
            <script>
                var auth_token = ' . json_encode($logtoken) . ';
                var auth_page = ' . json_encode($authPage) . ';
            </script>
        ';

    } else {
        if (!in_array($curPage, $externalPages) ){
            echo '<script> window.location.href = "'. $authPage .'"; </script>';
            exit();
        }
        echo '<script> var auth_token = null; </script>';
        //echo '<script> window.location.href = "'. $authPage .'"; </script>';
    }

?> 