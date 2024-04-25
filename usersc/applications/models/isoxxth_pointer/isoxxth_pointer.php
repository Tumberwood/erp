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
    $warna = $_POST['warna'];
    
    $imageCircleName = $imageId . 'c';
    $imageCircle     = $_FILES['canvasImage']['tmp_name'];
    $imageCircleUrl  = $filePath.$imageCircleName.'.jpg';
    move_uploaded_file($imageCircle, $imageCircleUrl);

    $imageBackgroundName = $imageId . 'o.jpg';
    $imageBackground     = $_FILES['backgroundImage']['tmp_name'];
    $imageBackgroundUrl  = $filePath.$imageBackgroundName;
    move_uploaded_file($imageBackground, $imageBackgroundUrl);
    

    // Jalankan skrip Python untuk memproses gambar
    $output = shell_exec("python isoxxth_pointer_color.py \"$warna\" \"$filePath\" \"$imageCircleName\" \"$imageCircleUrl\" \"$imageBackgroundName\" \"$imageBackgroundUrl\"");

    if ($output === false) {
        // Jika ada kesalahan dalam menjalankan skrip Python
        $status_code  = 500;
        $message = "Processing image gagal!";
        $type_message = 'error';
        $output_file = '';
    } else {
        // Parsing JSON output dari Python
        $result = json_decode($output, true);

        $status_code  = 200;
        $message = "Processing image berhasil";
        $type_message = 'success';
        $output_file = $result['output_file'];
    }

    $data = array(
        'status_code' => $status_code,
        'message' => $message,
        'type_message' => $type_message,
        'output_file' => $output_file
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );
?>