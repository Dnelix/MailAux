<?php
$plan_limits = getPlanData($loguserid, 'uid');
$max_contacts = $plan_limits->max_contacts;
$max_groups = $plan_limits->max_groups;
$max_campaigns = $plan_limits->max_campaigns;
?>

<div class="row g-7">
    <?php 
        include("dashboard/card-contacts.php"); 
        include("dashboard/card-groups.php"); 
        include("dashboard/card-campaigns.php"); 
    ?>
</div>