<?php
$profileCompletion = calcProfileCompletion($user->fullname, $bizdata->name, $bizdata->description, $bizdata->address, $bizdata->email);

$initials = getInitials($logName);
?>

<div class="card mb-5 mb-xl-10">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap">
            <div class="me-7 mb-4">
                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    <?= displayUserIcon(getInitials($logName), 1, 'large'); ?>
                    <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-white h-20px w-20px"></div>
                </div>
            </div>

            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-2">
                            <a href="javascript:;" class="text-gray-900 text-hover-primary fs-2 fw-bolder me-1"><?= ucwords($logName); ?></a>
                            <a href="javascript:;"><?= $svg_verifiedicon; ?></a>
                            <?php if ($user->role === "business") { ?>
                                <a href="javascript:;" class="btn btn-sm btn-light-success fw-bolder ms-2 fs-8 py-1 px-3" data-bs-toggle="modal" data-bs-target="#kt_modal_upgrade_plan">Upgrade account</a>
                            <?php } else { ?>
                                <a onClick="javascript:swal_popup('info', 'Sorry we can\'t do this now');" class="btn btn-sm btn-light-success fw-bolder ms-2 fs-8 py-1 px-3">Upgrade</a>
                            <?php } ?>
                        </div>
                        
                        <div class="d-flex flex-wrap fw-bold fs-6 mb-4 pe-2">
                            <a href="javascript:;" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                <i class="fa fa-user me-3"></i> <?= $user->phone; ?>
                            </a>
                            <a href="javascript:;" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                <i class="fa fa-map-marker mx-3"></i> <?= $location; ?>
                            </a>
                            <a href="javascript:;" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                <i class="fa fa-envelope mx-3"></i> <?= $user->email; ?>
                            </a>
                        </div>
                    </div>

                    <div class="d-flex my-4">
                        <a href="javascript:;" onClick="history.back()" class="btn btn-sm btn-light me-2"><span class="indicator-label"><i class="fa fa-arrow-left"></i> Go back</span></a>
                        <div class="me-0">
                            <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <i class="bi bi-three-dots fs-3"></i>
                            </button>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true" style="">
                                <div class="menu-item px-3">
                                    <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Account Options</div>
                                </div>

                                <div class="menu-item px-3"><a href="javascript:swal_popup('info', 'Sorry we can\'t do this now');" class="menu-link px-3">Close my account</a></div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="d-flex flex-wrap flex-stack">
                    <!--div class="d-flex flex-column flex-grow-1 pe-8">
                        <div class="d-flex flex-wrap">
                            <?php if ($user->role === "business") { ?>
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-arrow-up text-success me-2"></i>
                                    <div class="fs-2 fw-bolder counted" data-kt-countup="true" data-kt-countup-value="<?= $customerCount; ?>"><?= $customerCount; ?></div>
                                </div>
                                <div class="fw-bold fs-6 text-gray-400">Total Customers</div>
                            </div>
                            <?php } ?>
                            
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-arrow-up text-info me-2"></i>
                                    <div class="fs-2 fw-bolder counted" data-kt-countup="true" data-kt-countup-value="<?= $projectCount; ?>"><?= $projectCount; ?></div>
                                </div>
                                <div class="fw-bold fs-6 text-gray-400">Total <?= $alt_job.'s'; ?></div>
                            </div>

                            <?php if ($user->role === "customer") { ?>
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-arrow-down text-danger me-2"></i>
                                    <div class="fs-2 fw-bolder counted" data-kt-countup="true" data-kt-countup-value="<?= $incomeTotal; ?>"><?= $incomeTotal; ?></div>
                                </div>
                                <div class="fw-bold fs-6 text-gray-400">Total Expenditure</div>
                            </div>
                            <?php } ?>
                            
                            <?php if ($user->role === "business") { ?>
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-arrow-up text-success me-2"></i>
                                    <div class="fs-2 fw-bolder text-success counted" data-kt-countup="true" data-kt-countup-value="<?= $balanceTotal; ?>" data-kt-countup-prefix="<?= $defaultcurrency; ?>"><?= $defaultcurrency.' '.formatNumber($balanceTotal); ?></div>
                                </div>
                                <div class="fw-bold fs-6 text-gray-400">Profit Earned</div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>-->

                    <!--begin::Progress-->
                    <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                            <span class="fw-bold fs-6 text-gray-400">Profile Completion</span>
                            <span class="fw-bolder fs-6"><?= $profileCompletion; ?>%</span>
                        </div>
                        <div class="h-5px mx-3 w-100 bg-light mb-3">
                            <div class="bg-primary rounded h-5px" role="progressbar" style="width: <?= $profileCompletion; ?>%;" aria-valuenow="<?= $profileCompletion ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
        <div class="separator"></div>

        <?php include_once("sections/navigation.php"); ?>
        
    </div>
</div>