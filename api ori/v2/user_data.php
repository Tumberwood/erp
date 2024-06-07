<?php
if(count(get_included_files()) ==1) die(); //Direct Access Not Permitted
include "includes/globals.php";

$q = $db->query("SELECT * FROM users WHERE id = ?",[$auth['user_id']]);
$c = $q->count();
if($c < 1){
  $response['userdata'] = [];
  $response['requests']['userdata'] = false;
}else{
  $f = $q->first(true);
  // if(file_exists($abs_us_root.$us_url_root."usersc/api/" . $version . "/user_data_hidden_fields.php")){
  //   include $abs_us_root.$us_url_root."usersc/api/" . $version . "/user_data_hidden_fields.php";
  // }
  if(file_exists($abs_us_root.$us_url_root."usersc/api/".$version."/user_data_hidden_fields.php")){
    include($abs_us_root.$us_url_root."usersc/api/".$version."/user_data_hidden_fields.php");
  }else{
    include "user_data_hidden_fields.php";
  }


  if(isset($hiddenFields) && is_array($hiddenFields)){
    foreach($hiddenFields as $h){
      unset($f[$h]);
    }
  }else{
      unset($f['password']);
      unset($f['vericode']);
  }

  $response['userdata'] = $f;
  $response['requests']['userdata'] = true;
}
