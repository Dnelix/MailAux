<?php require("_base/_constants.php"); ?>
<?php require("_base/_functions.php"); ?>
<?php require("_base/_auth.php"); ?>

<!DOCTYPE html>
<html lang="en">
  	<head>
		<title><?= $c_title; ?></title>
		<meta charset="utf-8" />
		<meta name="description" content="<?= $c_description; ?>" />
		<meta name="keywords" content="<?= $c_keywords; ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="application" />
		<meta property="og:title" content="<?= $c_description; ?>" />
		<meta property="og:url" content="<?= $dev_shop_url; ?>" />
		<meta property="og:site_name" content="<?= $c_title; ?>" />
		<link rel="canonical" href="<?= $dev_shop; ?>" />
		<link rel="shortcut icon" href="assets/media/logos/favicon.png" />

		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

	</head> 
