<?php
//This script will retrieve all details for a specifed record ID or retrive all records from the table if no ID is specified
####get from outside this file
## $sel_tbl;
## $fields; (optional. Implode if it is an array)
## $where_clause (required)

//validate mandatory fields
if(empty($where_clause) && !isset($where_clause)){
    sendResponse(404, false, "Please provide a valid condition for this query"); exit();
}

$mandatoryFields = array('sel_tbl', 'where_clause');
$errorMsg = requiredFields($mandatoryFields);
if (!empty($errorMsg)) {
    sendResponse(400, false, $errorMsg); exit();
}

$fields = (isset($fields) && !empty($fields)) ? $fields : '*';

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