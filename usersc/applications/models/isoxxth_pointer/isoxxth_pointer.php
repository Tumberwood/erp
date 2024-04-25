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

    $backgroundImage     = $_FILES['backgroundImage']['tmp_name'];
    $backgroundImageFile = $imageId . '_o.jpg';
    $backgroundImageUrl  = $filePath.$backgroundImageFile;
    move_uploaded_file($backgroundImage, $backgroundImageUrl);

    $circleImage     = $_FILES['canvasImage']['tmp_name'];
    $circleImageFile = $imageId . '_c.jpg';
    $circleImageUrl  = $filePath.$circleImageFile;
    move_uploaded_file($circleImage, $circleImageUrl);
    
    // Jalankan skrip Python untuk memproses gambar
    
    // $output = shell_exec("python isoxxth_pointer_color.py \"$circleImageUrl\" \"$warna\" \"$filePath\" \"$circleImageFile\"");
    $output = shell_exec("python isoxxth_pointer_color.py \"$warna\" \"$filePath\" \"$backgroundImageUrl\" \"$backgroundImageFile\" \"$circleImageUrl\" \"$circleImageFile\"");

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
        $output_file = $result['outputfileCircle'];
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