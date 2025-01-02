

    <div class="card card-flush mt-6 mt-xl-9">
        <div class="card-header pt-7" id="kt_chat_contacts_header">
            <div class="card-title"><h2>Groups</h2></div>
        </div>
    
        <div class="card-body pt-5">
            <div class="d-flex flex-column gap-5">
                <div class="d-flex flex-stack">
                    <a href="#" class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary active">All Contacts</a>
                    <div class="badge badge-light-primary"><?= formatNumber($c_count); ?></div>
                </div>

                <?php foreach ($g_data as $g): ?>
                    <div class="d-flex flex-stack">
                        <a href="#" class="fs-6 fw-bold text-gray-800 text-hover-primary "><?= $g->group_name; ?></a>
                        <div class="badge badge-light-info"><?= $g->contact_count; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
    
            <div class="separator my-7"></div>
    
            <label class="fs-6 fw-semibold form-label">Add new group</label>
    
            <div class="input-group">
                <input type="text" class="form-control form-control-solid" id="groupname" placeholder="Group name">
                <button type="button" class="btn btn-icon btn-primary" id="addgroup_btn" onclick="addGroup()">
                    <?= displayLoadingBtn('<i class="fa fa-plus-square fs-2"></i>', false); ?>
                </button>
            </div>
    
            <!--div class="separator my-7"></div>
            <a href="add-contact.html" class="btn btn-primary w-100"><i class="ki-outline ki-badge fs-2"></i> Add new contact</a-->
            
        </div>
    </div>

<script>
    function addGroup(){
        var web = '<?= $appURL; ?>';
        var userid = '<?= $loguserid; ?>';
        var url = web+"controllers/groups.php?uid="+userid;

        var groupname = _('groupname').value;
        var formData = {group_name : groupname}; //extractFormData('#payinvoice');
        var btn = "#addgroup_btn";

        AJAXcall("POST", url, btn, formData, (r)=>{ handleResponseMsg(r, 'confirmreload'); });
    }

</script>