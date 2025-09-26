
<div class="app-navbar flex-shrink-0">

    <!-- Notifications --
    <div class="app-navbar-item ms-1 ms-lg-5">
        <div class="btn btn-icon btn-custom btn-active-color-primary btn-color-gray-700 w-35px h-35px w-md-40px h-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom">
            <i class="fa fa-calendar fs-1"></i>
        </div>
        
        <!-- Notifications Dropdown --
        <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications">
            <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('assets/media/misc/menu-header-bg.jpg')">
                <h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifications <span class="fs-8 opacity-75 ps-3">24 reports</span></h3>
                <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                    <li class="nav-item"><a class="nav-link text-white opacity-75 pb-4" data-bs-toggle="tab" href="#kt_topbar_notifications_1">Alerts</a></li>
                    <li class="nav-item"><a class="nav-link text-white opacity-75 pb-4 active" data-bs-toggle="tab" href="#kt_topbar_notifications_2">Updates</a></li>
                    <li class="nav-item"><a class="nav-link text-white opacity-75 pb-4" data-bs-toggle="tab" href="#kt_topbar_notifications_3">Logs</a></li>
                </ul>
            </div>
            
            <div class="tab-content">
                <div class="tab-pane fade" id="kt_topbar_notifications_1" role="tabpanel">
                    <div class="scroll-y mh-325px my-5 px-8">
                        <div class="d-flex flex-stack py-4">
                            <div class="d-flex align-items-center">
                                <div class="symbol symbol-35px me-4">
                                    <span class="symbol-label bg-light-primary">
                                        <i class="ki-outline ki-abstract-28 fs-2 text-primary"></i>
                                    </span>
                                </div>
                                <div class="mb-0 me-2">
                                    <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">Project Alice</a>
                                    <div class="text-gray-500 fs-7">Phase 1 development</div>
                                </div>
                            </div>
                            <span class="badge badge-light fs-8">1 hr</span>
                        </div>
                    </div>
                    <div class="py-3 text-center border-top">
                        <a href="pages/user-profile/activity.html" class="btn btn-color-gray-600 btn-active-color-primary">
                            View All <i class="ki-outline ki-arrow-right fs-5"></i>
                        </a>
                    </div>
                </div>

                <!-- More Tab Panels (Updates, Logs) --

            </div>
        </div>
        <!-- End Notifications Dropdown --
    </div>
    <!-- End Notifications -->

    <div class="app-navbar-item ms-3 ms-lg-5">
        <div class="cursor-pointer symbol symbol-35px symbol-md-40px">
            <button class="btn btn-icon btn-color-gray-600 btn-active-color-primary ms-n3 me-2 d-flex d-lg-none" id="kt_app_sidebar_toggle">
                <i class="fa fa-bars fs-2"></i>
            </button>
        </div>
    </div>

    <!-- User Menu -->
    <div class="app-navbar-item ms-3 ms-lg-5" id="kt_header_user_menu_toggle">
        <div class="cursor-pointer symbol symbol-35px symbol-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'click'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <div class="symbol symbol-circle symbol-35px symbol-md-40px">
                <span class="symbol-label bg-light-info text-info fw-bold"><?= getInitials($logName); ?></span>
            </div>      
        </div>
        
        <!--begin::User account menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-2 fs-6 w-275px" data-kt-menu="true" style="">
            <div class="menu-item px-3">
                <div class="menu-content d-flex align-items-center px-3">
                    <div class="symbol symbol-50px me-5">
                        <span class="symbol-label bg-light-danger text-danger fw-bold"><?= getInitials($logName); ?></span>
                    </div>
                    <div class="d-flex flex-column">
                        <div class="fw-bold d-flex align-items-center fs-5">
                        <?= ucwords($logName); ?><span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2"><?= $userplan->plan; ?></span>
                        </div>
                        <a href="#" class="fw-semibold text-muted text-hover-primary fs-7"><?= $user->email; ?></a>
                    </div>
                </div>
            </div>

            <div class="separator my-2"></div>

            <div class="menu-item px-5"><a href="account" class="menu-link px-5">My Profile</a></div>
            <div class="menu-item px-5">
                <a href="campaigns" class="menu-link px-5">
                    <span class="menu-text">Campaigns</span>
                    <span class="menu-badge"><span class="badge badge-light-danger badge-circle fw-bold fs-7">3</span></span>
                </a>
            </div>

            <div class="separator my-2"></div>

            <div class="menu-item px-5 my-1"><a href="account" class="menu-link px-5">Account Settings</a></div>
            <div class="menu-item px-5"><a href="javascript:;" onclick="logout(<?= $logsessionid; ?>)" class="menu-link px-5">Sign Out</a></div>
        </div>

    </div>
</div>