<?php
session_start();
date_default_timezone_set('Africa/Lagos');
//error_reporting(0);
$curPage        = isset($_GET['page']) ? $_GET['page'] : null; //use with pretty urls
// $pageurl        = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $pageurlParts   = explode('/', $pageurl);
// $curPage        = str_replace("_", " ", end($pageurlParts)); //end($pageurlParts);

//ORGANIZATION DETAILS//
$sitecode       = "MLX";
$company        = "MailAux";
$c_website      = "http://localhost/2025/mailaux/"; //trailing slash very important
$c_shortsite    = "mailaux.com";
$c_title        = $company." - simple and fast email campaigns";
$c_tagline      = "The simplest platform for sending emails to your contacts";
$c_description  = "Create mailing lists, add contacts and send out bulk emails easily";
$c_keywords     = "Email, mailing, campaigns, list, contact, import, social media, fast, messages, easy, cost effective, free";
$c_email        = ["support@".$c_shortsite, "mail@".$c_shortsite];
$p_email        = "domainbuy101@gmail.com";
$c_phone        = ["+234 81 65370642", ""];
$c_address      = ["Victoria Island, Lagos",""];
$colors_hex     = ["#26be21", "#e4fae4", '#70af3a']; //[pri, sec(light), tet]
$colors_rgb     = ["rgb(38,190,33)", "rgb(228,250,228)", "rgb(112,175,58)"]; //[pri, sec(light), tet]
$color_links    = ['#70af3a']; //[main, hover]
$dev_shop       = "Dnelix Global";
$dev_shop_url   = "https://dnelix.com";

//GLOBAL ITEMS //
$bodystyle          = "background-image: url(assets/media/patterns/header-bg.jpg)";
$currency           = ["NGN","&dollar;"]; //[name,symbol]
$months_of_the_year = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

//PATHS//
$appURL             = $c_website; //$c_website."builder/";
//$c_wallet           = $appURL.'wallet.';
$uploadPath         = '../assets/uploads/'; //relative to controllers folder (fix later - http..//.. addresses won't work)
$uploadRetPath      = $appURL.'assets/uploads/';
$walletImages       = 'assets/images/qr/';
$email_assets       = $appURL.'assets/images/email/';
$logo_image         = $appURL.'assets/images/logo.png';
$logo_image2        = $appURL.'assets/images/logo.png';
$c_favicon          = $appURL.'assets/images/favicon.png';

//LINKS//
$authPage           = "auth"; //page name only
$login_link         = $authPage."?login";
$signup_link        = $authPage."?signup";
$reset_link         = $authPage."?forgot_password";
$newPassword_link   = $appURL.$authPage."?password_reset&s=".$sitecode;
$activation_link    = $appURL.'';
$referral_link      = $c_website.'?ref='.$sitecode; //re-routing handled from frontend
$terms_link         = $c_website.'terms';
$getStarted_link    = $c_website.'why_us';
$privacypolicy_link = $c_website.'privacy';
$customer_link      = $c_website.'new?tid=';

//AUTH//
$max_loginattempts  = 4;
$dateformat         = 'd/m/Y H:i';
$write_dateformat   = '\'%d/%m/%Y %H:%i\'';
$read_dateformat    = '%d/%m/%Y %H:%i';
$mysql_dateformat   = 'Y-m-d H:i:s';

//DB//
$db_host            = 'localhost';
$db_name            = 'mailer';
$db_user            = 'root';
$db_pass            = 'root';

//SOCIALS
$c_facebook         = 'https://facebook.com/';
$c_twitter          = 'https://twitter.com/irevenuenergy?s=11&t=rH0f50wLLpsU6wp2siJ3iw';
$c_linkedin         = 'https://linkedin.com/...';
$c_whatsapp         = 'https://wa.me/'.str_replace(['+','(',')',' '], '', $c_phone[0]);
$c_instagram        = 'https://www.instagram.com/irevenueenergy?igshid=OGQ5ZDc2ODk2ZA==';
$c_youtube          = 'https://www.youtube.com/channel/UC5MBty_Fu9wjoLj8LNea_5w';

// EMAIL //
$SMTP_Host       = 'sandbox.smtp.mailtrap.io';
$SMTP_Username   = 'f3b9e237a1d587';
$SMTP_Password   = 'fff8d171428776';
$SMTP_Port       = 2525;

//SVG ICONS//
$svg_verifiedicon   = '<span class="svg-icon svg-icon-1 svg-icon-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"><path d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z" fill="#00A3FF"></path><path class="permanent" d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white"></path></svg></span>';

#############################
## Other Deployment Actions :
#############################
## 1. htaccess  : Turn off error notifications here and/or in .htaccess
## 2. custom.js : stop error message logging on console in handleResponseMsg()
## 3. cronjobs  : Set up daily cronjobs in the host panel
## 4. mainsite  : update the $appPath variable in __init__ file of main site
## 5. functions : **Comment out the static $code = 200 in sendResponse() and set to 500 for responseServerException()
?>