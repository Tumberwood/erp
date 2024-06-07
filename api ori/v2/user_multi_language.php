<?php
if(count(get_included_files()) ==1) die(); //Direct Access Not Permitted
include "includes/globals.php";
global $auth;


if($auth && $settings->allow_language == 0){
  if(isset($auth['lang'])){
    unset($auth['lang']);
  }

}elseif($auth && $auth['lang'] != $settings->default_language){
  $settings->default_language = $auth['lang'];
  $response['lang'] = $settings->default_language;
  if(file_exists($abs_us_root.$us_url_root."users/lang/".$auth['lang'].".php")){
    $lang = [];
    include $abs_us_root.$us_url_root."users/lang/".$auth['lang'].".php";
  }
  if(file_exists($abs_us_root.$us_url_root."usersc/lang/".$auth['lang'].".php")){
    include $abs_us_root.$us_url_root."usersc/lang/".$auth['lang'].".php";
  }
}
