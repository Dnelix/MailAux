    <div class="tab-pane fade" id="send_contacts" role="tabpanel">
        <div class="mt-10 mb-5">
            <h4 class="fw-bold">Send to Contacts</h4>
            Quickly send mails to a few contacts. Select the contact(s) to recieve this mail:
        </div>
        
        <form id="sendContacts_form" onsubmit="return false;">
            <div class="card-scroll p-2 h-200px">
                <div class="row">

                <?php foreach($c_data as $cn): ?>
                    <div class="col-md-3 g-4">
                        <label class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="cn_email" value="<?= $cn->email; ?>"/>
                            <span class="form-check-label"> <?= $cn->email; ?> </span>
                        </label>
                    </div>
                <?php endforeach; ?>

                </div>
            </div>
        
            <div class="text-center mt-8">
                <button type="button" class="btn btn-primary col-6" id="sendContacts_btn" onclick="sendContacts()">
                    <?= displayLoadingBtn('Proceed'); ?>
                </button>
            </div>
                
        </form>
    </div>

    <script>
        function sendContacts(){
            var web = '<?= $appURL; ?>';
            var userid = '<?= $loguserid; ?>';
            var url = web+"controllers/campaigns.php?uid="+userid;
            var c_title = _('subject').value;

            if(isEmpty(c_title)){
                swal_popup('error', 'Please set a title/subject for the campaign'); return false;
            }
            
            var send_to = 'contacts';
            // Build an array of selected values
            const checkboxes = document.querySelectorAll('input[name="cn_email"]:checked');
            const selectedEmails = Array.from(checkboxes).map(checkbox => checkbox.value);

            var formData = {
                title : c_title,
                send_to :send_to,
                contacts :selectedEmails
            };
            var btn = "#sendContacts_btn";

            AJAXcall("POST", url, btn, formData, (r)=>{ 
                var lastId = (r.data) ? JSON.parse(r.data).lastInsertID : null;
                handleResponseMsg(r, 'confirmredirect', 'templates&cmid='+lastId);
            });
        }

        // Prevent further selection if the defined limit is reached
        const maxSelections = 20;
        const checkboxes = document.querySelectorAll('input[name="cn_email"]'); // Get all checkboxes with the name "cn_email"

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const checkedCount = document.querySelectorAll('input[name="cn_email"]:checked').length; // Get the count of checked checkboxes

                if (checkedCount > maxSelections) {
                    swal_popup('error', `You can only select up to ${maxSelections} emails here. Create a group for more contacts`);
                    checkbox.checked = false; // Uncheck the last selected checkbox
                }
            });
        });
    </script>