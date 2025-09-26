<?php
/*
$referee = $r_id;
$referral = $uid;
*/


if(!validateNum($referee) || !validateNum($referral)){
    sendResponse(400, false, 'Invalid referee or referral ID'); exit();
}
 
try{
    $query = $writeDB -> prepare('INSERT INTO tbl_referrals (referee, referral, commission) VALUES(:referee, :referral, :commission)');
    $query -> bindParam(':referee', $referee, PDO::PARAM_INT);
    $query -> bindParam(':referral', $referral, PDO::PARAM_INT);
    $query -> bindParam(':commission', $referralBonus, PDO::PARAM_INT); //global
    $query -> execute();

    $rowCount = $query -> rowCount();
    if($rowCount === 0) {
        sendResponse(500, false, 'Unable to register referral'); exit();
    }

    $returnData['referee']  = $referee;
    $returnData['referral'] = $referral;

    // insert commission transaction if referralBonus is set
    if (isset($referralBonus) && !empty($referralBonus) && $referralBonus !== 0){
        $itemsArray = array('userid', 'direction', 'ordertype', 'orderid', 'description', 'amt_usd', 'amt_crypto', 'coin', 'status', 'trans_balance');
        $ins_tbl    = 'tbl_transactions';
        $userid     = $referee;
        $direction  = "in";
        $ordertype  = "commission";
        $orderid    = '#COM-'.getRandomPassword(5, 'caps');
        $description= "New referral bonus";
        $amt_usd    = $referralBonus; //global
        $coin       = 'BTC';
        $amt_crypto = !empty(convertCrypto($defaultcurrency, $amt_usd, $coin)) ? (float)convertCrypto($defaultcurrency, $amt_usd, $coin) : 0.00;
        $status     = "Approved";
        $trans_balance = floatval(getuserDataById($userid, 'balance'));

        require('common/insert_record.php');

        //update user commission balance
        $user_comm  = floatval(getuserDataById($userid, 'commission'));
        $itemsArray = array('commission');
        $commission = $user_comm + $referralBonus;
        $upd_tbl    = 'tbl_users';
        $rid        = $referee;
        include_once('common/update_record.php');
    }

}
catch(PDOException $e){
    responseServerException($e, 'There was an unknown issue with this request. Please try again');
}

?>