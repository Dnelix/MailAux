<?php
//This script can insert anything into any table: (date & time must be in the format date('Y-m-d H:i:s')) 
//get from outside this file
// $itemsArray = array(); //with thier values
// $ins_tbl;

try{
    //1. initialize
    $fields = implode(", ", $itemsArray);

    //2. build values string
    $values = "";
    $emptyFields = "";
    foreach($itemsArray as $item){
        if(isset($$item)){
            $values .= ":{$item}, ";   //don't use with date fields or figure out the format to work in SQL 
        } else {
            $emptyFields .= $item.' ';
        }
    }

    if(!empty($emptyFields)){
        sendResponse(400, false, 'You have not provided valid parameters for some specified insert fields', $emptyFields); exit();
    }
    
    $values = rtrim($values, ", ");

    //3. write out the query string. Concatenate queryfields
    $queryString = 'INSERT INTO ' .$ins_tbl. ' ('.$fields.') VALUES('.$values.')';
    $query = $writeDB -> prepare($queryString);
    foreach($itemsArray as $item){
        if(isset($$item)){
            $query -> bindValue(":{$item}", $$item, PDO::PARAM_STR); //use bindValue() because of the dynamic values
        }
    }

    //4. execute
    $query -> execute();
    $errorInfo = $query->errorInfo();
    $rowCount = $query->rowCount();
    if($rowCount === 0){
        sendResponse(400, false, 'Unable to create this record. Please try again'); exit();
    }

    //5. return the insert ID
    $lastInsertID = $writeDB->lastInsertId();
    
    
    //6. add insert info to the returnData array
    $returnData['lastInsertID'] = $lastInsertID;
    foreach($itemsArray as $item){
        if(isset($$item) && !empty($$item)){
            $returnData['ins_'.$item] = $$item;
        }
    }
    
}
catch (PDOException $e){
    responseServerException($e, 'Failed to update record. Check for errors');
}
?>