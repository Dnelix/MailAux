<?php

try{    
    $query = $readDB -> prepare ('SELECT '.$all_fields.' FROM '. $tbl .' id = :tid LIMIT 1');
    $query -> bindParam(':tid', $tid, PDO::PARAM_INT);
    $query -> execute();

    $rowCount = $query->rowCount();
    if($rowCount === 0){ sendResponse(404, false, 'Record not Found');}

    $returnData = array(); //return data in an array

    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        foreach ($row as $columnName => $value){
            $returnData[$columnName] = $value;
        }
    }

    //create a success response and set the retrived array as data. Also cache the response for faster reloading within 60secs
    sendResponse(200, true, 'success', $returnData, true);

}
catch (PDOException $e){
    responseServerException($e, "There was an error with fetching this record");
}

?>