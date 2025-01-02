                <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                    <div class="text-center mb-13">
                        <h1 class="mb-3">Browse Users</h1>
                        <div class="text-muted fw-bold fs-5">Select a customer from the list or go to the 
                        <a href="customers" class="link-primary fw-bolder">Customers Directory</a>.</div>
                    </div>
                    <div class="mb-15">
                        <?php if(empty($customerList)){ ?>

                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="ms-6">
                                        <div class="alert alert-danger">
                                            <h3 class="mb-1 text-dark">You don't have any customers yet!</h3> 
                                            <span>To get started with customer projects, close this window and create a customer first.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } else { ?>

                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <?php
                                foreach ($customerList as $customer){
                                    $name = ($customer->fullname !== null) ? $customer->fullname : $customer->username;
                                    $c_init = getInitials($name);
                                    $status = ($customer->active==1) ? 'Active':'Inactive';
                            ?>

                            <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <?= showCustomerIcon($customer->id, $c_init); ?>
                                    <div class="ms-6">
                                        <a href="add_project?cid=<?= $customer->id; ?>" class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary"><?= $name; ?> 
                                        <span class="badge badge-light fs-8 fw-bold ms-2"><?= $status; ?></span></a>
                                        <div class="fw-bold text-muted"><?= $customer->email; ?></div>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="text-end">
                                        <a href="add_project?cid=<?= $customer->id; ?>" class="btn btn-icon btn-primary btn-active-color-dark btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-original-title="Start new project">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <?php
                                }}
                            ?>
                            
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="fw-bold">
                            <label class="fs-6">Or create a personal <?= strtolower($alt_job); ?></label>
                            <div class="fs-7 text-muted">Use this option if the <?= strtolower($alt_job); ?> is not for a specific client </div>
                        </div>
                        <a href="add_project?cid=<?= $loguserid; ?>" class="btn btn-danger btn-sm">Personal <?= $alt_job; ?></a>
                    </div>
                </div>