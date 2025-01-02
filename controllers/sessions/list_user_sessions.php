<?php
//DATE_FORMAT(r_tokenexpiry, "'.$read_dateformat.'") //returns as date
//TIMESTAMPDIFF(SECOND, r_tokenexpiry, NOW()) //returns as a string of numbers
try{
    $fields = 'id, DATE_FORMAT(login_time, "'.$read_dateformat.'") as logintime, DATE_FORMAT(r_tokenexpiry, "'.$read_dateformat.'") as loginexpiry, device, ip';
    
    //connect to the $readDB to perform this query since it's a read request
    $query = $readDB -> prepare ('SELECT '.$fields.' FROM tbl_sessions WHERE userid = :userid ORDER BY id DESC');            
    $query -> bindParam(':userid', $userid, PDO::PARAM_INT);
    $query -> execute();

    $rowCount = $query->rowCount();

    if($rowCount === 0){
        sendResponse(404, false, 'No sessions found for this user');
    }
    //else
    $usersessions = [];
    while($row = $query -> fetch(PDO::FETCH_ASSOC)) {
        $usersessions[] = [
            "id" => $row['id'], 
            "logintime" => $row['logintime'], 
            "loginexpiry" => $row['loginexpiry'], 
            "device" => $row['device'], 
            "ip" => $row['ip']
        ];
    }

    $returnData = $usersessions;

    //create a success response and set the retrived array as data. Also cache the response for faster reloading within 60secs
    sendResponse(200, true, 'success', $returnData, true);

}
catch (PDOException $e){
    responseServerException($e, "There was an error with fetching user sessions");
}

?>