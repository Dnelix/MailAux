<?php

$jsonData = validateJsonRequest();

if(isset($jsonData->who)){
    $who = $jsonData->who;
    $_SESSION[$sitecode.'role'] = $who;
} else {
    sendResponse(400, false, 'not set');
}
sendResponse(200, true, $who);

?>