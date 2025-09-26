<!-- NAVIGATION -->

<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-400">

    <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 <?= ($path=='business') ? 'active':'';?>" href="account&sub=business">Business Details</a>
    </li>
    <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 <?= ($path=='profile') ? 'active':'';?>" href="account&sub=profile">Profile Details</a>
    </li>
    
    <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 <?= ($path=='security') ? 'active':'';?>" href="account&sub=security">Security & Alerts</a>
    </li>
    <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 <?= ($path=='plans') ? 'active':'';?>" href="account&sub=plans">My Plan</a>
    </li>
    <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 <?= ($path=='referrals') ? 'active':'';?>" href="account&sub=referrals">Referrals</a>
    </li>
</ul>