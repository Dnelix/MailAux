<?php
##########################################
# BACK-END FUNCTIONS
##########################################
//RESPONSES
  // 500 - server error
  // 400 - invalid data
  // 401 - unauthorized
  // 404 - not found
  // 405 - invalid request
  // 409 - data conflict
  // 200 - success
  // 201 - record created

function responseServerException($e, $message){
  error_log("Connection error - ".$e, 0);

  $response = new Response();
  $response -> setHttpStatusCode(200); //change back to 500 for prod.
  $response -> setSuccess(false);
  //$response -> addMessage($message);
  $response -> addMessage($e); //optional. Remove for prod.
  $response -> send();
  exit(); 
}

function sendResponse($code, $state, $message = null, $returnData = null, $toCache = false){
  $code = 200; //Just to stop browser suppression. remove this line in production.
  $response = new Response();
  $response -> setHttpStatusCode($code);
  $response -> setSuccess($state);
  $response -> toCache($toCache);
  (($message !== null) ? $response -> addMessage($message) : false);
  (($returnData !== null) ? $response -> setData($returnData) : false);
  $response -> send();
  exit();
}

// AUTH
function generateTokens() {
  $accesstoken = base64_encode((bin2hex(openssl_random_pseudo_bytes(24))).time());
  $refreshtoken = base64_encode((bin2hex(openssl_random_pseudo_bytes(16))).time());
  $accesstoken_expiry = 12000; //20mins
  $refreshtoken_expiry = 1209600; //14 days (2 weeks)
  
  return array(
    'access_token' => $accesstoken,
    'refresh_token' => $refreshtoken,
    'access_token_expiry' => $accesstoken_expiry,
    'refresh_token_expiry' => $refreshtoken_expiry
  );
}

// JSON
function validateJsonRequest() {
  if ($_SERVER['CONTENT_TYPE'] !== 'application/json') {
    sendResponse(400, false, 'Content type header not set to JSON');
    exit();
  }
  //else get the json data
  $rawPostData = file_get_contents('php://input');
  if (!$jsonData = json_decode($rawPostData)) {
    sendResponse(400, false, 'Invalid JSON data in request body');
    exit();
  }

  return $jsonData;
}
// Handle multipart requests differently (for file uploads)
function validateFileRequest() {
  if (strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') === 0) {
    if (!isset($_FILES) || empty($_FILES)) {
        $msg = (!isset($_FILES)) ? "Files array not set." : "";
        $msg .= (empty($_FILES)) ? "Files array is empty" : "";
        sendResponse(400, false, $msg, $_FILES);
        exit();
    }
    return $_POST;  // Return form data as associative array

  } else {
    //else no file uploaded, get the json data
    $rawPostData = file_get_contents('php://input');
    if (!$jsonData = json_decode($rawPostData)) {
      sendResponse(400, false, 'Invalid JSON data in request body');
      exit();
    }
    return $jsonData;
  }
}

// CACHE Responses
function retrieveAndCacheResponse($url, $cacheDuration = 120) {
  
  $cacheKey = md5($url); // Generate a unique cache key based on the API URL

  // Check if the cached response is still fresh on the client side
  if (isset($_SESSION['api_cache'][$cacheKey]) && (time() - $_SESSION['api_cache'][$cacheKey]['timestamp']) < $cacheDuration) {
      $jsonData = $_SESSION['api_cache'][$cacheKey]['response'];
  } else {
    
    $jsonData = json_decode(file_get_contents($url), false); // Make the API request and get the JSON data

    // Set cache-related headers
    ob_start();
    header('Cache-Control: public, max-age=' . $cacheDuration);
    header('ETag: ' . $cacheKey);
    ob_end_clean();

    // Cache the response on the server side for future requests within the same session
    $_SESSION['api_cache'][$cacheKey] = array(
        'timestamp' => time(),
        'response' => $jsonData
    );
  }
  
  return $jsonData;
}

