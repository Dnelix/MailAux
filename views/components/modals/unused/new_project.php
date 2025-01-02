<?php
if (!isset($customers)){
    $customers = retrieveDataFrom($c_website.'controllers/customers.php?tailor='.$loguserid) -> data;
}
$customerList = (isset($customers->customerlist) ? $customers->customerlist : null);

?>

   <div class="modal fade" id="modal_new_project" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="las la-times fs-2x"></i>
                    </div>
                </div>
                
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <form id="modal_new_project_form" class="form" action="#">
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Start a Project</h1>
                            <div class="text-muted fw-bold fs-5">Select a customer from the list or 
                                <a href="#" class="fw-bolder" data-bs-toggle="modal" data-bs-target="#modal_new_customer">Click Here</a> 
                                to add a new customer.
                            </div>
                        </div>
                        
                        <!--div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Select a Customer</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Start typing a customer name or phone number to search"></i>
                            </label>
                            <div class="me-6 my-1 bg-light-primary">
                                <select name="customers" data-control="select2" data-hide-search="false" class="form-select form-select-sm bg-light-primary border-body">
                                    <?php/*
                                        foreach ($customerList as $customer){
                                            $name = ($customer->fullname !== null) ? $customer->fullname : $customer->username;
                                            echo '<option value="'. $customer->id .'">'. $name .'</option>';
                                        }*/
                                    ?>
                                </select>
                            </div>
                        </div-->

                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Select a Customer</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Start typing a customer name or phone number to search"></i>
                            </label>
                            <input class="form-control form-control-solid" value="Important, Urgent" name="customer" />
                        </div>

                        <!--div class="fv-row mb-8">
                            <div class="col-md-12">
                                <div class="row fv-row">
                                    <div class="col-6 mb-10">
                                        <label class="required fs-6 fw-bold mb-2">Project Start Date</label>
                                        <div class="position-relative d-flex align-items-center">
                                            <?= $svg_calendericon; ?>
                                            <input class="form-control form-control-solid ps-12 flatpickr-input" placeholder="Set date and time" name="start_date" type="date">
                                        </div>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>

                                    <div class="col-6 mb-10">
                                        <label class="required fs-6 fw-bold mb-2">Project Due Date</label>
                                        <div class="position-relative d-flex align-items-center">
                                            <?= $svg_calendericon; ?>
                                            <input class="form-control form-control-solid ps-12 flatpickr-input" value="2023-03-10" name="due_date" type="date">
                                            <!-- input type date only accepts and returns value the format: yyyy-mm-dd ->
                                        </div>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                    </div>

                                </div>
                            </div>
                        </div-->
                        
                        <div class="text-center">
                            <button type="reset" id="modal_new_project_cancel" class="btn btn-light me-3">Cancel</button>
                            <button type="submit" id="modal_new_project_submit" class="btn btn-primary">
                                <?= displayLoadingIcon('Save and Proceed'); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>