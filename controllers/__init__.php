<?php
require_once('../_base/_constants.php');
require_once('../_base/_functions.php');
require_once('../_base/DBconnect.php');
require_once('../models/Response.php');

// CORS: Allow from specific origin
// $allowedOrigins = ['https://'.$c_shortsite, $c_website];
// $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

// if (in_array($origin, $allowedOrigins)) {
//     header("Access-Control-Allow-Origin: $origin");
//     header("Access-Control-Allow-Credentials: true");
// }

// CORS: Allow standard methods and headers
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Cache-Control');
    header('Access-Control-Max-Age: 86400'); // cache the preflight response for 1 day
    exit;
}

//connect to DB
require_once('../_base/db/connect_write_read_db.php'); // access both $readDB and $writeDB