// Get JSON as either php object($stat = false) or array($stat = true)
function retrieveDataFrom($url='php://input', $stat = false, $auth=false){
  if($auth !== true){
    //for the rare case where we don't want to authenticate the GET request
    return json_decode(file_get_contents($url), $stat); 

  } else {
    global $logToken; //= $_SESSION[$sitecode."token"];
    $context = stream_context_create([
      'http' => ['header' => "Authorization: $logToken\r\n",],
    ]);

    return json_decode(file_get_contents($url, false, $context), $stat);
  }
}

function convertCrypto($from, $amount, $to){
  $from = strtoupper($from);
  $to = strtoupper($to);
  $amount = (float)$amount;
  $rate = retrieveAndCacheResponse("https://api.coingate.com/v2/rates/trader/buy/$from/$to", 240);
  $value = $amount * (float)$rate;
  return $value;
}

// Get current exchange rate to USD for any fiat currency
function getAmountPerUSD($currency){
  $currencies = retrieveDataFrom('https://open.er-api.com/v6/latest', false, false);
  $currency = strtoupper($currency);
  $valuePerUSD = $currencies->rates->$currency;
  return $valuePerUSD;
}

// Random Password Generator
function getRandomPassword($length = 12, $type='all') {
  if($type == 'num'){
    $chars = "0123456789";
  } else if($type == 'alphanum'){
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  } else if($type == 'caps'){
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  } else {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
  }
  
  $password = substr(str_shuffle($chars), 0, $length);
  return $password;
}

##########################################
# PARSE
##########################################
function validateFieldLength($field, $minLength, $maxLength, $fieldName) {
  $length = strlen($field);
  $message = "";

  if ($length < $minLength) {
      $message .= "Minimum character length required for $fieldName not reached. ";
  }

  if ($length > $maxLength) {
      $message .= "$fieldName cannot be greater than $maxLength characters. ";
  }

  return $message;
}

// Validate required fields
function validateMandatoryFields($jsonData, $mandatoryFields, $style='single') {
  $missingFields = array();
  foreach ($mandatoryFields as $field) {
      if (!isset($jsonData->$field) || empty($jsonData->$field)) {
          $missingFields[] = ucfirst($field);
      }
  }
  if (!empty($missingFields)) {
      $missingFieldsList = implode(', ', $missingFields);
      if($style == 'group'){
        return "Some data missing! Complete all required fields";
      } else {
        return "The following mandatory fields are missing: $missingFieldsList.";
      }
  }

  return ''; // No missing fields
}
function requiredFields($fieldsArray, $style='single') {
  $missingFields = array();
  foreach ($fieldsArray as $field) {
      if (!isset($field) || empty($field)) {
          $missingFields[] = strtoupper($field);
      }
  }
  if (!empty($missingFields)) {
      $missingFieldsList = implode(', ', $missingFields);
      if($style == 'group'){
        return "Some data missing! Complete all required fields";
      } else {
        return "The following required fields are missing: $missingFieldsList.";
      }
  }

  return ''; // No missing fields
}

// validate ID
function validateNum($num){
  if(!isset($num) || empty($num) || !is_numeric($num)){ 
    return false;
  } else {
    return floatval($num);
  }
}

// Get User Device
function getuserDevice($userAgent){
  $browser = '';

  switch (true) {
    case (strpos($userAgent, 'MSIE') !== false):
      preg_match('/MSIE\s([0-9]+)/', $userAgent, $matches);
      $browser = 'Internet Explorer - ' . $matches[1];
      break;
    case (strpos($userAgent, 'Firefox') !== false):
      preg_match('/Firefox\/([0-9]+)/', $userAgent, $matches);
      $browser = 'Firefox - ' . $matches[1];
      break;
    case (strpos($userAgent, 'Chrome') !== false):
      preg_match('/Chrome\/([0-9]+)/', $userAgent, $matches);
      $browser = 'Chrome - ' . $matches[1];
      break;
    case (strpos($userAgent, 'Safari') !== false):
      preg_match('/Version\/([0-9]+)/', $userAgent, $matches);
      $browser = 'Safari - ' . $matches[1];
      break;
    case (strpos($userAgent, 'Opera') !== false):
      preg_match('/(OPR\/[\d.]+)/', $userAgent, $matches);
      $browser = 'Opera - ' . $matches[1];
      break;
    default:
      $browser = substr($userAgent, 0, 20); //list first 20 characters in the string
  }

  return $browser;
}

