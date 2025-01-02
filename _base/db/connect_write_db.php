<?php

try {
    $writeDB = DBconnect::connectWriteDB($db_host, $db_name, $db_user, $db_pass);
} 
catch (PDOException $e) {
    responseServerException($e, 'Database connection error');
    exit(); //don't continue the script if there is an error with connection
}

?>