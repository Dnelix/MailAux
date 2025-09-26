<?php
### Get from outside the file
//$contact_id;
//$group_id;
$tbl = 'tbl_contact_group';

try {
    $readDB->beginTransaction();

    // Check if the contact exists in tbl_contacts
    $query = $readDB->prepare("SELECT 1 FROM tbl_contacts WHERE id = :contact_id");
    $query->execute([':contact_id' => $contact_id]);
    if ($query->rowCount() === 0) {
        throw new PDOException("Contact ID does not exist");
    }

    // Check if the contact already has a group in tbl_contact_group
    $query = $readDB->prepare("SELECT 1 FROM $tbl WHERE contact_id = :contact_id");
    $query->execute([':contact_id' => $contact_id]);

    if ($query->rowCount() > 0) {
        $query = $readDB->prepare("UPDATE $tbl SET group_id = :new_group_id, updated = CURRENT_TIMESTAMP WHERE contact_id = :contact_id");
        $query->execute([
            ':contact_id' => $contact_id,
            ':new_group_id' => $group_id
        ]);
    } else {
        // Insert a new record
        $query = $readDB->prepare("INSERT INTO $tbl (contact_id, group_id, updated) VALUES (:contact_id, :new_group_id, CURRENT_TIMESTAMP)");
        $query->execute([
            ':contact_id' => $contact_id,
            ':new_group_id' => $group_id
        ]);
    }

    $readDB->commit(); // Commit the transaction

} catch (PDOException $e) {
    $readDB->rollBack();
    responseServerException($e, "Error: " . $e->getMessage());
}

?>