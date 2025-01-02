                <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                    <div class="text-center mb-13">
                        <h1 class="mb-3">Browse Tailors</h1>
                        <div class="text-muted fw-bold fs-5">Select from your list of tailors or go to the 
                        <a href="tailors" class="link-primary fw-bolder">Tailors Directory</a>.</div>
                    </div>
                    <div class="mb-15">
                        <?php if(empty($myTailors)){ ?>

                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <div class="ms-6">
                                        <div class="alert alert-danger">
                                            <h3 class="mb-1 text-dark">You don't have any tailors yet!</h3> 
                                            <span>To initiate a project, ask your tailor to share a link with you.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } else { ?>

                        <div class="mh-375px scroll-y me-n7 pe-7">
                            <?php
                                foreach ($myTailors as $tailor){
                                    $name = ($tailor->fullname !== null) ? $tailor->fullname : $tailor->username;
                                    $t_init = getInitials($name);
                                    $status = ($tailor->active==1) ? 'Active':'Inactive';
                            ?>

                            <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                <div class="d-flex align-items-center">
                                    <?= showCustomerIcon($tailor->id, $t_init); ?>
                                    <div class="ms-6">
                                        <a href="add_project?cid=<?= $tailor->id; ?>" class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary"><?= $name; ?> 
                                        <span class="badge badge-light fs-8 fw-bold ms-2"><?= $status; ?></span></a>
                                        <div class="fw-bold text-muted"><?= $tailor->email; ?></div>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="text-end">
                                        <a href="add_project?tid=<?= $tailor->id; ?>" class="btn btn-icon btn-primary btn-active-color-dark btn-sm me-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="" data-bs-original-title="Start new project">
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
                    
                </div>