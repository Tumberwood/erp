<?php
if(count(get_included_files()) ==1) die(); //Direct Access Not Permitted
include "includes/globals.php";

$q = $db->query("SELECT user_permission_matches.permission_id, permissions.name FROM user_permission_matches INNER JOIN permissions ON user_permission_matches.permission_id = permissions.id WHERE user_id = ?",[$auth['user_id']]);
$c = $q->count();

$perms = [];
$perms['ids'] = [];
$perms['names'] = [];
if($c < 1){
  $response['permissions'] = $perms;
  $response['requests']['permissions'] = false;
}else{
  $f = $q->results();
  foreach($f as $p){
    $perms['ids'][] = $p->permission_id;
    $perms['names'][] = $p->name;
  }
  $response['permissions'] = $perms;
  $response['requests']['permissions'] = true;
}
