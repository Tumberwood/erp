<?php
if (count(get_included_files()) == 1) die(); //Direct Access Not Permitted
include "includes/globals.php";
$validation = new Validate();
$settings = $db->query("SELECT * FROM settings")->first();
$failed = 0;
$return = [];
$hooks =  getMyHooks(['page' => 'joinAttemptApi']);
includeHook($hooks, 'body');
if (pluginActive('userInfo', true)) {
  $is_not_email = false;
} else {
  $is_not_email = true;
}
$emailSettings = $db->query("SELECT * FROM email")->first();
if ($emailSettings->email_act == 1) {
  $verified = 0;
} else {
  $verified = 1;
}

$validation->check($data, [
  'username' => [
    'display' => lang('GEN_UNAME'),
    'is_not_email' => $is_not_email,
    'required' => true,
    'min' => $settings->min_un,
    'max' => $settings->max_un,
    'unique' => 'users',
  ],
  'fname' => [
    'display' => lang('GEN_FNAME'),
    'required' => true,
    'min' => 1,
    'max' => 60,
  ],
  'lname' => [
    'display' => lang('GEN_LNAME'),
    'required' => true,
    'min' => 1,
    'max' => 60,
  ],
  'email' => [
    'display' => lang('GEN_EMAIL'),
    'required' => true,
    'valid_email' => true,
    'unique' => 'users',
    'min' => 5,
    'max' => 100,
  ],

  'password' => [
    'display' => lang('GEN_PASS'),
    'required' => true,
    'min' => $settings->min_pw,
    'max' => $settings->max_pw,
  ],
]);

if ($validation->passed()) {

  //add user to the database
  $user = new User();
  $join_date = date("Y-m-d H:i:s");
  $code = strtoupper(randomstring(12) . uniqid());
  $code = substr(chunk_split($code, 5, '-'), 0, -1);
  $theNewId = $user->create(array(
    'username' => $data['username'],
    'fname' => $data['fname'],
    'lname' => $data['lname'],
    'email' => $data['email'],
    'password' => password_hash($data['password'], PASSWORD_BCRYPT, array('cost' => 12)),
    'permissions' => 1,
    'account_owner' => 1,
    'join_date' => $join_date,
    'email_verified' => $verified,
    'active' => 1,
    'vericode' => $vericode = randomstring(15),
    'vericode_expiry' => date("Y-m-d H:i:s"),
    'oauth_tos_accepted' => true,
    'apibld_key' => $code,
  ));

  include($abs_us_root . $us_url_root . 'usersc/scripts/during_user_creation.php');
  logger($theNewId, "User", "Registration completed via API.");
  $response['success'] = true;
  $response['devMessage'][] = "New user created";
  if ($verified == 0) {
    $response['userMessage'][] = ["warning" => lang("VER_RES_SUC") . " " . $settings->join_vericode_expiry . " " . lang("T_HOURS") . "."];
  }
  $response['apikey'] = $code;
  $hooks =  getMyHooks(['page' => 'joinSuccessApi']);
  includeHook($hooks, 'body');
  apiResponse($response, 201);
} else {
  $hooks =  getMyHooks(['page' => 'joinFailApi']);
  includeHook($hooks, 'body');
  $return['success'] = false;
  foreach ($validation->errors() as $e) {
    $response['userMessage'][] = ["danger" => $e];
  }
  $response['apikey'] = false;
  $response['devMessage'][] = "Account creation failed.";
  $auth = false;
  apibuilderBan($ip);
  apiResponse($response, 400);
}
