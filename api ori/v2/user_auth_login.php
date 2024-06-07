<?php
if (count(get_included_files()) == 1) die(); //Direct Access Not Permitted
include "includes/globals.php";

$auth = apibuilderLogin($data['username'], $data['password']);

include "user_multi_language.php";
$hooks =  getMyHooks(['page' => 'loginFailApi']);

if ($auth && $auth['verified'] == 0) {
  $response['devMessage'][] = "User email has not been verified. You may want to offer them a link to the verification page.";
  $string = lang("VER_RES_SUC");
  $string .= $settings->join_vericode_expiry . " " . lang("T_HOURS") . ".";
  $response['userMessage'][] = ["warning" => $string];
  $response['apikey'] = false;
  includeHook($hooks, 'body'); //fail hook
  //not currently including ip ban here bc this could be an honest mistake
  // apibuilderBan($ip);
  apiResponse($response, 403);
} elseif ($auth) {
  $response['apikey'] = $auth['apikey'];
  $hooks =  getMyHooks(['page' => 'loginSuccessApi']);
  includeHook($hooks, 'body');
} else {
  $response['userMessage'][] = ["danger" => lang("SIGNIN_FAIL")];
  $response['apikey'] = false;
  includeHook($hooks, 'body'); //fail hook
  apibuilderBan($ip);
  apiResponse($response, 403);
}
