
    <div class="modal fade" id="modal_lower_body" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-700px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal" onClick="reloadPage()">
                        <i class="las la-times fs-2x"></i>
                    </div>
                </div>
                
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <form id="modal_LB_form" class="form" onSubmit="return false">
                        <div class="mb-13 text-center">
                            <h2 class="fw-bolder text-center text-dark">Lower Body Measurements 
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="Your lower body measurements include measurements for trousers, skirts, shorts, etc. You can get someone else to measure you."></i>
                            </h2>
                            <div class="text-muted fs-7">
                                Check the tips for each field if you're unsure how to measure correctly.
                                <br/>All measurements MUST be done in <?= strtoupper($measureunit_text)." (".$measureunit.")"; ?>
                            </div>
                        </div>
                        
                        <div class="d-flex flex-column mb-8">
                            <div class="col-md-12">
                                <div class="row fv-row">
                                    <?php
                                        foreach ($LBmeasures as $data){
                                            $metadata = $data->metadata;
                                    ?>
                                            <div class="col-4 mb-10">
                                                <label class="fs-6 fw-bold form-label">
                                                    <?= $metadata->label . '(' . $measureunit . ')';  ?> 
                                                    <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="<?= $metadata->tooltip; ?>"></i>
                                                </label>
                                                <input type="number" name="<?= $metadata->name;  ?>" class="form-control form-control-lg form-control-solid" value="<?= $data->value; ?>" />
                                                <!--div class="form-text fs-8">Range:  <span class="text-primary"><?//= $data->sizes->$bs . $measureunit; ?></span> </div-->
                                            </div>

                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="reset" id="modal_LB_cancel" class="btn btn-light me-3">Reset values</button>
                            <button type="submit" id="modal_LB_submit" class="btn btn-primary" onClick="submitLB()">
                                <?= displayLoadingIcon('Save'); ?>
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

    <script>
        function submitLB(){
            var cid = '<?= $cid; ?>';
            var web = '<?= $c_website; ?>';

            var formID = "#modal_LB_form";
            var submitButton = document.querySelector('#modal_LB_submit');
            var type = "PATCH";
            var url = web+"controllers/measurements.php?customer="+cid;

            AJAXcall(formID, submitButton, type, url, null, (responseMsg)=>{handleResponseMsg(responseMsg, 'confirmreload');} );
        }
    </script>