<?php
    header('Content-Type: application/json');

    require_once( "../../../../users/init.php" );
    require_once( "../../../../usersc/lib/DataTables.php" );
    require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    // END definisi variable untuk fn_ajax_results.php

    $filePath = '../../../files/isoxxth_pointer/';
    $imageId = $_POST['imageId'];
    
    $imageCircle     = $_FILES['canvasImage']['tmp_name'];
    $imageCircleUrl  = $filePath.$imageId.'.jpg';
    move_uploaded_file($imageCircle, $imageCircleUrl);


    $data = array(
        'imageId' => $imageId
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );
?>