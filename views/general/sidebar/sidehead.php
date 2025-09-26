<div class="menu-content d-flex align-items-center px-3 mb-8 mb-lg-10">
    <div class="symbol symbol-50px me-5">
        <div class="symbol symbol-35px symbol-circle"><span class="symbol-label bg-light-info text-info fw-bold"><?= getInitials($logName); ?></span></div></div>
    <div class="d-flex flex-column">
        <div class="fw-bolder d-flex align-items-center fs-5"><?= ucwords($user->username); ?>
        <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2"><?= $userplan->plan; ?></span></div>
        <a href="#" class="fw-bold text-muted text-hover-primary fs-7"><?= $user->email; ?></a>
    </div>
</div>

<hr class="text-primary mb-8 mb-lg-10">