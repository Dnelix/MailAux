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
  $response -> addMessage($message);
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

// Get JSON as either php object($stat = false) or array($stat = true)
function retrieveDataFrom($url='php://input', $stat = false, $auth=true){
  if($auth !== true){
    //for the rare case where we don't want to authenticate the GET request
    return json_decode(file_get_contents($url), $stat); 

  } else {
    $logToken = $_SESSION["accesstoken"];
    $context = stream_context_create([
      'http' => ['header' => "Authorization: $logToken\r\n",],
    ]);

    return json_decode(file_get_contents($url, false, $context), $stat);
  }
}

// Clean input data
function cleanData($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = preg_replace('/\s\s+/', " ", $data);//trim excess white space
  return $data;
}

// Random Password Generator
function getRandomPassword($length = 12) {
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
  $password = substr(str_shuffle($chars), 0, $length);
  return $password;
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

//* Make JSON API call: Opt 1&2 (next time you look at this, remove the "Bearer" string)
function callJSONAPI($url, $data=[], $accesstoken=null, $type='POST'){
  $ch = curl_init(); //initialize a session
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Authorization: Bearer ' . $accesstoken
  ));
  if (curl_error($ch)) {
    $response = curl_error($ch);
  } else {
    $response = curl_exec($ch);
  }

  return $response;
  curl_close($ch);
}
function callJSONAPI2($url, $postData, $accesstoken=null){
  //$postData = '{"from":{"email":"mailtrap@rinotradefx.com","name":"Mailtrap Test"},"to":[{"email":"domainbuy101@gmail.com"}]}'; // for test. This should be dynamic array

  $curl = curl_init();
  curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $postData,
      CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer ' . $accesstoken,
          'Content-Type: application/json'
      ),
  ));

  if (curl_error($curl)) {
    $response = curl_error($curl);
  } else {
    $response = curl_exec($curl);
  }

  return $response;
  curl_close($curl);
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

//For email responses and other feedback that may return more than the expected JSON
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

// Send data to controller
function sendToController($data, $controllerURL, $method='POST', $token=null){
  $token = (!empty($token) ? $token : $_SESSION["accesstoken"]);
  $jsonData = json_encode($data);                                 // Convert the data to JSON
  $context = setJSONRequestHeaders($jsonData, $method, $token);  // set request headers

  global $c_website;
  $fileURL = $c_website . $controllerURL;

  $feedback = file_get_contents($fileURL, false, $context);  // Send data to controller file
  //$feedback = file_get_contents($fileURL . '?data=' . urlencode($jsonData));  //GET method

  //return $feedback;
  //$cleanOutput = json_decode($feedback);
  //return $cleanOutput; //return all data (using for test only)
  //return $cleanOutput->messages[0]; //return only the response message
  
  // Find the block of the JSON response
  return getJSONFromVerboseOutput($feedback);
}

