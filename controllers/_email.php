<?php
require_once('_constants.php');
require_once('_functions.php');
require_once('../models/Response.php');


//Retrieve JSON. Format = (type, subject, to_mail, to_name='', message='', sender='')
$jsonData = validateJsonRequest();
if(isset($jsonData->subject) && isset($jsonData->to_mail)){
    $subject    = $jsonData->subject;
    $to_mail    = $jsonData->to_mail;
    $type       = (isset($jsonData->type) ? strtolower($jsonData->type) : '');
    $to_name    = (isset($jsonData->to_name) ? $jsonData->to_name : '');
    $message    = (isset($jsonData->message) ? $jsonData->message : '');
    $sender     = (isset($jsonData->sender) && !empty($jsonData->sender)) ? $jsonData->sender : 'Customer Service Team';
} else {
    sendResponse(400, false, 'Invalid data in the JSON body. Unable to proceed');
    exit();
}

$from       = $c_email;
$from_name  = ((isset($sender) && $sender!=='') ? $sender : $company);
$bcc        = ($to_mail === $c_email) ? '' : $c_email; //optional
$year       = date('Y');

// Use an image with a name that matches the email type for the email
$imageExtensions = ['png', 'jpg', 'jpeg', 'gif']; 
$email_image = $email_assets . 'info.png'; // Default image

foreach ($imageExtensions as $extension) {
    $imagePath = $email_assets . $type . '.' . $extension;
    if (is_readable($imagePath)) {
        $email_image = $imagePath; break; // Use the first readable image found
    }
}

// Use a template file with a name that matches the email type for the email
$templatePath = '_email/templates/' . $type . '.php';
$htmlFile = is_readable($templatePath) ? $templatePath : '_email/templates/general.php'; //generic.php is WIP
$htmlBody = file_get_contents($htmlFile);

//replace the defined strings within the mail template with the corresponding variables (Aside from the braces, {strings} and variables must be identical)
$color_pri  = $colors_hex[0];
$color_sec  = $colors_hex[1];
$c_phone    = $c_phone[0];
$c_email    = $c_email[0];
$c_address  = $c_address[0];

$items_to_replace = ['color_pri', 'color_sec', 'to_name', 'subject', 'message', 'sender', 'company', 'getStarted_link', 'activation_link', 'privacypolicy_link', 'c_tagline', 'c_shortsite', 'c_website', 'c_description', 'c_phone', 'c_email', 'svg_verifiedicon', 'email_image', 'email_assets', 'logo_image', 'year', 'c_linkedin', 'c_facebook', 'c_twitter', 'c_whatsapp'];
foreach ($items_to_replace as $item){
    $placeholder = '{$' . $item . '}';
    $variable = $$item;
    $htmlBody = str_replace($placeholder, $variable, $htmlBody);
}


//send the mail (Use only one option)
require('_email/sendvia/PHPmailer.php'); //Simple alternative mail sending
//require('_email/sendvia/SMTP.php'); //SMTP
?>