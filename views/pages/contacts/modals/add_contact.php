<div class="modal fade" tabindex="-1" id="add-contact">
    <div class="modal-dialog modal-dialog-centered modal-lg mw-500px">
        <div class="modal-content rounded">
            <div class="modal-header pb-0 border-0 justify-content-end">
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></div>
            </div>

            <form id="addContactForm" class="form" onsubmit="return false;">

                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Add a Contact</h1>
                        <div class="text-muted fw-semibold fs-5">
                            Complete the form below to add a contact.
                        </div>
                    </div>

                    <div class="d-flex flex-column mb-8">
                        <label class="required fs-6 fw-semibold mb-2">Add to group</label>
                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#add-contact" data-hide-search="true" name="group">
                            <option value="" selected>All Contacts</option>
                            <?php foreach ($g_data as $g): ?>
                                <option value="<?= $g->id; ?>" ><?= $g->group_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="required fs-6 fw-semibold mb-2">Email Address</label>
                        <input type="text" class="form-control form-control-solid" placeholder="Enter Email Address" name="email">
                    </div>

                    <div class="row g-9 mb-8" data-select2-id="select2-data-131-jn1f">
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">First Name</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Enter First Name" name="first_name">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Last Name</label>
                            <input type="text" class="form-control form-control-solid" placeholder="Enter Last Name" name="last_name">
                        </div>
                    </div>

                </div>
                
                <div class="modal-footer px-10 px-lg-15">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="addContactBtn" class="btn btn-primary" onclick="addContact()"><?= displayLoadingBtn('Add Contact'); ?></button>
                </div>

                <input type="hidden" name="created" value="<?= date($mysql_dateformat); ?>" />

            </form>

        </div>
    </div>
</div>

<script>
    function addContact(){
        var web = '<?= $appURL; ?>';
        var userid = '<?= $loguserid; ?>';
        var url = web+"controllers/contacts.php?uid="+userid;
        var formData = extractFormData('#addContactForm');
        var btn = "#addContactBtn";

        AJAXcall("POST", url, btn, formData, (r)=>{ handleResponseMsg(r, 'confirmreload'); });
    }

</script>