<?php
$groups = retrieveDataFrom($c_website.'controllers/groups.php?countmembers&uid='.$loguserid);
$g_data = (isset($groups->data) ? $groups->data : []);

$contacts = retrieveDataFrom($c_website.'controllers/contacts.php?uid='.$loguserid);
$c_data = (isset($contacts->data) ? $contacts->data : []);
$c_count = count($c_data);
?>

<div class="row g-7">
    <div class="col-lg-4 col-xl-3">
        <?php include_once("contacts/groups.php"); ?>
    </div>

    <div class="col-lg-8 col-xl-9">
        <?php 
            include_once("contacts/create_options.php"); 
            include_once("contacts/list.php"); 
        ?>
    </div>
</div>

<?php
    include_once('contacts/modals/add_contact.php');
    include_once('contacts/modals/edit_contact.php');
    include_once('contacts/modals/paste_contacts.php');
    include_once('contacts/modals/upload_contacts.php');
?>