// Validate required fields
function validateMandatoryFields($jsonData, $mandatoryFields) {
  $missingFields = array();
  foreach ($mandatoryFields as $field) {
      if (!isset($jsonData->$field) || empty($jsonData->$field)) {
          $missingFields[] = ucfirst($field);
      }
  }
  if (!empty($missingFields)) {
      $missingFieldsList = implode(', ', $missingFields);
      return "The following mandatory fields are missing: $missingFieldsList.";
  }

  return ''; // No missing fields
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

// Manage time displays
function time_elapsed_string($time) {
  $diff = time() - $time;
  
  if ($diff < 60) {
      return 'just now';
  } elseif ($diff < 3600) {
      $mins = floor($diff / 60);
      $suffix = ($mins > 1) ? 'mins' : 'min';
      return $mins . ' ' . $suffix . ' ago';
  } elseif ($diff < 86400) {
      $hours = floor($diff / 3600);
      $suffix = ($hours > 1) ? 'hours' : 'hour';
      return $hours . ' ' . $suffix . ' ago';
  } else {
      $days = floor($diff / 86400);
      $suffix = ($days > 1) ? 'days' : 'day';
      return $days . ' ' . $suffix . ' ago';
  }
}

function calculateTimeLeft($futureDate) {
  $currentTime = time();
  $futureTime = strtotime($futureDate); //this is not working. Try using time()
  
  $timeDifference = $futureTime - $currentTime;
  
  if ($timeDifference < 0) {
    return "Date has already passed.";
  }
  
  $secondsInADay = 24 * 60 * 60;
  $secondsInAWeek = 7 * $secondsInADay;
  $secondsInAMonth = 30 * $secondsInADay;
  
  $daysLeft = floor($timeDifference / $secondsInADay);
  $hoursLeft = floor(($timeDifference % $secondsInADay) / 3600);
  $weeksLeft = floor($timeDifference / $secondsInAWeek);
  $monthsLeft = floor($timeDifference / $secondsInAMonth);
  
  $result = "";
  
  if ($monthsLeft > 0) {
    $result .= "$monthsLeft month" . ($monthsLeft > 1 ? "s" : "") . " ";
  }
  
  if ($weeksLeft > 0) {
    $result .= "$weeksLeft week" . ($weeksLeft > 1 ? "s" : "") . " ";
  }
  
  if ($daysLeft > 0) {
    $result .= "$daysLeft day" . ($daysLeft > 1 ? "s" : "") . " ";
  }
  
  if ($hoursLeft > 0) {
    $result .= "$hoursLeft hour" . ($hoursLeft > 1 ? "s" : "");
  }
  
  if ($result === "") {
    $result = "Less than an hour";
  }
  
  return $result . " to go";
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

// add any number of days to a given date
function addtoDate($givenDate, $num, $unit='day') {
  global $dateformat;
  
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
      return "Invalid date format.";
  }
  
  return $newDate;
}

########################################## 
# FILE UPLOAD Functions 
##########################################
function validateFileAttributes($attr_name = 'attributes'){
  if(!isset($_POST[$attr_name])){
      sendResponse(400, false, 'Attributes missing from body of request');
  }

  if(!$jsonFileAttributes = json_decode($_POST[$attr_name])){
      sendResponse(400, false, 'File attributes is not valid JSON');
  }

  //check for image title and filename
  if(!isset($jsonFileAttributes->title) || !isset($jsonFileAttributes->filename) || $jsonFileAttributes->title == '' || $jsonFileAttributes->filename == ''){
      sendResponse(400, false, 'Title and filename fields are mandatory');
  }

  //check the filename string to ensure it doesn't contain a . or the file extension
  if(strpos($jsonFileAttributes->filename, ".") > 0){
      sendResponse(400, false, "Filename should not contain the extension");
  }

  return $jsonFileAttributes;
}

function getExtensionFromMime($imageFileMime){
  $allowedFileTypes = array('image/jpeg', 'image/gif', 'image/png');

  if(!in_array($imageFileMime, $allowedFileTypes)){
      sendResponse(400, false, "Invalid Image file type!");
  }

  $fileExt = "";
  switch ($imageFileMime){
      case "image/jpeg":
          $fileExt = ".jpg";
          break;
      case "image/png":
          $fileExt = ".png";
          break;
      case "image/gif":
          $fileExt = ".gif";
          break;
      default:
          break;
  }

  if(empty($fileExt)){ 
      sendResponse(400, false, "No valid file extension found for image");
  }

  return $fileExt;
}

function getUploadFileDetails($fileName, $maxFileSize = null){
  $maxFileSize = empty($maxFileSize) ? 5242880 : $maxFileSize; //5mb max size by default

  //check to ensure the right content type is sent
  if(!isset($_SERVER['CONTENT_TYPE']) || strpos($_SERVER['CONTENT_TYPE'], "multipart/form-data; boundary=") === false){
      sendResponse(400, false, "Content type header not set to multipart/form-data with a boundary");
  }
  
  //Perform other validations on the image
  if(!isset($_FILES[$fileName])){
      sendResponse(500, false, 'Ensure the right file is selected');
  }
  if($_FILES[$fileName]['error'] !== 0){
      sendResponse(500, false, 'There is a problem with the selected file: '.$_FILES[$fileName]['error']);
  }
  
  //check image size
  if(isset($_FILES[$fileName]['size']) && $_FILES[$fileName]['size'] > $maxFileSize){
      sendResponse(400, false, 'File size is too large please resize');
  }

  //Get image file details (including mime)
  $imageSizeDetails = getimagesize($_FILES[$fileName]['tmp_name']);
  
  return array(
      'imgdata' => $_FILES[$fileName],
      'imgsize' => $imageSizeDetails
  );
}

function getUploadFilename($fileName) {
  $sanitizedFileName = preg_replace('/[^a-zA-Z0-9_.]/', '', $fileName);
  $fileNameWithoutExtension = pathinfo($sanitizedFileName, PATHINFO_FILENAME);
  $finalFileName = str_replace(' ', '_', $fileNameWithoutExtension);

  return $finalFileName;
}

function getUploadFileExtension($fileName, $allowedArray=null) {
  if($allowedArray === null){
      $allowedArray = array('jpeg', 'jpg', 'gif', 'png'); //image by default
  }

  $extension = pathinfo($fileName, PATHINFO_EXTENSION);

  if(!in_array($extension, $allowedArray)){
      sendResponse(400, false, "Invalid file type!");
  }

  return ".".$extension;
}

//* Process Image Upload
function processImageUpload($inputName, $targetDirectory, $allowedExtensions = ['jpg', 'jpeg', 'png']) {
  if (!isset($_FILES[$inputName])) {
      throw new Exception('No file was uploaded.');
  }

  $errorCode = $_FILES[$inputName]['error'];

  if ($errorCode !== UPLOAD_ERR_OK) {
      throw new Exception(getUploadErrorMessage($errorCode));
  }

  $tempFilePath = $_FILES[$inputName]['tmp_name'];
  $originalFileName = $_FILES[$inputName]['name'];
  $fileExtension = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));

  if (!in_array($fileExtension, $allowedExtensions)) {
      throw new Exception('Invalid file type.');
  }

  $uniqueFileName = uniqid() . '_' . $originalFileName;
  $targetPath = $targetDirectory . '/' . $uniqueFileName;

  if (move_uploaded_file($tempFilePath, $targetPath)) {
      return $targetPath;
  } else {
      throw new Exception('Error while moving the uploaded file.');
  }
}

