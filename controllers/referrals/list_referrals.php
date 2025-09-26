<?php
$tbl_ref = 'tbl_referrals';
$fields_array = array('referee', 'referral', 'commission');
$all_fields = implode(",", $fields_array);

try{
    $query = $readDB -> prepare ('SELECT '.$all_fields.' FROM '. $tbl_ref .' WHERE referee = :uid ORDER BY id DESC');            
    $query -> bindParam(':uid', $uid, PDO::PARAM_INT);
    $query -> execute();

    $rowCount = $query->rowCount();
    if($rowCount === 0){ sendResponse(404, false, 'No referral record found');}

    $returnData = array(); //return data in an array

    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        $returnData[] = $row;
    }

    //create a success response and set the retrived array as data. Also cache the response for faster reloading within 60secs
    sendResponse(200, true, 'success', $returnData, true);

}
catch (PDOException $e){
    responseServerException($e, "There was an error with fetching referrals");
}

?>