<div class="card mb-5 mb-xl-10">
    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_signin_method">
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">Sign-in Methods</h3>
        </div>
    </div>
    <div id="kt_account_settings_signin_method" class="collapse show">
        <div class="card-body border-top p-9">
            <!-- Begin username section -->
            <div class="d-flex flex-wrap align-items-center">
                <div id="kt_signin_username">
                    <div class="fs-6 fw-bolder mb-1">Username</div>
                    <div class="fw-bold text-gray-600"><?= $user->username; ?></div>
                </div>
                <div id="kt_signin_username_edit" class="flex-row-fluid d-none">

                    <form id="kt_signin_change_username" class="form" novalidate="novalidate">
                        <div class="row mb-6">
                            
                            <input type="hidden" name="userid" value="<?= $loguserid; ?>"/>

                            <div class="col-lg-6 mb-4 mb-lg-0">
                                <div class="fv-row mb-0">
                                    <label for="username" class="form-label fs-6 fw-bolder mb-3">Enter New Username</label>
                                    <input type="text" class="form-control form-control-lg form-control-solid" id="username" placeholder="Username" name="username" value="<?= $user->username; ?>" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="fv-row mb-0">
                                    <label for="confirmuserpassword" class="form-label fs-6 fw-bolder mb-3">Confirm Password</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="confirmuserpassword" id="confirmuserpassword" />
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button id="kt_uname_submit" type="button" class="btn btn-primary me-2 px-6">
                                <?= displayLoadingBtn('Update Username'); ?>
                            </button>
                            <button id="kt_uname_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
                        </div>
                    </form>

                </div>
                <div id="kt_signin_user_button" class="ms-auto">
                    <button class="btn btn-light btn-active-light-primary">Change Username</button>
                </div>
            </div>

            <div class="separator separator-dashed my-6"></div>

            <!-- Begin email section -->
            <div class="d-flex flex-wrap align-items-center">
                <div id="kt_signin_email">
                    <div class="fs-6 fw-bolder mb-1">Email Address</div>
                    <div class="fw-bold text-gray-600"><?= $user->email; ?></div>
                </div>
                <div id="kt_signin_email_edit" class="flex-row-fluid d-none">

                    <form id="kt_signin_change_email" class="form" novalidate="novalidate">
                        <div class="row mb-6">
                            
                            <input type="hidden" name="userid" value="<?= $loguserid; ?>"/>

                            <div class="col-lg-6 mb-4 mb-lg-0">
                                <div class="fv-row mb-0">
                                    <label for="emailaddress" class="form-label fs-6 fw-bolder mb-3">Enter New Email Address</label>
                                    <input type="email" class="form-control form-control-lg form-control-solid" id="emailaddress" placeholder="Email Address" name="emailaddress" value="<?= $user->email; ?>" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="fv-row mb-0">
                                    <label for="confirmemailpassword" class="form-label fs-6 fw-bolder mb-3">Confirm Password</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="confirmemailpassword" id="confirmemailpassword" />
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button id="kt_signin_submit" type="button" class="btn btn-primary me-2 px-6">
                                <?= displayLoadingBtn('Update Email'); ?>
                            </button>
                            <button id="kt_signin_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
                        </div>
                    </form>

                </div>
                <div id="kt_signin_email_button" class="ms-auto">
                    <button class="btn btn-light btn-active-light-primary">Change Email</button>
                </div>
            </div>
            
            <div class="separator separator-dashed my-6"></div>

            <!-- Begin password section -->
            <div class="d-flex flex-wrap align-items-center mb-10">
                <div id="kt_signin_password">
                    <div class="fs-6 fw-bolder mb-1">Password</div>
                    <div class="fw-bold text-gray-600">************</div>
                </div>
                <div id="kt_signin_password_edit" class="flex-row-fluid d-none">
                    
                    <form id="kt_signin_change_password" class="form" novalidate="novalidate">
                        <div class="row mb-1">

                            <input type="hidden" name="userid" value="<?= $loguserid; ?>"/>

                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="currentpassword" class="form-label fs-6 fw-bolder mb-3">Current Password</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="currentpassword" id="currentpassword" />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="newpassword" class="form-label fs-6 fw-bolder mb-3">New Password</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="newpassword" id="newpassword" />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="fv-row mb-0">
                                    <label for="confirmpassword" class="form-label fs-6 fw-bolder mb-3">Confirm New Password</label>
                                    <input type="password" class="form-control form-control-lg form-control-solid" name="confirmpassword" id="confirmpassword" />
                                </div>
                            </div>
                        </div>
                        <div class="form-text mb-5">Password must be at least 8 character and contain symbols</div>
                        <div class="d-flex">
                            <button id="kt_password_submit" type="button" class="btn btn-primary me-2 px-6">
                                <?= displayLoadingBtn('Update Password'); ?>
                            </button>
                            <button id="kt_password_cancel" type="button" class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
                        </div>
                    </form>
                </div>
                
                <div id="kt_signin_password_button" class="ms-auto">
                    <button class="btn btn-light btn-active-light-primary">Reset Password</button>
                </div>
            </div>

            <!--begin::Notice-->
            <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
                <span class="svg-icon svg-icon-2tx svg-icon-primary me-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="currentColor" />
                        <path d="M10.5606 11.3042L9.57283 10.3018C9.28174 10.0065 8.80522 10.0065 8.51412 10.3018C8.22897 10.5912 8.22897 11.0559 8.51412 11.3452L10.4182 13.2773C10.8099 13.6747 11.451 13.6747 11.8427 13.2773L15.4859 9.58051C15.771 9.29117 15.771 8.82648 15.4859 8.53714C15.1948 8.24176 14.7183 8.24176 14.4272 8.53714L11.7002 11.3042C11.3869 11.6221 10.874 11.6221 10.5606 11.3042Z" fill="currentColor" />
                    </svg>
                </span>
                <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                    <div class="mb-3 mb-md-0 fw-bold">
                        <h4 class="text-gray-900 fw-bolder">Secure Your Account</h4>
                        <div class="fs-6 text-gray-700 pe-7">Two-factor authentication adds an extra layer of security to your account. To log in, in addition you'll need to provide a 6 digit code</div>
                    </div>
                    <a href="#" class="btn btn-primary px-6 align-self-center text-nowrap" data-bs-toggle="modal" data-bs-target="#kt_modal_two_factor_authentication">Enable</a>
                </div>
            </div>
            <!--end::Notice-->
            
        </div>
    </div>
</div>