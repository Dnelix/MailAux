<?php
require_once('../_base/_constants.php');
require_once('../_base/_functions.php');
require_once('../_base/DBconnect.php');
require_once('../models/Response.php');

// Handle CORS request methods
if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS'); //options is always allowed. Include other request mthds that apply
    header('Access-Control-Allow-Headers: Content-Type');
    header('Access-Control-Max-Age: 86400'); // cache for 24 hours

    sendResponse(200, true, '');
}

//connect to DB
require_once('../_base/db/connect_write_read_db.php'); // access both $readDB and $writeDB