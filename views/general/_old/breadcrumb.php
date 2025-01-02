
    <div class="toolbar py-5 py-lg-15" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <!--begin::Title-->
                <h1 class="d-flex text-white fw-bolder my-1 fs-3"><?= strToUpper($pageTitle);?></h1>
                <!--breadcrumbs-->
                <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                    <li class="breadcrumb-item text-white opacity-75">
                        <a href="dashboard" class="text-white text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-white opacity-75"><?= ucwords($curPage);?></li>
                    <?php if($curSubpage != '' || $curSubpage != null){ ?>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-white opacity-75 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-white opacity-75"><?= $curSubpage; ?></li>
                    <?php } ?>
                </ul>
            </div>
            <!--end::Page title-->

            <?php if ($logrole === 'business'){ ?>
            <!--begin::Actions-->
            <div class="d-flex align-items-center py-3 py-md-1">
                <div class="me-4">
                    <a href="#" class="btn btn-custom btn-active-white btn-flex btn-color-white btn-active-color-primary fw-bolder" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <i class="fa fa-plus"></i>New Customer</a>
                    <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_62b0469e5aa26">
                        <div class="px-7 py-5">
                            <div class="fs-5 text-dark fw-bolder">Choose an option</div>
                        </div>
                        <div class="separator border-gray-200"></div>
                        <div class="px-7 py-5">

                                <div data-kt-buttons="true">
                                    <div class="mb-10" id="new_customer_menu_form">
                                        <div class="d-flex fv-row">
                                            <div class="form-check form-check-custom form-check-solid" data-bs-toggle="modal" data-bs-target="#modal_new_customer">
                                                <!-- <input class="form-check-input me-3" name="cust_option" type="radio" value="0" id="option_0" checked="checked"> -->
                                                <label class="form-check-label" for="option_0">
                                                    <div class="fw-bolder text-gray-800">Create Manually</div>
                                                    <div class="text-gray-600">Complete a simple form to add a customer</div>
                                                </label>
                                                <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-check" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-10">
                                        <div class="d-flex fv-row">
                                            <div class="form-check form-check-custom form-check-solid" data-bs-toggle="modal" data-bs-target="#modal_share_link">
                                                <label class="form-check-label" for="option_1">
                                                    <div class="fw-bolder text-gray-800">Share link</div>
                                                    <div class="text-gray-600">Send a link to your customers to provide their measurements</div>
                                                </label>
                                                <button type="button" class="btn btn-sm btn-danger"><i class="fa fa-check" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-10">
                                        <div class="d-flex fv-row">
                                            <div class="form-check form-check-custom form-check-solid">
                                                <label class="form-check-label" for="option_2">
                                                    <div class="fw-bolder text-gray-800">Bulk Upload</div>
                                                    <div class="text-gray-600">Simply upload your existing customer database via CSV</div>
                                                </label>
                                                <button type="button" class="btn btn-sm btn-light" ><i class="fa fa-check" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <!--div class="d-flex justify-content-end">
                                        <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
                                        <button type="submit" class="btn btn-sm btn-primary" id="new_cust_opt_submit">Proceed</button>
                                    </div-->
                                </div>
                        </div>
                    </div>
                </div>

                <!--a href="#" class="btn btn-bg-white btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#modal_new_project">
                    <i class="fa fa-plus"></i>New <?//= $alt_job; ?>
                </a-->

            </div>
            <!--end::Actions-->
            <?php } ?>
        </div>
    </div>