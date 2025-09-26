<?php
require_once('__init__.php');

// $tbl = 'tbl_referrals';
// $fields_array = array('referee', 'referral', 'commission');


if(array_key_exists('uid', $_GET)){
    if(!$uid = validateNum($_GET['uid'])) {sendResponse(400, false, 'Invalid ID!'); exit();}

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        require_once('referrals/list_referrals.php');
    }

}
else {
    sendResponse(400, false, 'Unspecified key parameter'); exit();
}

?>