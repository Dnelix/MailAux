<div class="modal fade" id="upload-contacts" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <form class="form" onsubmit="return false;" id="upload_contacts_form">
                <div class="modal-header">
                    <h2 class="fw-bold">Upload files</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="fa fa-times "></i>
                    </div>
                </div>

                <div class="modal-body pt-10 pb-15 px-lg-17">
                    <div class="form-group row">
                        <div class="col-lg-2 col-form-label text-center btn btn-outline">
                            <i class="fa fa-download fa-2x"></i><br/><br/> 
                            <a href="<?= $c_website.'models/templates/download_manager.php';?>" download target="_blank"> Download Template </a>
                        </div>
                        
                        <div class="col-lg-10">
                            <div class="dropzone dropzone-queue mb-2" id="dropzonejs_contacts">
                                <div class="dropzone-panel mb-lg-0 mb-2">
                                    <a class="dropzone-select btn btn-sm btn-primary me-2">Attach file</a>
                                    <a class="dropzone-upload btn btn-sm btn-light-primary me-2" id="uploadFileBtn" onclick="uploadFile()">
                                        <?= displayLoadingBtn('Upload File'); ?>
                                    </a>
                                    <a class="dropzone-remove-all btn btn-sm btn-light-primary">Clear all</a>
                                </div>

                                <div class="dropzone-items wm-200px">
                                    <div class="dropzone-item" style="display:none">
                                        <!--begin::File-->
                                        <div class="dropzone-file">
                                            <div class="dropzone-filename" title="some_image_file_name.jpg">
                                                <span data-dz-name>some_image_file_name.jpg</span>
                                                <strong>(<span data-dz-size>340kb</span>)</strong>
                                            </div>

                                            <div class="dropzone-error" data-dz-errormessage></div>
                                        </div>
                                        
                                        <div class="dropzone-progress">
                                            <div class="progress">
                                                <div
                                                    class="progress-bar bg-primary"
                                                    role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="dropzone-toolbar">
                                            <span class="dropzone-start"><i class="bi bi-play-fill fs-3"></i></span>
                                            <span class="dropzone-cancel" data-dz-remove style="display: none;"><i class="bi bi-x fs-3"></i></span>
                                            <span class="dropzone-delete" data-dz-remove><i class="bi bi-x fs-1"></i></span>
                                        </div>
                                        <!--end::Toolbar-->
                                    </div>
                                </div>
                            </div>
                                            
                            <span class="form-text text-muted">Max file size is 1MB and max number of files is 2.</span>

                        </div>

                        <input type="hidden" name="uploadURL" id="uploadURL" value="<?= $appURL.'controllers/contacts.php?upload&uid='.$loguserid;?>" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function uploadFile(){
        submitButtonState('loading', '#uploadFileBtn');
        // rest of the processing script in dropzoneinit.js
    }
</script>