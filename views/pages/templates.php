<?php
$templates = retrieveDataFrom($c_website.'controllers/templates.php');
$t_data = (isset($templates->data) ? $templates->data : []);
$t_count = count($t_data);

$cmid = isset($_GET['cmid']) ? $_GET['cmid'] : null;
?>
    
    <div class="row g-7">
        <?php 
            if($cmid){
                echo '<div class="col-12 text-white fs-4">Great! Next choose a template for the email</div>';
            }
        
            foreach ($t_data as $t){
                include("templates/item.php");
            }
        ?>

    </div>


<script>
    function goToEdit(tid){
        var campaign_id = '<?= $cmid; ?>';
        if (isEmpty(campaign_id)){
            swal_popup('info','Please create a campaign first for this email.');
        } else {
            goTo('edit_template&tid='+tid+'&cmid='+campaign_id);
        }
    }
</script>