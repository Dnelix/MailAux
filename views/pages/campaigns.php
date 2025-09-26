<?php
$campaigns = retrieveDataFrom($c_website.'controllers/campaigns.php?uid='.$loguserid);
$cm_data = (isset($campaigns->data) ? $campaigns->data : []);
$cm_count = count($cm_data);
?>

<div class="row g-7">
    <div class="col-12">
        <?php include_once("campaigns/list.php"); ?>
    </div>
</div>