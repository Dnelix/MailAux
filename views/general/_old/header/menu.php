    <div class="d-flex align-items-stretch" id="kt_header_nav">
        <div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
            <!--begin::Menu-->
            <div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch" id="#kt_header_menu" data-kt-menu="true">
                <!--div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item here show menu-lg-down-accordion me-lg-1"-->
                <!-- .show and .here are classes used to identify the active menu -->
                
                <?php if ($logrole === 'business'){ ?>
                    <div class="menu-item <?= ($curPage=='dashboard') ? 'here show':'';?> menu-lg-down-accordion me-lg-1" >
                        <a class="menu-link py-3" href="dashboard">
                            <?= ($curPage=='dashboard') ? '<span class="menu-icon"><i class="fa fa-home"></i></span>' : ''; ?>
                            <span class="menu-title">Home</span>
                        </a>
                        <!-- submenu --
                        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                            <div class="hover-scroll-overlay-y mh-300px">
                                <div class="menu-item">
                                    <a class="menu-link active py-3" href="index-2.html">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Multipurpose</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="landing.html">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Landing</span>
                                    </a>
                                </div>
                            </div>
                        </div-->
                    </div>

                    <div class="menu-item <?= ($curPage=='customers') ? 'here show':'';?> menu-lg-down-accordion me-lg-1" >
                        <a class="menu-link py-3" href="customers">
                            <?= ($curPage=='customers') ? '<span class="menu-icon"><i class="fa fa-users"></i></span>' : ''; ?>
                            <span class="menu-title">My Customers</span>
                        </a>
                    </div>

                    <div class="menu-item <?= ($curPage=='projects') ? 'here show':'';?> menu-lg-down-accordion me-lg-1" >
                        <a class="menu-link py-3" href="projects">
                            <?= ($curPage=='projects') ? '<span class="menu-icon"><i class="fa fa-briefcase"></i></span>' : ''; ?>
                            <span class="menu-title"><?= $alt_job.'s'; ?></span>
                        </a>
                    </div>

                    <div class="menu-item <?= ($curPage=='profile') ? 'here show':'';?> menu-lg-down-accordion me-lg-1" >
                        <a class="menu-link py-3" href="profile?page=business">
                            <?= ($curPage=='profile') ? '<span class="menu-icon"><i class="fa fa-user"></i></span>' : ''; ?>
                            <span class="menu-title"> Business Profile</span>
                        </a>
                    </div>

                <?php } else { ?>

                    <div class="menu-item <?= ($curPage=='measurements') ? 'here show':'';?> menu-lg-down-accordion me-lg-1" >
                        <a class="menu-link py-3" href="measurements">
                            <?= ($curPage=='measurements') ? '<span class="menu-icon"><i class="fa fa-users"></i></span>' : ''; ?>
                            <span class="menu-title">Measurements</span>
                        </a>
                    </div>

                    <div class="menu-item <?= ($curPage=='projects') ? 'here show':'';?> menu-lg-down-accordion me-lg-1" >
                        <a class="menu-link py-3" href="projects">
                            <?= ($curPage=='projects') ? '<span class="menu-icon"><i class="fa fa-briefcase"></i></span>' : ''; ?>
                            <span class="menu-title"><?= $alt_job.'s'; ?></span>
                        </a>
                    </div>

                    <div class="menu-item <?= ($curPage=='profile') ? 'here show':'';?> menu-lg-down-accordion me-lg-1" >
                        <a class="menu-link py-3" href="profile?page=business">
                            <?= ($curPage=='profile') ? '<span class="menu-icon"><i class="fa fa-user"></i></span>' : ''; ?>
                            <span class="menu-title"> My Profile</span>
                        </a>
                    </div>

                <?php } ?>

            </div>
            <!--end::Menu-->
        </div>
    </div>