<?php
if (count(get_included_files()) == 1) die(); //Direct Access Not Permitted
include "includes/globals.php";
include "user_multi_language.php";

$opts = [];
if (!isset($data['apiData'])) {
  $response['devMessage'][] = "apiData not provided";
  apiResponse($response, 400);
} else {
  $opts['apiEndpoint'] = true;
  $opts['apiData'] = $data['apiData'];
}


if (!is_array(array($data['apiData']))) {
  $response['devMessage'][] = "apiData must be an array";
  apiResponse($response, 400);
}

if (!isset($data['apiData']['form_name'])) {
  $response['devMessage'][] = "apiData provided, but form_name not specified inside that data.";
  apiResponse($response, 400);
}

//check if the form actually exists so we can validate the rules
$formQ = $db->query("SELECT * FROM us_forms WHERE form = ?", [$data['apiData']['form_name']]);
$formC = $formQ->count();
if ($formC < 1) {
  $response['devMessage'][] = "Form not found";
  apiResponse($response, 404);
} else {
  $form = $formQ->first();
}

if (isset($data['apiData']['form_update']) && is_numeric($data['apiData']['form_update'])) {
  //Form Update
  //this gets overwritten on error
  $response['devMessage'][] = "Attempting form update";
  //It should be noted that by this time we've verified that the form name being submitted is a valid form name.
  $q = $db->query("SELECT * FROM {$data['apiData']['form_name']} WHERE id = ?", [$data['apiData']['form_update']]);
  $c = $q->count();
  if ($c < 1) {
    $response['devMessage'][] = "Form row not found.";
    apiResponse($response, 404);
  }
  $f = $q->first();

  if ($form->api_update == 0) {
    $response['devMessage'][] = "Update is disabled on this form";
    apiResponse($response, 503);
  }
  $perms = explode(",", $form->api_perms_update);
  if (!hasPerm($perms, $auth["user_id"])) {
    $response['devMessage'][] = "This user does not have permission to perform an update";
    apiResponse($response, 401);
  }

  //Look at per-form security from the formbuilder plugin
  if ($form->api_force_user_col != 0) {
    $col = $form->api_user_col;
    if ($form->api_user_col == "") {
      $response['devMessage'][] = "Invalid field selected for the Force User Id security feature";
      apiResponse($response, 400);
    } elseif ($f->$col != $auth['user_id']) {
      $response['devMessage'][] = "This user is not authorized to update this row.";
      apiResponse($response, 401);
    } else {
      //force the user id into the form data
      $data['apiData'][$form->api_user_col] = $auth['user_id'];
      $opts['apiData'] = $data['apiData'];
    }
  }
} else {
  //Form Insert

  if ($form->api_insert == 0) {
    $response['devMessage'][] = "Insert is disabled on this form";
    apiResponse($response, 503);
  }
  $perms = explode(",", $form->api_perms_insert);
  if (!hasPerm($perms, $auth["user_id"])) {
    $response['devMessage'][] = "This user does not have permission to perform an insert";
    apiResponse($response, 401);
  }

  //Look at per-form security from the formbuilder plugin
  if ($form->api_force_user_col != 0) {
    if ($form->api_user_col == "") {
      $response['devMessage'][] = "Invalid field selected for the Force User Id security feature";
      apiResponse($response, 400);
    } else {
      //force the user id into the form data
      $data['apiData'][$form->api_user_col] = $auth['user_id'];
      $opts['apiData'] = $data['apiData'];
    }
  }
}

$try = preProcessForm($opts);

if ($try['form_valid'] != true) {
  $response['devMessage'][] = "Form validation failed";
  foreach ($try['errors'] as $t) {
    $response['userMessage'][] = ["danger" => $t];
  }
  apiResponse($response, 400);
} else {
  $final = postProcessForm($try, $opts);
  $response['devMessage'][] = "Form processed successfully";
  $response['success'] = true;
  apiResponse($response);
}
