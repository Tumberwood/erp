<?php
if(count(get_included_files()) ==1) die(); //Direct Access Not Permitted
//include "includes/globals.php";
//if you create a file in
//usersc/api/{api version}/additional_actions.php"
//you can declare any other actions you want to be available to your api
// echo "tes";
include "includes/globals.php";
// echo $auth['user_id'];
// print_r($response['userdata']['email']);
// print_r($auth);
// print_r($response);
// $response['user_id'];
$response['user_id'] = $auth['user_id'];
$response['username'] = $auth['descrip'];

$_SESSION['user'] = $auth['user_id'];
$_SESSION['username'] = $auth['descrip'];
$_SESSION['where_data_permission'] 	  = 0;


if($_SESSION['user'] < 101){
	$_SESSION['where_data_permission'] 	  = 0;
	

}else{
	
	// BEGIN cek apakah sudah dibuatkan hak akses
	$qs_udpxxsh = "
		SELECT 
			a.id as id,
			a.data_permission as data_permission
		FROM udpxxsh a
		WHERE 
			a.id_users = " . $_SESSION['user'];
	
	$query_udpxxsh = $db->query($qs_udpxxsh);
	$count_udpxxsh = $query_udpxxsh->count();

	if($count_udpxxsh > 0){
		$result_udpxxsh = $query_udpxxsh->results();
		$_SESSION['where_data_permission'] = $result_udpxxsh[0]->data_permission;
	}else{

	}

}