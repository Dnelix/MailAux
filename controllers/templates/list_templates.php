<?php
$limit = isset( $_GET['limit'] ) ? 'LIMIT '.intval( $_GET['limit'] ) : '';

try{    
    //connect to the $readDB to perform this query since it's a read request
    $query = $readDB -> prepare ('SELECT '.$all_fields.' FROM '. $tbl .' WHERE status = "active" '.$limit);
    $query -> execute();

    $rowCount = $query->rowCount();
    if($rowCount === 0){ sendResponse(404, false, 'No Data Found'); exit();}

    $returnData = array(); //return data in an array

    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        $returnData[] = $row;
    }

    //create a success response and set the retrived array as data. Also cache the response for faster reloading within 60secs
    sendResponse(200, true, 'success', $returnData, true);

}
catch (PDOException $e){
    responseServerException($e, "There was an error with fetching data");
}

?>