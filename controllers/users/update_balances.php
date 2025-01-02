<?php
//set defaults
try{
    $deposit    = !empty($jsonData->deposit) ? $jsonData->deposit : 0; 
    $profit     = !empty($jsonData->profit) ? $jsonData->profit : 0;
    $commission = !empty($jsonData->commission) ? $jsonData->commission : 0;
    $dailybonus = !empty($jsonData->dailybonus) ? $jsonData->dailybonus : 0;
    $d_sign     = !empty($jsonData->d_sign) ? $jsonData->d_sign : "+";
    $p_sign     = !empty($jsonData->p_sign) ? $jsonData->p_sign : "+";
    $c_sign     = !empty($jsonData->c_sign) ? $jsonData->c_sign : "+";
    
    //get exisitng user balances
    $usrBals = getUserBalances($readDB, $uid);
    $depBal = $usrBals['balance'];
    $proBal = $usrBals['profit'];
    $comBal = $usrBals['commission'];
    
    //calculate new balances
    $newDep = calcNewBal($depBal, $d_sign, $deposit);
    $newPro = calcNewBal($proBal, $p_sign, $profit);
    $newCom = calcNewBal($comBal, $c_sign, $commission);

    //check negative balances
    if($newDep < 0 || $newPro < 0 || $newCom < 0){
        $errorMsg = ($newDep < 0) ? ' The user will have a negative Deposit balance! ':'';
        $errorMsg .= ($newPro < 0) ? ' The user will have a negative Profit balance! ':'';
        $errorMsg .= ($newCom < 0) ? ' The user will have a negative Commissions balance! ':'';
        sendResponse(400, false, 'ERROR: '.$errorMsg); exit();
    }
    
    //prepare returndata
    $returnData = array();

    //insert transactions records
    $itemsArray = array('userid', 'direction', 'ordertype', 'orderid', 'description', 'amt_usd', 'amt_crypto', 'coin', 'status', 'trans_balance');
    $userid     = $uid;
    $orderid    = '#SYS-'.getRandomPassword(5, 'caps');
    $description = "System Transaction";
    $coin       = 'BTC';
    $status     = "Completed";
    $trans_balance = $newDep; //only deposit balances are reflected in transactions table
    $ins_tbl    = 'tbl_transactions';

    if(!empty($deposit)){
        $direction  = ($d_sign == 'add' || $d_sign == '+') ? "in" : "out";
        $ordertype  = "deposit";
        $amt_usd    = $deposit;
        $amt_crypto = (float)convertCrypto($defaultcurrency, $amt_usd, strtoupper($coin));
        include('common/insert_record.php');
    }
    if(!empty($profit)){
        $direction  = ($p_sign == 'add' || $p_sign == '+') ? "in" : "out";
        $ordertype  = "profit";
        $amt_usd    = $profit;
        $amt_crypto = (float)convertCrypto($defaultcurrency, $amt_usd, strtoupper($coin));
        include('common/insert_record.php');
    }
    if(!empty($commission)){
        $direction  = ($c_sign == 'add' || $c_sign == '+') ? "in" : "out";
        $ordertype  = "commission";
        $amt_usd    = $commission;
        $amt_crypto = (float)convertCrypto($defaultcurrency, $amt_usd, strtoupper($coin));
        include('common/insert_record.php');
    }
    

    //update user record
    $itemsArray = array('balance', 'dailybonus', 'profit', 'commission');
    $balance   = $newDep;
    $dailybonus = $dailybonus;
    $profit      = $newPro;
    $commission   = $newCom;

    $upd_tbl = 'tbl_users';
    $rid = $uid;
    include_once('common/update_record.php');

    //Return response
    sendResponse(201, true, 'User balances updated! Please wait as changes may take some time to fully reflect.', $returnData);
}
catch(Exception $e){
    responseServerException($e, 'Failed to update balances. Check for errors');
}
?>