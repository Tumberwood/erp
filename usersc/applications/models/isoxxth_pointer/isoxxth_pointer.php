<?php
    header('Content-Type: application/json');

    require_once( "../../../../users/init.php" );
    require_once( "../../../../usersc/lib/DataTables.php" );
    require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    // END definisi variable untuk fn_ajax_results.php

    $imageData = $_FILES['canvasImage']['tmp_name'];
    $imageId = $_POST['imageId'];
    $warna = $_POST['warna'];
    $filePath = '../../../files/isoxxth_pointer/';
    $file = 'r' . $imageId . '.jpg';
    $fullurl = $filePath.$file;
    move_uploaded_file($imageData, $fullurl);

    // Jalankan skrip Python untuk memproses gambar
    $output = shell_exec("python isoxxth_pointer_color.py \"$fullurl\" \"$warna\" \"$filePath\" \"$file\"");

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


    

    // print_r($result);
    // echo $result['output_file'];

    $data = array(
        'status_code' => $status_code,
        'message' => $message,
        'type_message' => $type_message,
        'output_file' => $output_file
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );
?>