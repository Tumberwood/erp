<?php
if (count(get_included_files()) == 1) die(); //Direct Access Not Permitted
include "includes/globals.php";

if (isset($data['email'])) {
  $email = $data['email'];
} else {
  apibuilderBan($ip);
  apiResponse($response, 403);
}


$fuser = new User($email);
$validate = new Validate();
$msg1 = lang("GEN_EMAIL");

$validation = $validate->check($data, array('email' => array('display' => $msg1, 'valid_email' => true, 'required' => true,),));

if ($validation->passed()) {
  if ($fuser->exists()) {
    $vericode = randomstring(15);
    $vericode_expiry = date("Y-m-d H:i:s", strtotime("+$settings->reset_vericode_expiry minutes", strtotime(date("Y-m-d H:i:s"))));
    $db->update('users', $fuser->data()->id, ['vericode' => $vericode, 'vericode_expiry' => $vericode_expiry]);
    //send the email
    $options = array(
      'fname' => $fuser->data()->fname,
      'email' => rawurlencode($email),
      'vericode' => $vericode,
      'reset_vericode_expiry' => $settings->reset_vericode_expiry
    );
    $subject = lang("PW_RESET");
    $encoded_email = rawurlencode($email);
    $body =  email_body('_email_template_forgot_password.php', $options);
    $email_sent = email($email, $subject, $body);
    logger($fuser->data()->id, "User", "Requested password reset.");
    $response['userMessage'][] = ["success" => lang("VER_SENT") . " " . $settings->reset_vericode_expiry . " " . lang("T_MINUTES") . "."];
    if (!$email_sent) {
      $response['devMessage'][] = lang("ERR_EMAIL");
    }
    apiResponse($response);
  } else {
    apibuilderBan($ip);
    apiResponse($response, 403);
    sleep(3); //pretend to send
    logger(1, "Password Reset", "Attempted password reset on " . $email);
    $response['userMessage'][] = ["success" => lang("VER_SENT") . " " . $settings->reset_vericode_expiry . " " . lang("T_MINUTES") . "."];
    $email_sent = true;
  }
} else {
  //user does not exist.
  logger(0, "User", "Tried to reset non-existant $email");
  apibuilderBan($ip);
  sleep(3);
  $response['userMessage'][] = ["success" => lang("VER_SENT") . " " . $settings->reset_vericode_expiry . " " . lang("T_MINUTES") . "."];
  apiResponse($response);
  // $errors = $validation->errors();
}
