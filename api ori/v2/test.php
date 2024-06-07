<?php
if (count(get_included_files()) == 1) die(); //Direct Access Not Permitted
include "includes/globals.php";
//some actions
$response['devMessage'][] = "";
$response['userMessage'][] = "User msg test for code " . $data['code'] . " with status changed to " . $data['status'];
apiResponse($response, 404);
