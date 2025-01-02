<?php
    include_once('sections/editprofile.php');
    include_once('sections/signinmethod.php');
    
    if($user->active == "1"){
        include_once('sections/deactivate.php');
    } else {
        include_once('sections/activate.php');
    }
?>