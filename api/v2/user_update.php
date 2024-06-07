<?php
if(count(get_included_files()) ==1) die(); //Direct Access Not Permitted
include "includes/globals.php";
include "user_multi_language.php";

//we're going to make these messages global to this api call
$errors = [];
$successes = [];

//when submitting this info, you will do it through the apiData variable
//from this point we will store that into a more genreic $input variable
if(!isset($data['apiData'])){
  $response['devMessage'][] = "apiData not provided for user update";
  apiResponse($response);
}else{
  $input = $data['apiData'];
  foreach($input as $k=>$v){
    $input[$k] = Input::sanitize($v);
  }
}

if(file_exists($abs_us_root.$us_url_root."usersc/api/".$version."/user_data_hidden_fields.php")){
  include($abs_us_root.$us_url_root."usersc/api/".$version."/user_data_hidden_fields.php");
}else{
  include "user_data_hidden_fields.php";
}

//this is all of the user's existing info
$userdetails= $db->query("SELECT * FROM users WHERE id = ?",[$auth['user_id']])->first();
$defaults = ['fname','lname','username','email'];
foreach($defaults as $d){
  if(!isset($input[$d])){
    $input[$d] = $userdetails->$d;
  }
}

//All the validation for the core userspice fields updates is messy, so we're going to do that as an include
//this takes care of username, first name, and last name, and email
//password must be passed as "pwd" because password has been filtered
if(file_exists($abs_us_root.$us_url_root."usersc/api/".$version."/user_update_us_core.php")){
  include($abs_us_root.$us_url_root."usersc/api/".$version."/user_update_us_core.php");
}else{
  include "user_update_us_core.php";
}
//At this point we're going to pull those 4 fields out so they don't auto-update anything else.
//note that you will still have this information in the $data['apiData'] variable if you really want it
foreach($defaults as $d){
  if(!isset($input[$d])){
    unset($input[$d]);
  }
}

foreach($hiddenFields as $h){
  if(isset($input[$h])){
    $response['devMessage'][] = "$h was blocked";
    unset($input[$h]);
    unset($data['apiData'][$h]);
  }
}

if($apiSettings->spice_user_api == 0){
  $updated = [];
  foreach($input as $k=>$v){
    if($v != $userdetails->$k){
      $db->update("users",$auth['user_id'],[$k=>$v]);
      $response['devMessage'][] = "$k updated";
      $updated[] = $k;
      }
    }
  $response['updated'] = $updated;
}

foreach($errors as $e){
  $response['userMessage'][] = ["danger"=>$e];
}
foreach($successes as $e){
  $response['userMessage'][] = ["success"=>$e];
}

if($errors == []){
  $response['success'] = true;
}
apiResponse($response);