function getUploadErrorMessage($errorCode) {
  $uploadErrors = array(
      UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
      UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
      UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
      UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
      UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
      UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
      UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.'
  );

  return isset($uploadErrors[$errorCode]) ? $uploadErrors[$errorCode] : 'Unknown error';
}


##########################################
# DATABASE CALLS
##########################################
function checkAuthStatus($writeDB){
  global $max_loginattempts;

  if(!isset($_SERVER['HTTP_AUTHORIZATION']) || strlen($_SERVER['HTTP_AUTHORIZATION']) < 1){
      sendResponse(401, false, 'Access token is missing or empty');
  }
  $accesstoken = $_SERVER['HTTP_AUTHORIZATION'];
  //return $accesstoken; exit();
  
  try{
      //get the user id associated with the access token (query both user and sessions tables)
      $query = $writeDB -> prepare('SELECT s.id AS sessionid, s.userid, s.a_tokenexpiry, s.refreshtoken, s.r_tokenexpiry, u.active, u.loginattempts FROM tbl_sessions AS s, tbl_users AS u WHERE s.userid = u.id AND s.accesstoken = :accesstoken');
      $query -> bindParam(':accesstoken', $accesstoken, PDO::PARAM_STR);
      $query -> execute();
  
      $rowCount = $query -> rowCount();
      if($rowCount === 0){
          sendResponse(401, false, 'Invalid access token!');
      }
  
      $row = $query -> fetch(PDO::FETCH_ASSOC);
  
      $ret_sessionid = $row['sessionid'];
      $ret_userid = $row['userid'];
      $ret_a_tokenexpiry = $row['a_tokenexpiry'];
      $ret_refreshtoken = $row['refreshtoken'];
      $ret_r_tokenexpiry = $row['r_tokenexpiry'];
      $ret_active = $row['active'];
      $ret_loginattempts = $row['loginattempts'];
  
      if($ret_active !== '1' && $ret_active !== 1){
          sendResponse(401, false, 'User account not active');
      }
      if($ret_loginattempts >= $max_loginattempts){
          sendResponse(401, false, 'User account currently locked out');
      }
      //if the access token expiry time is less than the current time, then it has expired
      if(strtotime($ret_a_tokenexpiry) < time()){
          if(strtotime($ret_r_tokenexpiry) >= time()){ // optional. Check if refresh token is still active
              $returnData = array();
              $returnData['sessionID'] = $ret_sessionid;
              $returnData['refresh_token'] = $ret_refreshtoken;
              sendResponse(401, false, 'Access token expired',  $returnData);

              //update access token with refresh token
          } else { //if refresh token is also expired
            //delete session entry from table
            $controllerURL = 'controllers/sessions.php?sessionid='.$ret_sessionid;
            return sendToController(null, $controllerURL, 'DELETE', $accesstoken);

            sendResponse(401, false, 'Your login have expired. Please login again');
          }
      }

      //else return user id (included because this is a function)
      return $ret_userid;
      exit();
  }
  catch (PDOException $e){
      responseServerException($e, 'There was an issue with authentication. Please try again');
  }
}

function getuserDataById($data, $id){
  global $c_website;
  $users = retrieveDataFrom($c_website.'controllers/users.php?userid='.intval($id));
  $userdata = (($users -> data !== null) ? $users->data->$data : null);
  return $userdata;
}

function getCount($url){
  $item = retrieveDataFrom($url);
  $itemsCount = (empty($item->data->count)) ? 0 : $item->data->count;
  return $itemsCount; 
}

