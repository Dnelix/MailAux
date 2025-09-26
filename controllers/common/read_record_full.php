<?php
//This script will retrieve all details for a specifed record ID or retrive all records from the table if no ID is specified
####get from outside this file
## $sel_tbl;
## $rid; //record ID (optional)
## $fields; (optional. Implode if it is an array)

if(!isset($sel_tbl) || empty($sel_tbl)){
    sendResponse(404, false, "Please specify a selection table"); exit();
}
$fields = (isset($fields) && !empty($fields)) ? $fields : '*';
$where_clause = (isset($rid) && !empty($rid)) ? 'WHERE id = '. $rid . ' LIMIT 1' : '';

try{
    $query = $writeDB -> prepare('SELECT ' . $fields . ' FROM '. $sel_tbl . ' ' . $where_clause );
    $query -> execute();

    $rowCount = $query->rowCount();

    if($rowCount === 0){
        sendResponse(404, false, "Record not found!"); exit();
    }

    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        if($rowCount === 1){
            foreach ($row as $columnName => $value){
                $returnData[$columnName] = $value;
            }
        } else {
            $returnData[] = $row;
        }
    }
}
catch (PDOException $e){
    responseServerException($e, "There was an error with fetching records from $sel_tbl");
}
?>