<div class="modal fade" tabindex="-1" id="paste-contacts">
    <div class="modal-dialog modal-dialog-centered modal-lg mw-500px">
        <div class="modal-content rounded">
            <div class="modal-header pb-0 border-0 justify-content-end">
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></div>
            </div>

            <form id="pasteContactsForm" class="form" onsubmit="return false;">

                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Copy and Paste Contacts</h1>
                        <div class="text-muted fw-semibold fs-5">
                            Copy contact details and paste in the space below.
                        </div>
                    </div>

                    <div class="d-flex flex-column mb-8">
                        <label class="required fs-6 fw-semibold mb-2">Paste contacts here</label>
                        <textarea class="form-control form-control-solid" rows="3" name="contacts">john.greene@email.com; john.doe@email.com</textarea>
                    </div>

                    <div class="d-flex flex-column mb-8">
                        <label class="required fs-6 fw-semibold mb-2">Add contacts to group</label>
                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#paste-contacts" data-hide-search="true" name="group">
                            <option value="" selected>All Contacts</option>
                            <?php foreach ($g_data as $g): ?>
                                <option value="<?= $g->id; ?>" ><?= $g->group_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
                
                <div class="modal-footer px-10 px-lg-15">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="pasteContactsBtn" class="btn btn-primary" onclick="pasteContacts()"><?= displayLoadingBtn('Add All Contacts'); ?></button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
    function pasteContacts(){
        var web = '<?= $appURL; ?>';
        var userid = '<?= $loguserid; ?>';
        var url = web+"controllers/contacts.php?paste&uid="+userid;
        var formData = extractFormData('#pasteContactsForm');
        var btn = "#pasteContactsBtn";

        AJAXcall("POST", url, btn, formData, (r)=>{ handleResponseMsg(r, 'confirmreload'); });
    }

</script>