<div id="kt_app_toolbar" class="app-toolbar d-flex pb-3 pb-lg-5">

<?php if ($curPage == '' || $curPage == 'dashboard'){ ?>
    <div class="d-flex flex-stack flex-row-fluid">
        <div class="d-flex flex-column flex-row-fluid">
            <div class="page-title d-flex align-items-center me-3">
                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-lg-2x gap-2">
                    <span class="text-white"><span class="fw-light">Welcome back</span>,&nbsp;<?= ucwords($logusername); ?></span>
                    <span class="page-desc text-gray-600 fs-base fw-semibold">
                        Create mailing lists, add contacts and send out bulk emails easily
                    </span>
                </h1>
            </div>
        </div>
    </div>

<?php } else { ?>
    <div class="d-flex flex-stack flex-row-fluid">
        <div class="d-flex flex-column flex-row-fluid">
            <div class="page-title d-flex align-items-center me-3">
                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-lg-2x gap-2">
                    <span class="text-white"><?= ucwords(str_replace('_', ' ', $curPage)); ?></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-3 fs-7">        
                        <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                            <a href="./" class="text-white text-hover-primary"><i class="fa fa-home text-gray-700 fs-6"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item"><i class="fa fa-caret-right fs-7 text-gray-700 mx-n1"></i></li>
                        <li class="breadcrumb-item text-gray-700"><?= ucwords(str_replace('_', ' ', $curPage)); ?></li>                 
                    </ul>
                </h1>
            </div>
        </div>
        <div class="d-flex align-self-center flex-center flex-shrink-0">
            <!-- <a href="#" class="btn btn-sm btn-success d-flex flex-center ms-3 px-4 py-3" data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">
                <i class="ki-outline ki-plus-square fs-2"></i>
                <span>Invite</span>
            </a> -->
            <a onclick="javascript:history.back()" class="btn btn-sm btn-dark ms-3 px-4 py-3">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
<?php } ?>

</div>
