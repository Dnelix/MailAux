<?php
$htmlBody = str_replace('{$color_sec}', $color_sec, $htmlFile); //notice that this first item is modifying $htmlFile while others will modify $htmlBody in succession
$htmlBody = str_replace('{$color_pri}', $color_pri, $htmlBody);
$htmlBody = str_replace('{$to_name}', $to_name, $htmlBody);
$htmlBody = str_replace('{$subject}', $subject, $htmlBody);
$htmlBody = str_replace('{$message}', $message, $htmlBody);
$htmlBody = str_replace('{$sender}', $sender, $htmlBody);
$htmlBody = str_replace('{$company}', $company, $htmlBody);
$htmlBody = str_replace('{$getStarted_link}', $getStarted_link, $htmlBody);
$htmlBody = str_replace('{$activation_link}', $activation_link, $htmlBody);
$htmlBody = str_replace('{$privacypolicy_link}', $privacypolicy_link, $htmlBody);
$htmlBody = str_replace('{$c_tagline}', $c_tagline, $htmlBody);
$htmlBody = str_replace('{$c_shortsite}', $c_shortsite, $htmlBody);
$htmlBody = str_replace('{$c_website}', $c_website, $htmlBody);
$htmlBody = str_replace('{$c_description}', $c_description, $htmlBody);
$htmlBody = str_replace('{$c_phone}', $c_phone, $htmlBody);
$htmlBody = str_replace('{$c_email}', $c_email, $htmlBody);
$htmlBody = str_replace('{$svg_verifiedicon}', $svg_verifiedicon, $htmlBody);
$htmlBody = str_replace('{$email_image}', $email_image, $htmlBody);
$htmlBody = str_replace('{$logo_image}', $logo_image, $htmlBody);
$htmlBody = str_replace('{$year}', $year, $htmlBody);

?>