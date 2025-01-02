    <div class="flex-row-fluid d-flex flex-center justfiy-content-xl-first p-10">
      <div class="d-flex flex-center p-15 shadow-sm bg-body rounded w-100 w-md-550px mx-auto ms-xl-20">

        <form class="form" novalidate="novalidate" id="password_reset_form">
          <div class="text-center mb-10">
            <h1 class="text-dark mb-3" id="logtext">Did you forget your password?</h1>
            <div class="text-gray-600 fw-light fs-4">Not to worry, we all do silly things. 
              <br/>Provide your username or email below and we will send you a reset link if it matches a record on our system
            </div>
          </div>

          <div class="fv-row mb-10">
            <label class="form-label fw-bolder text-dark fs-6">Email / Username</label>
            <input class="form-control form-control-solid" type="email" placeholder="" name="email" autoComplete="on" />
          </div>
        
          
          <div class="text-center pb-lg-0 pb-8">
            <button type="submit" id="password_reset_submit" class="btn btn-lg btn-primary w-100 mb-5"> <?= displayLoadingBtn('Reset My pasword'); ?> </button>
          </div>
        </form>
      </div>
    </div>