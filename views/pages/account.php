<?php
$biz = retrieveDataFrom($c_website.'controllers/business.php?data&uid='.$loguserid);
$bizdata = (isset($biz->data) ? $biz->data : null);
$location = (isset($bizdata->city) ? $bizdata->city.', '.$bizdata->state : 'Unknown');

$path = (isset($_GET['sub']) ? $_GET['sub'] : 'business');
?>

<div class="row g-7">
    <div class="col-md-12">
        <?php include_once("account/overview.php"); ?>
    </div>
</div>

<div class="row g-7">
    <div class="col-lg-12 col-xl-12">
        <?php
            
            if (file_exists('views/pages/account/' .$path. '.php')){
                include_once('views/pages/account/' .$path. '.php');
            }
            else { include_once('views/general/error/404.php'); }
            
        ?>
    </div>
</div>