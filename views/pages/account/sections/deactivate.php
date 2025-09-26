<div class="card">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#account_deactivate" aria-expanded="true" aria-controls="account_deactivate">
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">Deactivate Account</h3>
        </div>
    </div>
    <div id="kt_account_settings_deactivate" class="collapse show">
        <form id="account_deactivate_form" class="form">
            <div class="card-body border-top p-9">
            
                <input type="hidden" name="userid" value="<?= $loguserid; ?>"/>

                <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">
                    <span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                            <rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="currentColor" />
                            <rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor" />
                        </svg>
                    </span>
                    <div class="d-flex flex-stack flex-grow-1">
                        <div class="fw-bold">
                            <h4 class="text-gray-900 fw-bolder">You Are Deactivating Your Account</h4>
                            <div class="fs-6 text-gray-700">For additional security, you are required to confirm this action by checking the box below. </div>
                        </div>
                    </div>
                </div>
                <div class="form-check form-check-solid fv-row">
                    <input name="deactivate" class="form-check-input" type="checkbox" value="true" id="deactivate" />
                    <label class="form-check-label fw-bold ps-2 fs-6" for="deactivate">I confirm my account deactivation</label>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button id="account_deactivate_submit" type="submit" class="btn btn-danger fw-bold">
                    <?= displayLoadingBtn('Deactivate Account'); ?>
                </button>
            </div>
        </form>
    </div>
</div>