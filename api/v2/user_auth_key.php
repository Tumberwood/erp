<?php
if (count(get_included_files()) == 1) die(); //Direct Access Not Permitted
include "includes/globals.php";
$auth = apibuilderAuth($data['key']);

include "user_multi_language.php";
$hooks =  getMyHooks(['page' => 'loginFailApi']);
if (!$auth) {
  $response['devMessage'][] = "Invalid data provided";
  $response['userMessage'][] = ["danger" => lang("SIGNIN_FAIL")];
  $response['apikey'] = false;
  apibuilderBan($ip);
  includeHook($hooks, 'body'); //fail hook
  apiResponse($response, 400);
} elseif ($auth['apimode'] != 4 && $auth['apimode'] != 5) {
  $response['devMessage'][] = "This API only works in mode 4 or 5";
  includeHook($hooks, 'body'); //fail hook
  apibuilderBan($ip);
  apiResponse($response, 400);
}

if ($auth && $auth['verified'] == 0) {
  $response['devMessage'][] = "User email has not been verified. You may want to offer them a link to the verification page.";
  $string = lang("VER_RES_SUC");
  $string .= $settings->join_vericode_expiry . " " . lang("T_HOURS") . ".";
  $response['userMessage'][] = ["warning" => $string];
  $response['apikey'] = false;
  includeHook($hooks, 'body'); //fail hook
  apiResponse($response, 403);
}

$hooks =  getMyHooks(['page' => 'loginSuccessApi']);
includeHook($hooks, 'body');