// Format Date Time
function formatDateTime($givenDate){
  global $dateformat;
  $dateObj = DateTime::createFromFormat($dateformat, $givenDate);

  if ($dateObj !== false) {
    $formattedDate = $dateObj->format($dateformat);
  } else {
    $timestamp = strtotime($givenDate);
    if ($timestamp !== false && !empty($timestamp)){
      $formattedDate = date($dateformat, $timestamp);
    } else {
      $formattedDate = "Invalid date format!";
    }
  }

  return $formattedDate;
}

// Set JSON Request Headers
function setJSONRequestHeaders($jsonData, $method, $token=null){
  //$auth = (!empty($token) ? "Authorization: Bearer $token" : null);
  $auth = (!empty($token) ? "Authorization: $token" : null);

  $headers = array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($jsonData),
    $auth
  );

  // Create the stream context with headers
  $context = stream_context_create(array(
      'http' => array(
          'method' => $method,
          'header' => $headers,
          'content' => $jsonData
      )
  ));

  return $context;
}

// For email responses and other feedback that may return more than the expected JSON
function getJSONFromVerboseOutput($feedback){
  // Find the block of the JSON response
  $jsonStart = strpos($feedback, '{"statusCode"');
  $jsonEnd = strrpos($feedback, '}');
  $jsonLength = $jsonEnd - $jsonStart + 1;
  
  // Extract the JSON string
  $jsonString = substr($feedback, $jsonStart, $jsonLength);
  
  // Decode the JSON string
  $jsonData = json_decode($jsonString, true);
  
  if ($jsonData !== null){
    $messages = $jsonData['messages'][0];
    return $messages;
  } else {
      return 'Error decoding JSON.';
  }
}

function sendToController($data, $controllerURL, $method='POST', $token=null){
  $token = (!empty($token) ? $token : null); //$_SESSION["accesstoken"]
  $jsonData = json_encode($data);                                 // Convert the data to JSON
  $context = setJSONRequestHeaders($jsonData, $method, $token);  // set request headers

  global $appURL;
  $fileURL = $appURL . $controllerURL;

  $feedback = file_get_contents($fileURL, false, $context);  // Send data to controller file
  //$feedback = file_get_contents($fileURL . '?data=' . urlencode($jsonData));  //GET method

  //return $feedback;
  //$cleanOutput = json_decode($feedback);
  //return $cleanOutput; //return all data (using for test only)
  //return $cleanOutput->messages[0]; //return only the response message
  
  // Find the block of the JSON response
  return getJSONFromVerboseOutput($feedback);
}

// Send any Email
function sendEmail($type, $subject, $to_mail, $to_name='', $message='', $sender=''){
  $data = array(
    'type'    => $type,
    'subject' => $subject,
    'to_mail' => $to_mail,
    'to_name' => $to_name,
    'message' => $message,
    'sender'  => $sender,
  );

  $result = sendToController($data, 'controllers/_email.php');

  return $result;
}

//convert numbers to month names or weekdays
function numberToMonthOrDay($number, $type = 'month') {
  $months = [
      1 => 'January', 2 => 'February', 3 => 'March',
      4 => 'April', 5 => 'May', 6 => 'June',
      7 => 'July', 8 => 'August', 9 => 'September',
      10 => 'October', 11 => 'November', 12 => 'December'
  ];

  $weekdays = [
      1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday',
      4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday', 7 => 'Sunday'
  ];

  // Handle conversion based on the type
  switch (strtolower($type)) {
      case 'month':
          return (!empty($months[$number])) ? $months[$number] : null;
      case 'day':
      case 'week':
          return (!empty($weekdays[$number])) ? $weekdays[$number] : null;
      default:
          return "Invalid type. Use 'month' or 'day'.";
  }
}

