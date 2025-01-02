<?php include_once('views/head.php'); ?>

<?php 
// $users called in from header.php
if ($logrole === 'business'){
    $customers = retrieveDataFrom($c_website.'controllers/customers.php?tailor='.$loguserid);
    $customers = (!empty($customers)) ? $customers->data : null;
    $projects = retrieveDataFrom($c_website.'controllers/projects.php?tailor='.$loguserid);
    $projects = (!empty($projects)) ? $projects->data : null; 
} else {
    $projects = retrieveDataFrom($c_website.'controllers/projects.php?cid='.$loguserid);
    $projects = (!empty($projects)) ? $projects->data : null; 
}
$customerCount = (isset($customers->count) ? $customers->count : 0);
$projectCount = (isset($projects->count) ? $projects->count : 0);

$incomeTotal = $expenseTotal = $balanceTotal = 0;
if(!empty($projects)){
    $projectlist = $projects->projectlist;
    foreach ($projectlist as $project) {
        $incomeTotal += $project->income;
        $expenseTotal += $project->expense;
    }
    $balanceTotal = $incomeTotal - $expenseTotal;
}

$biz = retrieveDataFrom($c_website.'controllers/business.php?userid='.$loguserid);
$bizdata = (isset($biz->data) ? $biz->data : null);
$location = (isset($bizdata->city) ? $bizdata->city.', '.$bizdata->state : 'Unknown');

$country_list = getCountries();

$photoData = retrieveDataFrom($c_website.'controllers/images.php?userid='.$loguserid.'&refid='.$loguserid) -> data;
$photoFile = isset($photoData) ? $photoData->imageURL : null;
$imageid   = isset($photoData) ? $photoData->id : null;
?>
<!---------------------------------------->
<body id="kt_body" style="<?= $bodystyle; ?>" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-row flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

                <?php include_once('views/general/header.php'); ?>
                <?php include_once('views/general/breadcrumb.php'); ?>
                <!--------------------------------------------->

                <!--begin::Container-->
                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                    <div class="content flex-row-fluid" id="kt_content">
                        <div class="row g-5 g-xl-10">
                            <?php include_once('views/profile/overview.php'); ?>
                            <?php
                                $path = (isset($_GET['page']) ? $_GET['page'] : 'details');

                                if (file_exists('views/profile/' .$path. '.php')){
                                    include_once('views/profile/' .$path. '.php');
                                }
                                else { include_once('views/general/404_content.php'); }
                            ?>
                        </div>
                    </div>
                </div>
                <!--end::Container-->

                <!--------------------------------------------->
                <?php include_once('views/general/footer.php'); ?>
                <?php include_once('views/general/scrolltop.php'); ?>
                
                <!-- Include Modals -->
                <?php include_once('views/components/modals/share_link.php'); ?>
                <?php include_once('views/components/modals/new_customer.php'); ?>
                <?php include_once('views/components/modals/new_project.php'); ?>

            </div>
        </div>
    </div>
    <!--end::Root-->
<!---------------------------------------->
<?php include_once('views/foot.php'); ?>