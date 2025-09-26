<?php
## get from outside
//$uid
//$group_id
//$contacts_array[]
try{
    if(isset($group_id) && !empty($group_id) && $group_id != 0){

        $sql = "SELECT c.email
                FROM tbl_contacts c
                INNER JOIN tbl_contact_group cg ON c.id = cg.contact_id
                WHERE cg.group_id = :gid";

        $query = $readDB -> prepare ($sql);
        $query -> bindParam(':gid', $group_id, PDO::PARAM_INT);
        $query -> execute();

        $rowCount = $query->rowCount();
        if($rowCount === 0){ sendResponse(404, false, 'No contacts found in this group'); exit();}

        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $contacts_array[] = $row['email'];
        }

    } else {
    
        $query = $readDB -> prepare ('SELECT email FROM tbl_contacts WHERE userid = :uid');
        $query -> bindParam(':uid', $uid, PDO::PARAM_INT);
        $query -> execute();
    
        $rowCount = $query->rowCount();
        if($rowCount === 0){ sendResponse(404, false, 'No contacts found for this user'); exit();}
    
        while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $contacts_array[] = $row['email'];
        }
    
    }
}
catch (PDOException $e){
    responseServerException($e, "There was an error with fetching data");
}