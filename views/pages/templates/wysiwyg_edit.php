<?php
if(!isset($cmid)){ echo '<script>history.back();</script>';}

$campaign = retrieveDataFrom($c_website.'controllers/campaigns.php?uid='.$loguserid.'&cmid='.$cmid);
$cm_data = (isset($campaign->data) ? $campaign->data : []);
?>

<div class="card card-flush mt-6 mt-xl-9 py-8 bg-white">
    <div class="card-body">
        <div name="kt_docs_ckeditor_inline" id="ckeditor_inline">
            <?= $cm_data->content; ?>
        </div>
    </div>
</div>




