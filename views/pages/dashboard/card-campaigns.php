<?php
$campaigns = retrieveDataFrom($c_website.'controllers/campaigns.php?uid='.$loguserid);
$cm_data = (isset($campaigns->data) ? $campaigns->data : []);
$cm_count = count($cm_data);
?>

<div class="col-xl-4" onclick="goTo('campaigns')">
    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #E96922;background-image:url('assets/media/svg/shapes/wave-bg-dark.svg')">
        <div class="card-header pt-5 mb-3">
            <div class="d-flex flex-center rounded-circle h-80px w-80px" style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #000"> 
                <i class="fa fa-envelope text-white fs-2qx lh-0"></i>             
            </div>  
        </div>
        <div class="card-body d-flex align-items-end mb-3">
            <div class="d-flex align-items-center">
                <span class="fs-4hx text-white fw-bold me-6"><?= formatNumber($cm_count); ?></span>
                <div class="fw-bold fs-6 text-white">
                    <span class="d-block">Email</span>
                    <span class="">Campaigns</span>
                </div>            
            </div>
        </div>

        <div class="card-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
            <div class="fw-bold text-white py-2">
                <span class="fs-1 d-block"><?= $max_campaigns - $cm_count; ?></span>
                <span class="opacity-50">Campaigns Remaining</span>
            </div>
        </div>
    </div>
</div>
