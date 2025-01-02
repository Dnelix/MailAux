<?php
if (!isset($customers)){
    $customers = retrieveDataFrom($c_website.'controllers/customers.php?tailor='.$loguserid) -> data;
}
$customerList = (isset($customers->customerlist) ? $customers->customerlist : null);

?>

   <div class="modal fade" id="modal_new_project" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <?= $svg_exiticon; ?>
                    </div>
                </div>
                
                <?php 
                    if ($userdata->role === "business") {
                        include_once('new_project/for_business.php');
                    } else if ($userdata->role === "customer") {
                        include_once('new_project/for_customer.php');
                    }
                ?>
                
            </div>
        </div>
    </div>