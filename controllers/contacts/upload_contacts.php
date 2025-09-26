<?php
if (!isset($_FILES['file']) || $_FILES['file']['error'] != UPLOAD_ERR_OK) {
    sendResponse(401, false, 'File upload failed.'); exit();
}

// File properties
$file_name = $_FILES['file']['name'];
$file_tmp = $_FILES['file']['tmp_name'];
$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

// Allowed file extensions
$allowed_ext = ["xls", "xlsx", "csv"];
if (!in_array($file_ext, $allowed_ext)) {
    sendResponse(400, false, 'Invalid file format. Only XLS, XLSX, and CSV files are allowed.'); exit();
}

// Convert Excel to CSV if needed
$csv_file = $file_tmp . ".csv";
if ($file_ext !== "csv") {
    $cmd = "ssconvert --export-type=Gnumeric_stf:stf_csv $file_tmp $csv_file 2>&1";
    exec($cmd, $output, $return_code);
    if ($return_code !== 0) {
        $err_msg = "Error converting file to CSV: " . implode("\n", $output);
        sendResponse(401, false, $err_msg, $err_msg); exit();
    }
} else {
    $csv_file = $file_tmp;
}

// Read CSV and extract emails (use this for emails only)
/*$emails = [];
if (($handle = fopen($csv_file, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        foreach ($data as $value) {
            $email = trim($value);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emails[] = $email;
            }
        }
    }
    fclose($handle);
}
*/

// Step 1: Read CSV and extract contacts
$contacts = [];
if (($handle = fopen($csv_file, "r")) !== FALSE) {
    $header = fgetcsv($handle, 1000, ",");
    $emailIndex = array_search("email", $header);
    $fnameIndex = array_search("first_name", $header);
    $lnameIndex = array_search("last_name", $header);

    if ($emailIndex === false) {
        sendResponse(400, false, 'CSV file must contain an "email" column.'); exit();
    }

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $email = isset($data[$emailIndex]) ? strtolower(trim($data[$emailIndex])) : '';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) continue;

        $first_name = ($fnameIndex !== false && isset($data[$fnameIndex])) ? trim($data[$fnameIndex]) : '';
        $last_name = ($lnameIndex !== false && isset($data[$lnameIndex])) ? trim($data[$lnameIndex]) : '';

        $contacts[] = [
            'email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name
        ];
    }
    fclose($handle);
}

// Step 2: Remove contacts with emails that already exist
$contacts_url = $c_website . 'controllers/contacts.php?uid=' . $uid;
$contacts_api = retrieveDataFrom($contacts_url);
$existing_data = isset($contacts_api->data) ? $contacts_api->data : [];

$existing_emails = [];
foreach ($existing_data as $contact) {
    $existing_emails[strtolower($contact->email)] = true;
}

$filtered_contacts = [];
foreach ($contacts as $c) {
    if (!isset($existing_emails[$c['email']])) {
        $filtered_contacts[] = $c;
    }
}

// Step 3: Check Plan Limit
$max_contacts = getPlanData($uid, 'uid', 'max_contacts');
$current_count = countRecord('contacts', 'uid=' . $uid);
$total_to_insert = count($filtered_contacts);
if (($current_count + $total_to_insert) > $max_contacts) {
    sendResponse(400, false, 'Creating these contacts exceeds your plan limit. Please upgrade to add more contacts'); exit();
}

try{
    // Insert contacts into the database
    if (!empty($filtered_contacts)) {
        foreach ($filtered_contacts as $contact) {
            $userid = $uid;
            $email = $contact['email'];
            $first_name = $contact['first_name'];
            $last_name = $contact['last_name'];
            $created = date($mysql_dateformat);
            $itemsArray = ['userid', 'email', 'first_name', 'last_name', 'created'];
            $ins_tbl = $tbl;
            require('common/insert_record.php');
        }
    
        sendResponse(200, true, 'Contact list have been updated successfully!', ['inserted' => $filtered_contacts]); exit();
    } else {
        sendResponse(400, false, 'No new valid contacts found to insert.'); exit();
    }
}
catch (PDOException $e){
    responseServerException($e, "Failed to create bulk records. Check for errors");
}