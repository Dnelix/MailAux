    <div class="tab-pane fade show active" id="send_group" role="tabpanel">
        <div class="my-10">
            <h4 class="fw-bold">Send to Group</h4>
            Select the group(s) to recieve this mail:
        </div>
        
        <form id="sendGroup_form" onsubmit="return false;">
            <div class="w-lg-50 mb-8" data-kt-buttons="true" data-kt-initialized="1">
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 mb-5 active">
                    <div class="d-flex align-items-center me-2">
                        <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                            <input class="form-check-input" type="radio" name="groupid" value="" checked>
                        </div>

                        <div class="flex-grow-1">
                            <h2 class="d-flex align-items-center fs-3 fw-bold flex-wrap"> All Contacts <span class="badge badge-light-warning ms-2 fs-7">Default</span></h2>
                            <!-- <div class="fw-semibold opacity-50">Created: 28th October</div> -->
                        </div>
                    </div>

                    <div class="ms-5">
                        <span class="fs-2x fw-bold"><?= $c_count; ?></span>                        
                        <span class="fs-7 opacity-50">/<span data-kt-element="period">contacts</span></span>
                    </div>
                </label>

                <?php foreach($g_data as $g): ?>
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 mb-5 ">
                    <div class="d-flex align-items-center me-2">
                        <div class="form-check form-check-custom form-check-solid form-check-primary me-6">
                            <input class="form-check-input" type="radio" name="groupid" value="<?= $g->id; ?>">
                        </div>

                        <div class="flex-grow-1">
                            <h2 class="d-flex align-items-center fs-3 fw-bold flex-wrap"> <?= ucwords($g->group_name); ?> </h2>
                            <div class="fw-semibold opacity-50">Created: <?= readableDateTime($g->created, 'dateonly'); ?></div>
                        </div>
                    </div>

                    <div class="ms-5">
                        <span class="fs-2x fw-bold"><?= $g->contact_count; ?></span>                        
                        <span class="fs-7 opacity-50">/<span data-kt-element="period">contact(s)</span></span>
                    </div>
                </label>
                <?php endforeach; ?>

            </div>

            <button class="btn btn-primary col-lg-6 col-sm-12 col-xs-12" type="submit" id="sendGroup_btn" onclick="sendGroup()">
                <?= displayLoadingBtn('Proceed'); ?>
            </button>
        </form>
    </div>

    <script>
        function sendGroup(){
            var web = '<?= $appURL; ?>';
            var userid = '<?= $loguserid; ?>';
            var url = web+"controllers/campaigns.php?uid="+userid;
            var c_title = _('subject').value;

            if(isEmpty(c_title)){
                swal_popup('error', 'Please set a title/subject for the campaign'); return false;
            }
            
            var send_to = 'group';
            var group_id = document.querySelector('[name="groupid"]:checked').value;
            var formData = {
                title : c_title,
                send_to :send_to,
                group_id :group_id
            };
            var btn = "#sendGroup_btn";

            AJAXcall("POST", url, btn, formData, (r)=>{ 
                var lastId = (r.data) ? JSON.parse(r.data).lastInsertID : null;
                handleResponseMsg(r, 'confirmredirect', 'templates&cmid='+lastId);
            });
        }
    </script>