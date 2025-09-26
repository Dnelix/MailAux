<?php
$groups = retrieveDataFrom($c_website.'controllers/groups.php?countmembers&uid='.$loguserid);
$g_data = (isset($groups->data) ? $groups->data : []);

$contacts = retrieveDataFrom($c_website.'controllers/contacts.php?uid='.$loguserid);
$c_data = (isset($contacts->data) ? $contacts->data : []);
$c_count = count($c_data);
?>

    <div class="row g-7">
        <div class="card bg-white shadow-sm">
            <div class="card-body">
                <form onsubmit="return false;" id="campaign_init_form">
                    <label class="required fs-4 fw-bold mb-2">Please enter the email title/subject</label>
                    <div class="input-group mb-5">
                        <span class="input-group-text" id="basic-addon3"><i class="fa fa-pen fs-1"></i></span>
                        <input type="text" class="form-control-lg col-8" id="subject" placeholder="Introducing our new product">
                    </div>
                </form>
            </div>
        </div>
    
        <div class="card bg-white shadow-sm">
            <div class="card-body">
                <div class="rounded border p-10">
                    <div class="mb-5 hover-scroll-x ">
                        <div class="d-grid">
                            <ul class="nav nav-tabs flex-nowrap text-nowrap" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link btn btn-active-light-primary btn-color-gray-600 btn-active-color-primary rounded-bottom-0 active" data-bs-toggle="tab" href="#send_group" aria-selected="true" role="tab">
                                        <div class="fs-5 fw-bold">
                                            <i class="fa fa-users"></i>
                                            Send to Group
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link btn btn-active-light-primary btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#send_contacts" aria-selected="false" role="tab" tabindex="-1">
                                        <div class="fs-5 fw-bold">
                                            <i class="fa fa-book"></i>
                                            Send to Contacts
                                        </div>
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link  btn btn-active-light-primary btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#send_manual" aria-selected="false" tabindex="-1" role="tab">
                                        <div class="fs-5 fw-bold">
                                            <i class="fa fa-envelope"></i>
                                            Add Emails Manually
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <?php
                            include_once('new_email/send_group.php');
                            include_once('new_email/send_contacts.php');
                            include_once('new_email/send_manual.php');
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>