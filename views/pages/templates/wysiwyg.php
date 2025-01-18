<?php
if(!isset($tid)){ echo '<script>history.back();</script>';}

$templates = retrieveDataFrom($c_website.'controllers/templates.php?tid='.$tid);
$t_data = (isset($templates->data) ? $templates->data : null);
?>

<div class="card card-flush mt-6 mt-xl-9 py-8 bg-white">
    <div class="card-body">
        <div name="kt_docs_ckeditor_inline" id="ckeditor_inline">
            <?= $t_data->content; ?>
        </div>
    </div>
</div>




