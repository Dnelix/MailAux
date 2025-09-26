<div class="card mb-5 mb-xl-10">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#account_profile_details" aria-expanded="true" aria-controls="account_profile_details">
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">Profile Details</h3>
        </div>
    </div>
    <div id="account_profile_details" class="collapse show">
        <form id="profileForm" class="form">
            <div class="card-body border-top p-9">
                <!--div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Avatar</label>
                    <div class="col-lg-8">
                        <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                            <div class="image-input-wrapper w-125px h-125px" style="background-image: url(assets/media/avatars/300-1.jpg)"></div>
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                <i class="bi bi-pencil-fill fs-7"></i>
                                <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" name="avatar_remove" />
                            </label>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                        </div>
                        <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                    </div>
                </div-->

                <input type="hidden" name="userid" value="<?= $loguserid; ?>"/>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Avatar</label>
                    <div class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                        <?= displayUserIcon(getInitials($logName), $loguserid, 'large'); ?>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Username</label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="username" class="form-control form-control-lg form-control-solid" placeholder="Username" value="<?= $user->username; ?>" disabled />
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Full Name</label>
                    <div class="col-lg-8 fv-row">
                        <input type="text" name="fullname" class="form-control form-control-lg form-control-solid" placeholder="Full name" value="<?= $user->fullname; ?>" />
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Mobile Phone</label>
                    <div class="col-lg-8 fv-row">
                        <input type="tel" name="phone" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="<?= $user->phone; ?>" />
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6"> Status </label>
                    <div class="col-lg-8 fv-row">
                        <?php if($user->active == 1){?><span class="btn btn-sm btn-light-success fw-bolder ms-2 fs-8 py-1 px-3">ACTIVE</span>
                        <?php } else {?><span class="btn btn-sm btn-light-gray fw-bolder ms-2 fs-8 py-1 px-3">INACTIVE</span><?php } ?>
                    </div>
                </div>

                <div class="row mb-6">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Communication channels</label>
                    <div class="col-lg-8 fv-row">
                        <div class="d-flex align-items-center mt-3">
                            <label class="form-check form-check-inline form-check-solid me-5">
                                <input class="form-check-input" name="communication" type="checkbox" value="Email" checked/>
                                <span class="fw-bold ps-2 fs-6">Email</span>
                            </label>
                            <label class="form-check form-check-inline form-check-solid">
                                <input class="form-check-input" name="communication" type="checkbox" value="Phone" disabled/>
                                <span class="fw-bold ps-2 fs-6">Phone</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!--div class="row mb-0">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Allow Marketing</label>
                    <div class="col-lg-8 d-flex align-items-center">
                        <div class="form-check form-check-solid form-switch fv-row">
                            <input class="form-check-input w-45px h-30px" type="checkbox" id="allowmarketing" checked="checked" />
                            <label class="form-check-label" for="allowmarketing"></label>
                        </div>
                    </div>
                </div-->

            </div>
            
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard</button>
                <button type="submit" class="btn btn-primary" id="profileBtn" onclick="updateProfile()">
                    <?= displayLoadingBtn('Save Changes'); ?>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateProfile(){
        var web = '<?= $appURL; ?>';
        var userid = '<?= $loguserid; ?>';
        var url = web+"controllers/users.php?userid="+userid;
        var formData = extractFormData('#profileForm');
        var btn = "#profileBtn";

        AJAXcall("PATCH", url, btn, formData, (r)=>{ handleResponseMsg(r, 'confirmreload'); });
    }
</script>