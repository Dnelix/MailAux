    <div class="modal fade" id="modal_new_customer" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="las la-times fs-2x"></i>
                    </div>
                </div>
                
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <form id="modal_new_customer_form" class="form #" action="#">
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Add a Customer</h1>
                            <div class="text-muted fw-bold fs-5">Enter the customer details below. It's that simple.</div>
                        </div>

                        <input type="hidden" name="tailor" value="<?= $loguserid; ?>" />
                        
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2 required"> Full Name</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Enter customer name" name="fullname" />
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2"> Phone Number</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Enter phone number" name="phone" />
                        </div>
                        <div class="d-flex flex-column mb-10 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2"> Email Address</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Enter customer email" name="email" />
                        </div>
                        
                        <div class="text-center">
                            <button type="reset" id="modal_new_customer_cancel" class="btn btn-light me-3">Cancel</button>
                            <button type="submit" id="modal_new_customer_submit" class="btn btn-primary">
                                <?= displayLoadingIcon('Add Customer'); ?>
                            </button>
                        </div>
                    </form>

                    <div id="new_customer_success" class="d-none">
                        <div class="mb-13 text-center">
                            <h1 class="mb-3" id="suc">Success!</h1>
                            <div class="text-muted fw-bold fs-5">Customer has been created successfully.</div>
                        </div>
                        <div class="mb-10 text-center">
                            <img src="assets/media/illustrations/sigma-1/17.png" alt="" class="mw-50 mb-10 mh-250px">
                            <div class="text-muted fs-5">Click Continue to add measurements for this customer or exit and add more customers.</div>
                        </div>
                        <div class="text-center">
                            <button type="button" id="create_another" class="btn btn-light me-3">Create another customer</button>
                            <button type="button" id="add_measurement" class="btn btn-primary">Continue to measurements</button>
                            <!--button type="button" id="add_measurement" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_add_measurements">Continue to measurements</button-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>