function countProjects($tid, $cid){
  global $c_website;
  $url = $c_website.'controllers/projects.php?tailor='. $tid .'&customer='. $cid;
  return getCount($url);
}

//GET COUNTRIES, STATES & CITIES
function country_state_city(){
  global $c_website;
  return retrieveDataFrom($c_website.'models/databases/city-state-country.json', true); //read file from JSON DB
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

##########################################
# FRONT-END FUNCTIONS
##########################################
function showMsg($type='', $msg=''){
    if ($type === 'danger'){ $icon = "fa-lightbulb"; $title = "ERROR!"; }
    if ($type === 'warning'){ $icon = "fa-chart-pie"; $title = "WARNING!"; }
    if ($type === 'info'){ $icon = "fa-mail-bulk"; $title = "INFO"; }
    if ($type === 'primary'){ $icon = "fa-lightbulb"; $title = "NOTE"; }
    if ($type === 'success'){ $icon = "fa-check-square"; $title = "SUCCESS!"; }

    $html = '
    <div class="alert alert-dismissible bg-light-'. $type .' d-flex flex-column flex-sm-row p-5 mb-10">
        <i class="fas '. $icon .' fs-2x text-'.$type.' me-5 mb-5 mb-sm-0"></i>
        <div class="d-flex flex-column pe-0 pe-sm-10">
            <h4 class="fw-bold">' . $title . '</h4>
            <span>' . $msg . '</span>
        </div>
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="fa fa-times text-'.$type.'"></i>
        </button>
    </div>
    ';
    echo $html;
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

function showCustomerIcon($id='', $initials='', $active='0', $size='small'){
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
          $color_type = 'primary';
          break;
        default:
          $color_type = 'info';
          break;
      }
    
    $onlineIcon = "";
    if($active=='1'){ $onlineIcon = '<div class="bg-'. $color_type .' position-absolute h-8px w-8px rounded-circle translate-middle start-100 top-100 ms-n1 mt-n1"></div>';}

    if($size == 'small'){
      $html = '<div class="symbol symbol-35px symbol-circle"><span class="symbol-label bg-light-'. $color_type .' text-'. $color_type .' fw-bold">'. $initials .'</span></div>'. $onlineIcon ;
    } else if($size == 'large'){
      $html = '<div class="symbol symbol-100px symbol-circle"><span class="symbol-label bg-light-'. $color_type .' text-'. $color_type .' fw-bold"><font size="36pt">'. $initials .'</font></span></div>'. $onlineIcon ;
    }

    echo $html;
}

function showProjectIcon($category, $size='small'){

  $color_type = 'danger';
  $icon = 'las la-gem ';

  $weardata = retrieveDataFrom('models/databases/wear-categories.json');
    foreach ($weardata as $cat){
      if($cat->name == $category){
        $color_type = $cat->color;
        $icon = $cat->icon;
      } 
    }
    
    if ($size === 'small'){
      $html = '<div class="symbol symbol-50px w-50px bg-light"><span class="symbol-label bg-light-'.$color_type.'"><i class="'.$icon.' text-'.$color_type.' fs-3x"></i></span></div>';
    } else {    
      $html = '<div class="symbol symbol-70px symbol-circle me-5"><span class="symbol-label bg-light-'.$color_type.'"><i class="'.$icon.' text-'.$color_type.' fs-5x"></i></span></div>';
    }

    echo $html;
}

function showStatus($status){
  $status =  ucWords($status);
  switch ($status) {
    case 'Not Started':
      $state = 'light-warning';
      break;
    case 'In Progress':
      $state = 'light-primary';
      break;
    case 'Delayed':
      $state = 'light-danger';
      break;
    case 'Completed':
      $state = 'light-success';
      break;
    case 'Active':
      $state = 'success';
      break;
    case 'Inactive':
      $state = 'secondary';
      break;
    default:
      $state = 'warning';
      break;
  }

  $html = '<span class="badge badge-'.$state.' fw-bolder me-auto px-4 py-3">'.$status.'</span>';

  echo $html;
}

function progressPosition($num, $max=10){
  $num = ($num > $max) ? $max : $num;
  $position = ($num/$max)*100;
  return $position;
}

function readableDateTime($timeString, $show=null) {
  $dateTime = DateTime::createFromFormat('d/m/Y H:i', $timeString);
  if (!$dateTime) {
    $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $timeString);
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

function displayLoadingIcon($btn_txt){
  $html = '
  <span class="indicator-label">' . $btn_txt . '</span>
  <span class="indicator-progress">Please wait... 
  <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
  ';

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
?>