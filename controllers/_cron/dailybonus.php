<?php
## /usr/local/bin/php /home/emiryesq/irevenue.co/app/controllers/

// Change to the directory of the script
chdir(__DIR__);
$rootfolder = "../../../base/"; //controllers folder

require_once($rootfolder.'_constants.php');
require_once($rootfolder.'_functions.php');
require_once($rootfolder.'DBconnect.php');
try { $writeDB = DBconnect::connectWriteDB($db_host, $db_name, $db_user, $db_pass); } 
catch (PDOException $e) {
    $errorMsg = 'Database connection error '.$e;
} 

$errorMsg = false;

//identify users to be credited
$query = $writeDB -> prepare('SELECT id, dailybonus, profit FROM tbl_users WHERE dailybonus > 0');
$query -> execute();
$usrCount = $query -> rowCount();
if($usrCount === 0){
    $errorMsg = 'No user eligible for crediting';
} 

else {
    $eligibleUsers = array();
    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        $eligibleUsers[] = $row;
    }

    //set transaction variables
    $ins_tbl    = 'tbl_transactions';
    $direction  = "in";
    $ordertype  = "profit";
    $orderid    = '#PRO-'.getRandomPassword(5, 'caps');
    $description= "Automated daily profits";

    foreach($eligibleUsers as $usr){
        $userid = intval($usr['id']);
        $newProfit = floatval($usr['profit']) + floatval($usr['dailybonus']);

        //pass transaction entries
        $itemsArray = array('userid', 'direction', 'ordertype', 'orderid', 'description', 'amt_usd', 'status');
        $userid     = $userid;
        $amt_usd    = $newProfit;
        $status     = "Completed";
        
        require($rootfolder.'_cron/inc/insert_record.php');

        //update balance
        $itemsArray = array('profit');
        $profit = $newProfit;
        $upd_tbl = 'tbl_users';
        $rid = $userid;
        require($rootfolder.'_cron/inc/update_record.php');
    }

}

if($errorMsg){
    echo $errorMsg;

    $subject = "Error: Automated daily profits";
    $message = "Hi Admin, one or more users may not have been credited today due to the following error: <br> <b>$errorMsg</b> <br>. Thanks for using this platform.";
} else {
    echo "Successfully credited $usrCount users!";

    $subject = "Success: Automated daily profits";
    $message = "Hi Admin, this is a system generated report to notify you that $usrCount eligible users have been credited with profits today. Thanks for using this platform.";
}

//send mails
$sendMail = sendEmail('general', $subject, $p_email, 'Admin', $message, 'Autobot');

?>