function extractAndValidateEmails($input) {
  $normalizedInput = str_replace([";", " "], ",", $input);
  $emailArray = explode(",", $normalizedInput);
  
  // Initialize arrays for valid and invalid emails
  $validEmails = []; $invalidEmails = [];
  
  // Loop through each email, trim whitespace, and validate
  foreach ($emailArray as $email) {
      $email = strtolower(trim($email));
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $validEmails[] = $email;
      } else {
          if (!empty($email)) {
              $invalidEmails[] = $email;
          }
      }
  }
  
  // Notify about invalid entries
  if (!empty($invalidEmails)) {
      $e_msg = "The following entries were invalid and purged:\n";
      $e_msg .= implode(", ", $invalidEmails) . "\n";
  }

  $returnData = array();
  $returnData['validEmails'] = $validEmails;
  $returnData['error'] = $e_msg;
  
  return $returnData;
}

function formatFieldsForAliasQuery($all_fields, $prefix, $desired_fields = null) {
  $field_array = explode(', ', $all_fields);
  
  if ($desired_fields !== null) {
      $field_array = array_filter($field_array, function($field) use ($desired_fields) {
          return in_array($field, $desired_fields);
      });
  }

  // Prefix each field with the provided prefix
  $formatted_fields = array_map(function($field) use ($prefix) {
      return "$prefix.$field";
  }, $field_array);

  return implode(', ', $formatted_fields);
}

########################################## 
# FILE UPLOAD Functions 
##########################################
function uploadFile($file_name, $uploadFolderURL, $new_name = null, $allowedExtensions = [], $maxFileSize = 2 * 1024 * 1024) {

  $allowedExtensions = empty($allowedExtensions) ? ['jpg', 'jpeg', 'gif', 'png'] : $allowedExtensions;

  try {
      if (!isset($_FILES[$file_name]) || $_FILES[$file_name]['error'] !== UPLOAD_ERR_OK) {
          if (!isset($_FILES[$file_name])) {
              sendResponse(400, false, "File not found. Please check the field name.");
              exit();
          }

          $uploadError = $_FILES[$file_name]['error'];
          sendResponse(400, false, "Upload failed: " . $uploadError);
          exit();
      }

      // Extract file details
      $fileTmpPath  = $_FILES[$file_name]['tmp_name'];
      $fileName     = $_FILES[$file_name]['name'];
      $fileSize     = $_FILES[$file_name]['size'];
      $fileType     = $_FILES[$file_name]['type'];
      $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

      // Validate file size
      if ($fileSize > $maxFileSize) {
          sendResponse(413, false, "File is too large. Maximum allowed size is " . ($maxFileSize / 1024 / 1024) . " MB.");
          exit();
      }

      // Validate file extension
      if (empty($allowedExtensions) || !in_array(strtolower($fileExtension), $allowedExtensions)) {
          sendResponse(415, false, "Invalid file type. Allowed types are: " . implode(", ", $allowedExtensions) . ". File type: " . $fileType);
          exit();
      }

      // Ensure the upload directory exists or create it
      if (!is_dir($uploadFolderURL) && !@mkdir($uploadFolderURL, 0755, true)) {
          error_log("Failed to create upload directory: " . $uploadFolderURL, 0);
          sendResponse(500, false, "Failed to create upload directory.");
          exit();
      }

      // Construct the destination path
      $newFileName  = !empty($new_name) ? $new_name : uniqid('', true);
      $newFile      = $newFileName . '.' . $fileExtension;
      $destPath     = rtrim($uploadFolderURL, '/') . '/' . $newFile;

      // Move the file to the destination directory
      if (!move_uploaded_file($fileTmpPath, $destPath)) {
          sendResponse(500, false, "Failed to move uploaded file.");
          exit();
      }

      // Return success response with new file name
      return $newFile;
  } catch (Exception $e) {
      error_log("File Upload Error: " . $e->getMessage(), 0);
      sendResponse(500, false, "There was an error processing the upload.");
      exit();
  }
}

