<?php
$tid = isset($_GET['tid']) ? $_GET['tid'] : null;
$cmid = isset($_GET['cmid']) ? $_GET['cmid'] : null;
?>

<div class="row g-7">
    <div class="col-lg-4 col-xl-4">
        <div class="card card-flush mt-6 mt-xl-9 p-8 bg-white">
            <img class="mw-100 mh-300px card-rounded-bottom" alt="" src="assets/media/illustrations/sigma-1/1.png">
            <p class="p-8">Click anywhere in the body of the email to start editing the document</p>
            <button type="button" onclick="updateCampaignContent('<?= $cmid; ?>','<?= $tid; ?>')" class="btn btn-primary col-12" id="finish_btn">
                <?= displayLoadingBtn("Finish Editing"); ?>
            </button>
        </div>
    </div>

    <div class="col-lg-8 col-xl-8">
        <?php 
            if(!empty($tid)) {
                include_once("templates/wysiwyg.php");
            } else {
                include_once("templates/wysiwyg_edit.php");
            }
        ?>
    </div>
</div>

<script>
    function updateCampaignContent(cmid, tid=null){
        var mailContent = document.querySelector('#ckeditor_inline').innerHTML;
        //console.log(mailContent);

        var web = '<?= $appURL; ?>';
        var userid = '<?= $loguserid; ?>';
        var url = web+"controllers/campaigns.php?uid="+userid+"&cmid="+cmid;
        var formData = {content : mailContent, template_id : tid}
        var btn = "#finish_btn";

        AJAXcall("PATCH", url, btn, formData, (r)=>{ handleResponseMsg(r, 'confirmredirect', 'send_mail&cmid='+cmid); });
        //goTo('send_mail&tid=1')
    }
</script>
