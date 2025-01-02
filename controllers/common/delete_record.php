<?php
//Careful: This script will delete specifed record from any table 
####get from outside this file
## $d_id; //record ID
## $del_tbl;
## $add_condition (optional)

$add_condition = (isset($add_condition) && !empty($add_condition)) ? $add_condition : '';

try{
    $query = $writeDB -> prepare('DELETE FROM ' . $del_tbl . ' WHERE id = :did ' . $add_condition . ' LIMIT 1');
    $query -> bindParam(':did', $d_id, PDO::PARAM_INT);
    $query -> execute();

    $rowCount = $query->rowCount();

    if($rowCount === 0){
        sendResponse(404, false, "Record not found!"); exit();
    }

    $returnData = array();
    $returnData['del_'.$del_tbl.'_id'] = $d_id;
    
}
catch (PDOException $e){
    responseServerException($e, "Failed to delete record from $del_tbl. Check for errors");
}
?>