##########################################
# DATABASE CALLS
##########################################
function getUserBalances($DB, $userid){
    $query = $DB -> prepare ('SELECT balance, dailybonus, profit, commission, loanbalance FROM tbl_users WHERE id = :userid LIMIT 1');            
    $query -> bindParam(':userid', $userid, PDO::PARAM_INT);
    $query -> execute();

    $rowCount = $query->rowCount();
    if($rowCount === 0){ sendResponse(404, false, 'User data not Found');}

    $row = $query->fetch(PDO::FETCH_ASSOC);
    
    $returnData = array();
    $returnData['balance']      = floatval($row['balance']);
    $returnData['dailybonus']   = floatval($row['dailybonus']);
    $returnData['profit']       = floatval($row['profit']);
    $returnData['commission']   = floatval($row['commission']);
    $returnData['loanbalance']   = floatval($row['loanbalance']);

    return $returnData;
}

function getuserDataById($id, $data = "all"){
  global $appURL;
  $users = retrieveAndCacheResponse($appURL.'controllers/users.php?userid='.intval($id), 60);
  if($data === 'all' || empty($data)){
    $userdata = (($users -> data !== null) ? $users->data : null);
  } else {
    $userdata = (($users -> data !== null) ? $users->data->$data : null);
  }
  return $userdata;
}

function getPlanData($id, $idtype = "pid", $data = "all"){
  global $appURL;
  //$idtype can be pid(planid) or uid(userid)
  $plans = retrieveAndCacheResponse($appURL.'controllers/_plans.php?'.$idtype.'='.intval($id), 120);
  if($data === 'all' || empty($data)){
    $plandata = (($plans -> data !== null) ? $plans->data : null);
  } else {
    $plandata = (($plans -> data !== null) ? $plans->data->$data : null);
  }
  return $plandata;
}

function countRecord($controller, $query){
  global $appURL;
  $items = retrieveAndCacheResponse($appURL.'controllers/'.$controller.'.php?'.$query, 60);
  $items = !empty($items) ? $items->data : null;

  if(empty($items)){
    $itemCount = 0;
  } else {
    $itemCount = count( $items );
  }
  return intval($itemCount);
}

function authenticateAdmin($aid){
  if(!$aid = validateNum($aid)) {
    return false;
  } else {
    $role = getuserDataById($aid, 'role');
    if($role !== 'admin' && $role !== 'super'){
      return false;
    } else {
      return $aid;
    }
  }
}

##########################################
# FRONT-END FUNCTIONS
##########################################
function statusState($status, $show='text'){
  $status = ucwords($status);
  switch ($status) {
    case 'Not Started':
    case 'Pending':
      $state = 'warning';
      $i = 'ni ni-alert-circle';
      break;
    case 'In Progress':
    case 'Ongoing':
      $state = 'primary';
      $i = 'ni ni-check-circle';
      break;
    case 'Failed':
    case 'Rejected':
      $state = 'danger';
      $i = 'ni ni-alert-circle';
      break;
    case 'Completed':
    case 'Active':
    case '1':
    case 'Approved':
      $state = 'success';
      $i = 'ni ni-check-circle';
      break;
    case 'Inactive':
    case '0':
      $state = 'secondary';
      $i = 'ni ni-alert-circle';
      break;
    default:
      $state = 'info';
      break;
  }

  $iconClass = 'icon text-'.$state.' '.$i;

  if($show === 'icon'){
    return $iconClass;
  } else return $state;
}

