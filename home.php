<?php 
include_once('views/head.php'); 
if(!isset($user)){echo '<script> window.location.href = "'. $authPage .'"; </script>';}
?>
<!---------------------------------------->
<body  id="kt_app_body" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"  class="app-default" >

    <?php include_once('views/general/theme_setup.php'); ?>
    
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid " id="kt_app_page"> 
            
            <?php include_once('views/general/header.php'); ?>
            
            <div class="app-wrapper  flex-column flex-row-fluid " id="kt_app_wrapper">
                <div class="app-container container-xxl d-flex flex-row-fluid">
                    
                    <?php include_once('views/general/sidebar.php'); ?>
                    
                    <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
                        <div class="d-flex flex-column flex-column-fluid">
                            
                            <?php include_once('views/general/breadcrumb.php'); ?>

                            <div id="kt_app_content" class="app-content  flex-column-fluid " >
                                
                                <?php
                                    $who = 'pages';
                                    if(!empty($curPage)){
                                        if (file_exists("views/$who/$curPage.php")) {
                                            include_once("views/$who/$curPage.php");
                                        } else {
                                            include_once("views/general/error/404.php");
                                        }
                                    } else {
                                        include_once("views/$who/dashboard.php"); 
                                    }
                                ?>

                            </div>

                            <?php include_once('views/general/footer.php'); ?>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</body>

<!---------------------------------------->
<?php include_once('views/foot.php'); ?>