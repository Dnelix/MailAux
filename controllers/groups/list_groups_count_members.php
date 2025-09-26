<?php
$limit = isset( $_GET['limit'] ) ? 'LIMIT '.intval( $_GET['limit'] ) : '';

try{
    //$desired_fields = ['id', 'group_name', 'description']; //optional
    $newFields = formatFieldsForAliasQuery($all_fields, 'g');

    $sql = "SELECT $newFields, COUNT(cg.contact_id) AS contact_count
            FROM $tbl g
            LEFT JOIN tbl_contact_group cg ON g.id = cg.group_id
            WHERE g.userid = :uid
            GROUP BY g.id, g.group_name, g.description $limit";

    $query = $readDB -> prepare ($sql);
    $query -> bindParam(':uid', $uid, PDO::PARAM_INT);
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