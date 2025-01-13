<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="275px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_toggle">
    
    <div class="app-sidebar-wrapper py-8 py-lg-10" id="kt_app_sidebar_wrapper">
        <div id="kt_app_sidebar_nav_wrapper" class="d-flex flex-column px-8 px-lg-10 hover-scroll-y" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="{default: false, lg: '#kt_app_header'}" data-kt-scroll-offset="{default: '10px', lg: '40px'}">
            <?php
                include_once("sidebar/sidehead.php");
                include_once("sidebar/sidetracker.php");
            ?>

            <div class="mb-0">
                <h3 class="text-gray-800 fw-bold mb-8">Menu</h3>

                <div class="row g-5" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                    <div class="col-6">
                        <a href="dashboard" class="btn btn-icon btn-outline btn-bg-light btn-active-light-primary btn-flex flex-column flex-center w-100px h-100px border-gray-200 bg-light-primary" data-kt-button="true">
                            <span class="mb-2"><i class="fa fa-calendar fs-1"></i></span>
                            <span class="fs-7 fw-bold">Home</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="contacts" class="btn btn-icon btn-outline btn-bg-light btn-active-light-primary btn-flex flex-column flex-center w-100px h-100px border-gray-200 bg-light-success" data-kt-button="true">
                            <span class="mb-2"><i class="fa fa-book fs-1"></i></span>
                            <span class="fs-7 fw-bold">Contacts</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="campaigns" class="btn btn-icon btn-outline btn-bg-light btn-active-light-primary btn-flex flex-column flex-center w-100px h-100px border-gray-200 bg-light-danger" data-kt-button="true">
                            <span class="mb-2"><i class="fa fa-wifi fs-1"></i></span>
                            <span class="fs-7 fw-bold">Campaigns</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="templates" class="btn btn-icon btn-outline btn-bg-light btn-active-light-primary btn-flex flex-column flex-center w-100px h-100px border-gray-200 bg-light-warning" data-kt-button="true">
                            <span class="mb-2"><i class="fa fa-medal fs-1"></i></span>
                            <span class="fs-7 fw-bold">Templates</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="account" class="btn btn-icon btn-outline btn-bg-light btn-active-light-primary btn-flex flex-column flex-center w-100px h-100px border-gray-200 bg-light-info" data-kt-button="true">
                            <span class="mb-2"><i class="fa fa-cog fs-1"></i></span>
                            <span class="fs-7 fw-bold">Account</span>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="new_email" class="btn btn-icon btn-outline btn-bg-light btn-active-light-primary btn-flex flex-column flex-center w-100px h-100px active border-primary border-dashed" data-kt-button="true">
                            <span class="mb-2"><i class="fa fa-plus fs-1"></i></span>
                            <span class="fs-7 fw-bold">New Email</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
