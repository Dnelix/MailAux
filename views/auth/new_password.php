  <?php
    if(!isset($_GET['usr']) || !isset($_GET['i'])){
      echo '<script>window.location.href="'.$reset_link.'";</script>';
      exit();
    }
    $usr  = $_GET['usr'];
    $i    = $_GET['i'];
  ?>

      <div class="flex-row-fluid d-flex flex-center justfiy-content-xl-first p-10">
        <div class="d-flex flex-center p-15 shadow-sm bg-body rounded w-100 w-md-550px mx-auto ms-xl-20">

          <form class="form" novalidate="novalidate" id="new_password_form" data-redirect-url="<?= $login_link; ?>">
            <div class="text-center mb-10">
              <h1 class="text-dark mb-3" id="logtext">Hi <?= $usr; ?>,</h1>
              <div class="text-gray-400 fw-bold fs-4"> Choose a new password for your account. Try something memorable.</div>
            </div>

            <input type="hidden" name="usr" value="<?= $usr; ?>" />
            <input type="hidden" name="i" value="<?= $i; ?>" />

            <!--begin::password group-->
            <div class="mb-10 fv-row" data-kt-password-meter="true">
                <div class="mb-1">
                    <label class="form-label fw-bolder text-dark fs-6">New Password</label>
                    
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
            
            <div class="fv-row mb-5">
                <label class="form-label fw-bolder text-dark fs-6">Confirm Password</label>
                <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="confirmpassword" autocomplete="off" />
            </div>
            
            <div class="text-center pb-lg-0 pb-8">
              <button type="submit" id="new_password_submit" class="btn btn-lg btn-primary w-100 mb-5"> <?= displayLoadingBtn('Reset my password'); ?> </button>
            </div>
          </form>
        </div>
      </div>