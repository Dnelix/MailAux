        <!--begin::Global Javascript Bundle(used by all pages)-->
        <script>var hostUrl = "<?= $c_website; ?>";</script>
        <script src="assets/plugins/global/plugins.bundle.js"></script>
        <script src="assets/js/scripts.bundle.js"></script>
        <!-- Custom globals -->
        <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
        <script src="_base/js/custom.js"></script>
        
        <!--begin::Page Level Javascript-->
        <?php if($curPage == "edit_template"){ ?>
            <!-- <script src="assets/plugins/custom/ckeditor/ckeditor-inline.bundle.js"></script> -->
            <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/inline/ckeditor.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    InlineEditor
                    .create(document.querySelector('#ckeditor_inline'))
                    .then(editor => {
                        console.log(editor);
                    })
                    .catch(error => {
                        console.error(error);
                    });
                });
            </script>

        <?php 
            } else if($curPage == "contacts"){
                echo '<script src="assets/js/custom/pages/dataTablesInit.js"></script>';
            }else if($curPage == "campaigns"){
                echo '<script src="assets/js/widgets.bundle.js"></script>';
            } else if ($curPage == "" || $curPage == $authPage){ //auth pages
                if(array_key_exists('signup', $_GET)){
                    echo '<script src="assets/js/custom/auth/sign-up.js"></script>';
                } else if(array_key_exists('password_reset', $_GET)){
                    echo '<script src="assets/js/custom/auth/password-reset.js"></script>';
                } else if(array_key_exists('new_password', $_GET)){
                    echo '<script src="assets/js/custom/auth/new-password.js"></script>';
                } else {
                    echo '<script src="assets/js/custom/auth/sign-in.js"></script>';
                }
            }
        ?>
	
</html>