function showStatus($status, $display='block'){  
  $state = statusState($status);

  if($display == 'text'){
    $html = '<span class="badge badge-dot bg-'.$state.'">'.$status.'</span>';
  } else{
    $html = '<span class="badge badge-sm badge-dim bg-outline-'.$state.' d-md-inline-flex">'.$status.'</span>';
  }

  echo $html;
}

function displayLoadingBtn($btn_txt, $loading_txt = true){
  $addText = ($loading_txt == true) ? 'Please wait... ' : '';
  
  $html = '
  <span class="indicator-label">' . $btn_txt . '</span>
  <span class="indicator-progress">'. $addText .'
    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
  </span>';

  echo $html;
}

function readableDateTime($timeString, $show=null) {
  global $dateformat;
  global $mysql_dateformat;

  $dateTime = DateTime::createFromFormat($dateformat, $timeString);
  if (!$dateTime) {
    $dateTime = DateTime::createFromFormat($mysql_dateformat, $timeString);
  }

  $formattedDate = $dateTime->format('jS M Y'); // Format date with ordinal suffix
  $formattedTime = $dateTime->format('g:ia'); // Format time with 12-hour clock and am/pm
  // Combine formatted date and time
  if ($show==='dateonly'){
    $formattedDateTime = $formattedDate;
  } else if ($show==='timeonly'){
    $formattedDateTime = $formattedTime;
  } else {
    $formattedDateTime = $formattedDate . ' at ' . $formattedTime;
  }

  return $formattedDateTime;
}

// add any number of days to a given date
function addtoDate($givenDate, $num, $unit='day') {
  global $dateformat;
  global $mysql_dateformat;
  
  $secondsInADay = 24 * 60 * 60;
  if ($unit === 'week'){
    $secondsInAWeek = 7 * $secondsInADay;
    $totalsecs = $secondsInAWeek;
  } else if ($unit === 'month'){
    $secondsInAMonth = 30 * $secondsInADay;
    $totalsecs = $secondsInAMonth;
  } else {
    $totalsecs = $secondsInADay;
  }

  $daysToAdd = $num * $totalsecs;

  $dateObj = DateTime::createFromFormat($dateformat, $givenDate);
  if ($dateObj !== false) {
      $timestamp = $dateObj->getTimestamp();
      $dateString = $timestamp + $daysToAdd;
      //$formatted = date($dateformat, $timestamp);
      $newDate = date($dateformat, $dateString);
  } else {
    $dateObj = DateTime::createFromFormat($mysql_dateformat, $givenDate);
    if ($dateObj !== false) {
      $timestamp = $dateObj->getTimestamp();
      $dateString = $timestamp + $daysToAdd;
      $newDate = date($mysql_dateformat, $dateString);
    } else {
      return "Invalid date format.";
    }
  }
  
  return $newDate;
}

function formatNumber($number) {
  $suffixes = array('', 'K', 'M', 'B', 'T'); // Suffixes for thousand, million, billion, trillion, etc.

  $suffixIndex = 0;
  while ($number >= 1000 && $suffixIndex < count($suffixes) - 1) {
      $number /= 1000;
      $suffixIndex++;
  }

  $formattedNumber = number_format($number, 3);   // Format number to maximum three decimal places

  // Remove trailing zeroes and decimal point if not needed
  $formattedNumber = rtrim($formattedNumber, '0');
  $formattedNumber = rtrim($formattedNumber, '.');

  // Append the appropriate suffix
  $formattedNumber .= $suffixes[$suffixIndex];

  return $formattedNumber;
}

function getInitials($fullname) {
  $names = explode(" ", $fullname);
  $last_name = $names[0];

  if (count($names) >= 2) {
    $first_name = $names[1];
    // Get the first letter of each name and concatenate them
    $initials = substr($last_name, 0, 1) . substr($first_name, 0, 1);
  } else{
    $initials = substr($last_name, 0, 1);
  }
  
  return strToUpper($initials);
}

