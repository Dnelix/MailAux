    <div class="flex-row-fluid d-flex flex-center justfiy-content-xl-first p-10">
        <div class="d-flex flex-center p-15 shadow-sm bg-body rounded w-100 w-md-550px mx-auto ms-xl-20">

          <form class="form" novalidate="novalidate" id="sign_up_form" data-kt-redirect-url="<?= $login_link; ?>">
            <div class="text-center mb-10">
              <h1 class="text-dark mb-3" id="logtext">Create an Account</h1>
              <div class="text-gray-400 fw-bold fs-4">Already have an account? 
              <a href="<?= $login_link; ?>" class="link-primary fw-bolder"> Login here</a>.</div>
            </div>

            <!--begin::Input group-->
            <div class="row fv-row mb-7">

                <div class="col-xl-6">
                    <label class="form-label fw-bolder text-dark fs-6 required">Business Name</label>
                    <input class="form-control form-control-lg form-control-solid" type="text" placeholder="" name="biz-name" autocomplete="on" />
                </div>
                <div class="col-xl-6">
                    <label class="form-label fw-bolder text-dark fs-6">Phone Number</label>
                    <input class="form-control form-control-lg form-control-solid" type="text" placeholder="" name="phone-number" autocomplete="on" />
                </div>

            </div>
            <!--end::Input group-->
            
            <div class="fv-row mb-7">
                <label class="form-label fw-bolder text-dark fs-6 required">Email</label>
                <input class="form-control form-control-lg form-control-solid" type="email" placeholder="" name="email" autocomplete="on" />
            </div>

            <!--begin::password group-->
            <div class="mb-10 fv-row" data-kt-password-meter="true">
                <div class="mb-1">
                    <label class="form-label fw-bolder text-dark fs-6 required">Password</label>
                    
                    <div class="position-relative mb-3">
                        <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="password" autocomplete="off" />
                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                            <i class="bi bi-eye-slash fs-2"></i>
                            <i class="bi bi-eye fs-2 d-none"></i>
                        </span>
                    </div>

                    <!--begin::Meter-->
                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                        <div class="flex-grow-1 bg-secondary bg-active-danger rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-warning rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                    </div>
                    <!--end::Meter-->
                </div>
                
                <div class="text-muted">Use 5 or more characters with a mix of letters, numbers &amp; symbols.</div>
            </div>
            <!--end::password group=-->
            
            <!--div class="fv-row mb-5">
                <label class="form-label fw-bolder text-dark fs-6">Confirm Password</label>
                <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="confirm-password" autocomplete="off" />
            </div-->
            
            <div class="fv-row mb-10">
                <label class="form-check form-check-custom form-check-solid form-check-inline">
                    <input class="form-check-input" type="checkbox" name="toc" value="1" />
                    <span class="form-check-label fw-bold text-gray-700 fs-6">I Agree with <?= $company.'\'s'; ?> 
                    <a href="<?= $terms_link; ?>" class="ms-1 link-primary"> Terms and conditions</a>.</span>
                </label>
            </div>
            
            <!--begin::Actions-->
            <div class="text-center">
                <button type="button" id="sign_up_submit" class="btn btn-lg btn-primary"><?= displayLoadingBtn('Sign Up'); ?></button>
            </div>
            <!--end::Actions-->

          </form>
        </div>
    </div>