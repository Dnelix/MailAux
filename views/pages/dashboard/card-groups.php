<?php
$groups = retrieveDataFrom($c_website.'controllers/groups.php?uid='.$loguserid);
$g_data = (isset($groups->data) ? $groups->data : []);
$g_count = count($g_data)+1;
?>

<div class="col-xl-4" onclick="goTo('groups')">
    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #F1416C;background-image:url('assets/media/svg/shapes/wave-bg-purple.svg')">
        <div class="card-header pt-5 mb-3">
            <div class="d-flex flex-center rounded-circle h-80px w-80px" style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #7239EA"> 
                <i class="fa fa-envelope text-white fs-2qx lh-0"></i>             
            </div>  
        </div>
        <div class="card-body d-flex align-items-end mb-3">
            <div class="d-flex align-items-center">
                <span class="fs-4hx text-white fw-bold me-6"><?= formatNumber($g_count); ?></span>
                <div class="fw-bold fs-6 text-white">
                    <span class="d-block">Mailing</span>
                    <span class="">Groups</span>
                </div>            
            </div>
        </div>

        <div class="card-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
            <div class="fw-bold text-white py-2">
                <span class="fs-1 d-block"><?= $max_groups - $g_count; ?></span>
                <span class="opacity-50">Groups Left</span>
            </div>
        </div>
    </div>
</div>