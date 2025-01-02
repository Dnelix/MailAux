<?php

try{    
    $query = $readDB -> prepare ('SELECT '.$all_fields.' FROM '. $tbl .' WHERE id = :pid LIMIT 1');            
    $query -> bindParam(':pid', $pid, PDO::PARAM_INT);
    $query -> execute();

    $rowCount = $query->rowCount();
    if($rowCount === 0){ sendResponse(404, false, 'Plan record not Found');}

    $planData = array(); //return data in an array

    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        foreach ($row as $columnName => $value){
            $planData[$columnName] = $value;
        }
    }

    //create a success response and set the retrived array as data. Also cache the response for faster reloading within 60secs
    sendResponse(200, true, 'success', $planData, true);

}
catch (PDOException $e){
    responseServerException($e, "There was an error with fetching this plan");
}

?>