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
            $queryFields .= "{$field} = :{$field}, ";   //may not work for date fields
            $updated = true;
        }
    }
    $queryFields = rtrim($queryFields, ", ");

    //3. check that at least one variable have been updated to true
    if (!$updated) {
        sendResponse(400, false, 'No changes made'); exit();
    }

    //4. confirm the record exists
    $query = $readDB -> prepare ('SELECT id FROM '.$upd_tbl.' WHERE id = :rid');            
    $query -> bindParam(':rid', $rid, PDO::PARAM_INT);
    $query -> execute();

    $rowCount = $query -> rowCount();
    if($rowCount === 0){
        sendResponse(404, false, 'Record not found. Update failed!'); exit();
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
        if(!empty($_FILES)){
            return true; //Ignore if uploaded file is found. A new file may have been uploaded but with the same name.
        }else{
            sendResponse(400, false, 'You have not made any changes'); exit;
        }
    }

    //7. return the newly updated record
    $table_columns = implode(", ", $itemsArray);
    $query = $writeDB -> prepare('SELECT '. $table_columns .' FROM '.$upd_tbl.' WHERE id = :rid');
    $query -> bindParam(':rid', $rid, PDO::PARAM_INT);
    $query -> execute();
    
    $rowCount = $query -> rowCount();
    if($rowCount === 0){
        sendResponse(404, false, 'No record found after update'); exit();
    }
    
    //8. add update data to the returnData array
    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        foreach ($row as $columnName => $value){
            $returnData['upd_'.$columnName] = $value;
        }
    }
    
}
catch (PDOException $e){
    responseServerException($e, 'Failed to update record. Check for errors');
}
?>