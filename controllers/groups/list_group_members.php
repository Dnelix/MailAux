<?php
$limit = isset( $_GET['limit'] ) ? 'LIMIT '.intval( $_GET['limit'] ) : '';

try{
    $newFields = formatFieldsForAliasQuery($all_fields, 'c');

    $sql = "SELECT $newFields
            FROM tbl_contacts c
            INNER JOIN tbl_contact_group cg ON c.id = cg.contact_id
            WHERE cg.group_id = :gid ORDER BY id DESC $limit";

    $query = $readDB -> prepare ($sql);
    $query -> bindParam(':gid', $gid, PDO::PARAM_INT);
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