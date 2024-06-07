<?php
$noMaintenanceRedirect = true;
require_once "../users/init.php";

$sendDevMessage = true;
$response = [];
$response['success'] = false;
$response['devMessage'] = [];
//User Messages are meant to be seen by the end user and are expected to have one of 4 classes
//success,danger,warning,default - Matching bootstrap classes for convenience
//feel free to pass other classes for your convenience
$response['userMessage'] = [];
$version = "v2";


if(!pluginActive("apibuilder",true)){

  if($sendDevMessage){
    $response['devMessage'][] = "API builder plugin not activated.";
  }
  echo json_encode($response);
  die;
}

$file = $abs_us_root.$us_url_root."usersc/plugins/apibuilder/assets/apitools.php";
if(!file_exists($file)){
  if($sendDevMessage){
    $response['devMessage'][] = "API builder tools not found";
  }
  echo json_encode($response);
  die;
}else{
  require_once $file;
}

$apiSettings = $db->query("SELECT * FROM plg_api_settings")->first();
if($apiSettings->dev_msg == 1){
  $sendDevMessage = false;
}
if($apiSettings->api_auth_type != 4 && $apiSettings->api_auth_type != 5){
  $response['devMessage'][] = "This API only works in mode 4 or 5";
  apiResponse($response);
}

if($apiSettings->spice_api != 0){
  $response['devMessage'][] = "The generic UserSpice API is disabled";
  apiResponse($response);
}

$ip = ipCheckApi();

$settings = $db->query("SELECT * FROM settings")->first();
$language = $settings->default_language;
if($settings->site_offline == 1){
  $response['devMessage'][] = "The site is offline";
  apiResponse($response);
}

$json = file_get_contents('php://input');
$data = json_decode($json, "true");


if((is_null($data) ||  $data == "" || $data == []) && $_POST != []){
  $data = $_POST;
}elseif((is_null($data) ||  $data == "" || $data == []) && $_GET != []){
  $data = $_GET;
}

if(is_array($data)){
  foreach($data as $k=>$v){
    $data[$k] = Input::sanitize($v);
  }
}


//allow API to override default language BEFORE user is logged in.
//Note that if allow_language is set in the settings table, the user is allowed to re->override this

if(isset($data['lang']) && file_exists($abs_us_root.$us_url_root."users/lang/".$data['lang'].".php") && $settings->default_language != $data['lang'] && $settings->allow_language == 1){
  $settings->default_language = $data['lang'];
  $response['lang'] = $data['lang'];
}
if(file_exists($abs_us_root.$us_url_root."users/lang/".$settings->default_language.".php")){
  $lang = [];
  include $abs_us_root.$us_url_root."users/lang/".$settings->default_language.".php";
}
if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$settings->default_language.".php")){
  include $abs_us_root.$us_url_root."usersc/lang/".$settings->default_language.".php";
}

$response['lang'] = $settings->default_language;

//These are things that the user can do "unauthenticated" by nature
if(isset($data['action'] ) && $data['action'] == "forgotpw"){
  //this is a typical login with a username and password
  apiVersioning("user_forgot_password.php");
}elseif(isset($data['action'] ) && $data['action'] == "login"){
  //this is a typical login with a username and password
  apiVersioning("user_auth_login.php");
}elseif(isset($data['action'] ) && $data['action'] == "join"){
  //this is a join for a new user
  apiVersioning("user_join.php");
}elseif(isset($data['key'])){
  //this is an API key authentication
  apiVersioning("user_auth_key.php");
}else{
  $response['devMessage'][] = "Invalid authentication data provided";
  apibuilderBan($ip);
  apiResponse($response);
}

if($settings->allow_language == 1){
  if(isset($auth['lang'])){
    $language = $auth['lang'];
    $response['lang'] = $language;
  }
}

//if you make it this far, you are authenticated.
//we can use multilanguage features at this point

$requests = [];
if(isset($data['requests']) && is_array($data['requests'])){
  foreach($data['requests'] as $k=>$v){
    $requests[Input::sanitize($k)] = $v;
  }
}

//perform any sort of data requests that will be included in the response.
//if you include the globals file as in the examples, you will have access to $auth['user_id'] for the user id
//we are not going to kill the api if these fail. Instead we will pass a requests array back with success/fail for the request as well as
//appending any data to the response.

if($requests != []){
$response['requests'] = [];
apiVersioning("user_data_hidden_fields.php");

//you can override these in usersc
if(array_key_exists('userdata',$requests)){
  apiVersioning("user_data.php");
}

if(array_key_exists('permissions',$requests)){
  apiVersioning("user_perms.php");
}
//optional additional data requests
apiVersioning("additional_data_requests.php");
}

//Other API Calls
if(isset($data['action'] ) && $data['action'] == "form"){
  apiVersioning("form.php");
}

if(isset($data['action'] ) && $data['action'] == "updateuser"){
  apiVersioning("user_update.php");
}

//optional additional data requests
apiVersioning("additional_actions.php");

//final return anything that is sitting here
//if you made it this far without getting booted, we're going to respond true
$response['success'] = true;
apiResponse($response, 200);
