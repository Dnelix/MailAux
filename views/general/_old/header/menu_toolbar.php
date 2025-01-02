    <div class="topbar d-flex align-items-stretch flex-shrink-0">
        <!--begin::Chat-->
        <div class="d-flex align-items-center ms-1 ms-lg-3">
            <div class="btn btn-icon btn-active-light-primary position-relative btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px" id="kt_drawer_chat_toggle">
                <span class="svg-icon svg-icon-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.3" d="M20 3H4C2.89543 3 2 3.89543 2 5V16C2 17.1046 2.89543 18 4 18H4.5C5.05228 18 5.5 18.4477 5.5 19V21.5052C5.5 22.1441 6.21212 22.5253 6.74376 22.1708L11.4885 19.0077C12.4741 18.3506 13.6321 18 14.8167 18H20C21.1046 18 22 17.1046 22 16V5C22 3.89543 21.1046 3 20 3Z" fill="currentColor" />
                        <rect x="6" y="12" width="7" height="2" rx="1" fill="currentColor" />
                        <rect x="6" y="7" width="12" height="2" rx="1" fill="currentColor" />
                    </svg>
                </span>
                <span class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink"></span>
            </div>
        </div>
        <!--end::Chat-->
        <!--begin::User-->
        <div class="d-flex align-items-center me-n3 ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
            <div class="btn btn-icon btn-active-light-primary btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                <!--img class="h-30px w-30px rounded" src="assets/media/avatars/300-2.jpg" alt="" /-->
                <?= showCustomerIcon($userdata->id, $user_initials); ?>
            </div>
            <!--begin::User account menu-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
                <div class="menu-item px-3">
                    <div class="menu-content d-flex align-items-center px-3">
                        <div class="symbol symbol-50px me-5">
                            <!--img alt="Logo" src="assets/media/avatars/300-2.jpg" /-->
                            <?= showCustomerIcon($userdata->id, $user_initials); ?>
                        </div>
                        <div class="d-flex flex-column">
                            <div class="fw-bolder d-flex align-items-center fs-5"><?= $logusername; ?> 
                            <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">Pro</span></div>
                            <a href="#" class="fw-bold text-muted text-hover-primary fs-7"><?= $userdata->email; ?></a>
                        </div>
                    </div>
                </div>
                
                <div class="separator my-2"></div>
                
                <?php if ($logrole === 'business'){ ?>

                    <div class="menu-item px-5">
                        <a href="profile?page=business" class="menu-link px-5">Business Profile</a>
                    </div>
                    <div class="menu-item px-5">
                        <a href="projects" class="menu-link px-5">
                            <span class="menu-text">My <?= $alt_job.'s'; ?></span>
                            <span class="menu-badge">
                                <span class="badge badge-light-danger badge-circle fw-bolder fs-7">3</span>
                            </span>
                        </a>
                    </div>
                    <div class="menu-item px-5">
                        <a href="customers" class="menu-link px-5">My customers</a>
                    </div>

                <?php } else { ?>

                    <div class="menu-item px-5">
                        <a href="profile?page=details" class="menu-link px-5">My Profile</a>
                    </div>
                    <div class="menu-item px-5">
                        <a href="measurements" class="menu-link px-5">Measurement Data</a>
                    </div>
                    <div class="menu-item px-5">
                        <a href="projects" class="menu-link px-5">My <?= $alt_job.'s'; ?></a>
                    </div>
                    
                <?php } ?>
                    
                <div class="separator my-2"></div>
                
                <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start">
                    <a href="#" class="menu-link px-5">
                        <span class="menu-title position-relative">Language 
                        <span class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">English 
                        <img class="w-15px h-15px rounded-1 ms-2" src="assets/media/flags/united-states.svg" alt="" /></span></span>
                    </a>
                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5 active">
                            <span class="symbol symbol-20px me-4">
                                <img class="rounded-1" src="assets/media/flags/united-states.svg" alt="" />
                            </span>English</a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5">
                            <span class="symbol symbol-20px me-4">
                                <img class="rounded-1" src="assets/media/flags/spain.svg" alt="" />
                            </span>Spanish</a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="" class="menu-link d-flex px-5">
                            <span class="symbol symbol-20px me-4">
                                <img class="rounded-1" src="assets/media/flags/germany.svg" alt="" />
                            </span>German</a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5">
                            <span class="symbol symbol-20px me-4">
                                <img class="rounded-1" src="assets/media/flags/japan.svg" alt="" />
                            </span>Japanese</a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link d-flex px-5">
                            <span class="symbol symbol-20px me-4">
                                <img class="rounded-1" src="assets/media/flags/france.svg" alt="" />
                            </span>French</a>
                        </div>
                    </div>
                </div>
                
                <div class="menu-item px-5 my-1">
                    <a href="profile" class="menu-link px-5">Account Settings</a>
                </div>
                <div class="menu-item px-5">
                    
                    <a onClick="logout(<?= $logsessionid; ?>, '<?= $logrole; ?>')" class="menu-link px-5" id="logout_link">Sign Out
                        <span class="indicator-progress"><span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </a>
                </div>

                <div class="separator my-2"></div>
                
                <div class="menu-item px-5">
                    <div class="menu-content px-5">
                        <label class="form-check form-switch form-check-custom form-check-solid pulse pulse-success" for="kt_user_menu_dark_mode_toggle">
                            <input class="form-check-input w-30px h-20px" type="checkbox" value="1" name="mode" id="kt_user_menu_dark_mode_toggle" data-kt-url="#" />
                            <span class="pulse-ring ms-n1"></span>
                            <span class="form-check-label text-gray-600 fs-7">Dark Mode</span>
                        </label>
                    </div>
                </div>

            </div>
        </div>
    </div>