<?php
//get from outside this file
// $itemsArray = array(); 
// $upd_tbl;
// $rid; //record id

try{
    //1. initialize
    $updated = false;

    //2. build querystring
    $queryFields = "";
    foreach($itemsArray as $field){
        if(isset($$field)){
            $queryFields .= "{$field} = :{$field}, ";
            $updated = true;
        }
    }
    $queryFields = rtrim($queryFields, ", ");

    //4. confirm the record exists
    $query = $writeDB -> prepare ('SELECT id FROM '.$upd_tbl.' WHERE id = :rid');            
    $query -> bindParam(':rid', $rid, PDO::PARAM_INT);
    $query -> execute();

    $rowCount = $query -> rowCount();
    if($rowCount === 0){
        $errorMsg = 'Record not found. Update failed!'; exit();
    }

    //5. write out the query string. Concatenate queryfields
    $queryString = "UPDATE ".$upd_tbl." SET ".$queryFields." WHERE id = :rid";
    $query = $writeDB -> prepare($queryString);
    $query -> bindParam(':rid', $rid, PDO::PARAM_INT);
    foreach($itemsArray as $field){
        if(isset($$field)){
            $query -> bindValue(":{$field}", $$field, PDO::PARAM_STR); //use bindValue() because of the dynamic values
        }
    }

    //6. execute
    $query -> execute();
    $errorInfo = $query->errorInfo();
    $rowCount = $query->rowCount();
    if($rowCount === 0){
        $errorMsg = 'Unknown error - You have not updated this record'; exit();
    }

    //7. return the newly updated record
    $table_columns = implode(", ", $itemsArray);
    $query = $writeDB -> prepare('SELECT '. $table_columns .' FROM '.$upd_tbl.' WHERE id = :rid');
    $query -> bindParam(':rid', $rid, PDO::PARAM_INT);
    $query -> execute();
    
    $rowCount = $query -> rowCount();
    if($rowCount === 0){
        $errorMsg = 'No record found after update'; exit();
    }
    
}
catch (PDOException $e){
    responseServerException($e, 'Failed to update record. Check for errors');
}
?>