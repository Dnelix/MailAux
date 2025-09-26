<?php
$email = '';
if(isset($_GET['uid'])){
  $email = getuserDataById('email', $_GET['uid']);
}

?>

    <div class="flex-row-fluid d-flex flex-center justfiy-content-xl-first p-10">
        <div class="d-flex flex-center p-15 shadow-sm bg-body rounded w-100 w-md-550px mx-auto ms-xl-20">

          <form class="form" novalidate="novalidate" id="sign_in_form" data-kt-redirect-url="dashboard" onsubmit="return false;">
            <div class="text-center mb-10">
              <h1 class="text-dark mb-3" id="logtext">Login to start sending mails</h1>
              <div class="text-gray-400 fw-bold fs-4">Don't have an account? 
              <a href="?signup" class="link-primary fw-bolder"> Signup here</a>.</div>
            </div>

            <div class="fv-row mb-10">
              <label class="form-label fw-bolder text-dark fs-6 required">Email/Username</label>
              <input class="form-control form-control-solid" type="email" value="<?= $email; ?>" name="email" autoComplete="on" />
            </div>
          
            <div class="fv-row mb-10">
              <div class="d-flex flex-stack mb-2">
                <label class="form-label fw-bolder text-dark fs-6 mb-0 required">Password</label>
                <a href="?password_reset" class="link-primary fs-6 fw-bolder">Forgot Password?</a>
              </div>
              <div class="position-relative mb-3">
                <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="password" autocomplete="off" />
                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" id="showHide">
                    <i class="bi bi-eye-slash fs-2"></i>
                    <i class="bi bi-eye fs-2 d-none"></i>
                </span>
              </div>
            </div>

            <div class="fv-row mb-10">
                <label class="form-check form-check-custom form-check-solid form-check-inline">
                    <input class="form-check-input" type="checkbox" name="keep" value="1" />
                    <span class="form-check-label fw-bold text-gray-700 fs-6">Keep me signed in.</span>
                </label>
            </div>
            
            <div class="text-center pb-lg-0 pb-8">
              <button type="submit" id="sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                <?= displayLoadingBtn('Login Here'); ?>
              </button>
            </div>
          </form>
        </div>
      </div>