function displayUserIcon($initials, $id='', $size='small'){
  switch ($id % 5) {
      case 0:
        $color_type = 'danger';
        break;
      case 1:
        $color_type = 'warning';
        break;
      case 2:
        $color_type = 'success';
        break;
      case 3:
        $color_type = 'info';
        break;
      default:
        $color_type = 'primary';
        break;
    }

    if($size == 'small'){
      $html = '<div class="symbol symbol-35px symbol-circle"><span class="symbol-label bg-light-'. $color_type .' text-'. $color_type .' fw-bold">'. $initials .'</span></div>';
    } else if($size == 'large'){
      $html = '<div class="symbol symbol-100px symbol-circle"><span class="symbol-label bg-light-'. $color_type .' text-'. $color_type .' fw-bold"><font size="36pt">'. $initials .'</font></span></div>';
    }

    echo $html;
}

function limit_text($text, $limit) {
  if (str_word_count($text, 0) > $limit) {
      $words = str_word_count($text, 2);
      $pos = array_keys($words);
      $text = substr($text, 0, $pos[$limit]) . '...';
  }
  return $text;
}

function imageFieldDisplay($field_name, $img_src) {
  $html = '<div class="card card-bordered product-card" style="max-width:180px;" id="imageFieldDisplay">
            <div class="product-thumb">
                <img class="card-img-top" src="'.$img_src.'" alt="'.$field_name.'">
                <ul class="product-badges">
                    <li><span class="badge bg-success p-1"><em class="icon ni ni-check"></em></span></li>
                </ul>
                <ul class="product-actions" style="background-color:#fff">
                    <li><a href="javascript:;" onclick="toggleView(\'#imageFieldDisplay\',\'#'.$field_name.'\')"><em class="icon ni ni-edit"></em></a></li>
                </ul>
            </div>
        </div>';
  
  return $html;
}

function openModal($modalID){
  $html = 'data-bs-toggle="modal" data-bs-target="#'.$modalID.'"';
  return $html;
}

function doneOrNotDone($data, $displayType = 'icon') {
  $verdict = (empty($data) || $data == 0) ? 'notdone' : 'done';
  
  $html = '';

  switch ($displayType) {
      case 'icon':
          $html = ($verdict === 'done') 
              ? '<span class="text-success me-2"><em class="icon ni ni-check-fill-c"></em></span>' 
              : '<span class="text-danger me-2"><em class="icon ni ni-cross-fill-c"></em></span>';
          break;
      // Add more cases for other display types if needed
      default:
          $html = ''; 
          break;
  }

  return $html;
}

function calcProfileCompletion($opt1, $opt2, $opt3, $opt4, $opt5){
  $requiredFields = array($opt1, $opt2, $opt3, $opt4, $opt5);

  $totalFields = count($requiredFields);
  $completedFields = 0;

  foreach ($requiredFields as $field) {
      if (isset($field) && !empty($field)) {
          $completedFields++;
      }
  }

  $completionPercentage = ($completedFields / $totalFields) * 100;

  return $completionPercentage;
}

//GET COUNTRIES, STATES & CITIES
function country_state_city(){
  global $c_website;
  return retrieveDataFrom($c_website.'models/data/city-state-country.json', true); //read file from JSON DB
}

function getCountries(){
  $data = country_state_city();
  $country_list = array_column($data['Countries'], 'CountryName');
  return $country_list;
}

function getStates($targetCountry){
  $data = country_state_city();
  $states = [];
  foreach ($data['Countries'] as $country) {
      if ($country['CountryName'] === $targetCountry) {
          $states = array_column($country['States'], 'StateName');
          break;
      }
  }
  return $states;
}

function getCities($targetState){
  $data = country_state_city();
  $cities = [];
  foreach ($data['Countries'] as $country) {
    foreach ($country['States'] as $state) {
      if ($state['StateName'] === $targetState) {
          $cities = $state['Cities'];
          break;
      }
    }
  }
  return $cities;
}