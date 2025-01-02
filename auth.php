<?php include_once('views/head.php'); ?>
<!---------------------------------------->
<body id="kt_body" class="" style="background: linear-gradient(90deg, #2C294B 0%, #7C394B 100%"> 
    <?php include_once('views/general/theme_setup.php'); ?>
    
    <div class="d-flex flex-column flex-root">
        <div class="d-flex flex-column flex-xl-row flex-column-fluid">

            
        <?php 
            $queryString = $_SERVER['QUERY_STRING'];
            $queryParts = explode('&', $queryString);
            $path = $queryParts[0];

            include_once('views/auth/main.php');
            
            if (file_exists('views/auth/' .$path. '.php')){
                include_once('views/auth/' .$path. '.php');
            }
            else { include_once('views/auth/login.php'); }
            
        ?>

        </div>
    </div>

</body>

<!---------------------------------------->
<?php include_once('views/foot.php'); ?>