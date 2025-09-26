<div class="modal fade" tabindex="-1" id="edit-contact">
    <div class="modal-dialog modal-dialog-centered modal-lg mw-500px">
        <div class="modal-content rounded">
            <div class="modal-header pb-0 border-0 justify-content-end">
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></div>
            </div>

            <form id="editContactForm" class="form" onsubmit="return false;">

                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                
                    <div class="mb-13 text-center">
                        <h1 class="mb-3">Edit Contact</h1>
                        <div class="text-muted fw-semibold fs-5">
                            Modify contact information <div id="edit_loader"></div>
                        </div>
                    </div>

                    <div class="d-flex flex-column mb-8">
                        <label class="required fs-6 fw-semibold mb-2">Contact group</label>
                        <select class="form-select form-select-solid form-select-sm" data-control="select2" data-dropdown-parent="#edit-contact" data-hide-search="true" name="group" id="e_group">
                            <option value="" selected>All Contacts</option>
                            <?php foreach ($g_data as $g): ?>
                                <option value="<?= $g->id; ?>" id="<?= $g->id; ?>"><?= $g->group_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                        <label class="required fs-6 fw-semibold mb-2">Email Address</label>
                        <input type="text" class="form-control form-control-solid" id="e_email" name="email">
                    </div>

                    <div class="row g-9 mb-8" data-select2-id="select2-data-131-jn1f">
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">First Name</label>
                            <input type="text" class="form-control form-control-solid" id="e_first_name" name="first_name">
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Last Name</label>
                            <input type="text" class="form-control form-control-solid" id="e_last_name" name="last_name">
                        </div>
                    </div>

                </div>
                
                <div class="modal-footer px-10 px-lg-15">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="editContactBtn" class="btn btn-primary" onclick="editContact()"><?= displayLoadingBtn('Edit Contact'); ?></button>
                </div>

                <input type="hidden" name="cid" id="cid" />
                <input type="hidden" name="created" value="<?= date($mysql_dateformat); ?>" />

            </form>

        </div>
    </div>
</div>

<script>
    function editContact(){
        var web = '<?= $appURL; ?>';
        var userid = '<?= $loguserid; ?>';
        var cid = _('cid').value;
        var url = web+"controllers/contacts.php?uid="+userid+"&cid="+cid;
        var formData = extractFormData('#editContactForm');
        var btn = "#editContactBtn";

        AJAXcall("PATCH", url, btn, formData, (r)=>{ handleResponseMsg(r, 'confirmreload'); });
    }

    function showEditContact(cid){
        var formid = '#editContactForm';
        var loader = '#edit_loader';

        $(loader).html('<b style="color:#f00">please wait...</b>');
        $(formid+' :input').prop('disabled', true);    // Disables all form inputs

        var web = '<?= $appURL; ?>';
        var uid = '<?= $loguserid; ?>';
        var url = web+"controllers/contacts.php?uid="+uid+"&cid="+cid;
        
        AJAXcall("GET", url, null, null, (r)=>{
            var data = r.dataraw;
            //console.log(data.content);
            $(formid+' #cid').val(data.id);
            $(formid+' #e_email').val(data.email);
            //$(formid+' #'+data.type).prop('checked', true);
            $(formid+' #e_first_name').val(data.first_name);
            $(formid+' #e_last_name').val(data.last_name);

            $(formid+' :input').prop('disabled', false);    // Enables all form inputs
            $(loader).html('');
        });

    }
</script>