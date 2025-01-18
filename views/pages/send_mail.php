<?php
$cmid = isset($_GET['cmid']) ? $_GET['cmid'] : null;
$campaign = retrieveDataFrom($c_website.'controllers/campaigns.php?uid='.$loguserid.'&cmid='.$cmid);
$cm_data = (isset($campaign->data) ? $campaign->data : []);
?>

<div class="row g-7">
    <div class="col-lg-8 col-xl-8">
        <?php 
            include_once("templates/wysiwyg_output.php");
        ?>
    </div>
    <div class="col-lg-4 col-xl-4">
        <div class="card card-flush mt-6 mt-xl-9">
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900 fs-3">Summary</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Review details</span>
                </h3>
                <div class="card-toolbar">
                    <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                        <i class="fa fa-bars"></i>                             
                    </button>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true" style="">
                        <div class="menu-item px-3">
                            <a href="account" class="menu-link px-3">Update Profile</a>
                        </div>
                    </div>             
                </div>
            </div>

            <div class="card-body pt-5">
                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-bold fs-6 me-2 text-center"><?= $cm_data->title; ?></div>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-semibold fs-6 me-2">From:</div>
                    <div class="d-flex align-items-center">
                        <span class="text-gray-900 fw-bold fs-6"><?= $cm_data->from_name; ?></span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Email: </div>
                    <div class="d-flex align-items-center">
                        <span class="text-gray-900 fw-bold fs-7"><?= $c_email[1]; ?></span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-semibold fs-6 me-2">No. of reciepients</div>
                    <div class="d-flex align-items-center">
                        <span class="text-gray-900 fw-bolder fs-6"><?= formatNumber($cm_data->num_recipients); ?></span> &nbsp;|&nbsp;
                        <a href="#"> change</a>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Average delivery time</div>
                    <div class="d-flex align-items-center">
                        <span class="text-gray-900 fw-bolder fs-6">3.09 secs</span>
                    </div>
                </div>
                <div class="separator separator-dashed my-3"></div>
                <div class="d-flex flex-stack">
                    <div class="text-gray-700 fw-semibold fs-6 me-2">Send date</div>
                    <div class="d-flex align-items-center">
                        <span class="text-gray-900 fw-bolder fs-6"><?= readableDateTime(date($mysql_dateformat)); ?> </span>
                    </div>
                </div>
                
                <?php if($cm_data->status != 'Completed') { ?>
                <div class="mt-8 row">
                    <button type="button" onclick="saveCampaign()" class="btn btn-secondary col-5 me-2">Save</button>
                    <button type="button" onclick="sendCampaign('<?= $cmid; ?>')" id="sendCamBtn" class="btn btn-primary col-6"><?= displayLoadingBtn('Send Now'); ?></button>
                </div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>

<script>
    function saveCampaign(){
        swal_popup('success', 'Saved to you campaigns. You can send this email at any time', 'Go to campaigns', ()=>goTo('campaigns'));
    }

    function sendCampaign(cmid){
        var web = '<?= $appURL; ?>';
        var userid = '<?= $loguserid; ?>';
        var url = web+"controllers/campaigns.php?send&uid="+userid+"&cmid="+cmid;
        var btn = "#sendCamBtn";

        swal_popup('info', 'This may take a while. Please stay on this page while we process the mails', 'Proceed', 
        ()=>AJAXcall("POST", url, btn, null, (r)=>{ handleResponseMsg(r, 'confirmredirect', 'campaigns'); }));
    }
</script>
