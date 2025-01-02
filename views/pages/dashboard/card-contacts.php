<?php
$contacts = retrieveDataFrom($c_website.'controllers/contacts.php?uid='.$loguserid);
$c_data = (isset($contacts->data) ? $contacts->data : []);
$c_count = count($c_data);
?>

<div class="col-xl-4" onclick="goTo('contacts')">
    <div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-xl-100" style="background-color: #7239EA;background-image:url('assets/media/svg/shapes/wave-bg-red.svg')">
        <div class="card-header pt-5 mb-3">
            <div class="d-flex flex-center rounded-circle h-80px w-80px" style="border: 1px dashed rgba(255, 255, 255, 0.4);background-color: #F1416C"> 
                <i class="fa fa-envelope text-white fs-2qx lh-0"></i>             
            </div>  
        </div>
        <div class="card-body d-flex align-items-end mb-3">
            <div class="d-flex align-items-center">
                <span class="fs-4hx text-white fw-bold me-6"><?= formatNumber($c_count); ?></span>
                <div class="fw-bold fs-6 text-white">
                    <span class="d-block">Contacts</span>
                    <span class="">Created</span>
                </div>            
            </div>
        </div>

        <div class="card-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.3);background: rgba(0, 0, 0, 0.15);">
            <div class="fw-bold text-white py-2">
                <span class="fs-1 d-block"><?= $max_contacts - $c_count; ?></span>
                <span class="opacity-50">Contacts Left</span>
            </div>
        </div>
    </div>
</div>