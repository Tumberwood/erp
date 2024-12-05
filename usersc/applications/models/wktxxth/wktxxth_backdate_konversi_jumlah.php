<?php 
    require_once( "../../../../users/init.php" );
    require_once( "../../../../usersc/lib/DataTables.php" );
    require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	require_once( "../../../../usersc/vendor/autoload.php");
	require_once( "../../../helpers/hakakses_s_fn.php" );

	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    // END definisi variable untuk fn_ajax_results.php

    // ambil variable dari ajax data
    $id_iimxxmh = $_POST['id_iimxxmh'];
    $id_iumxxmh_unit = $_POST['id_iumxxmh_unit'];

    $qs_konversi = $db
        ->raw()
        ->bind(':id_iimxxmh', $id_iimxxmh)
        ->bind(':id_iumxxmh_unit', $id_iumxxmh_unit)
        ->exec('SELECT
                    a.jumlah_konversi
                FROM iimummd a
                WHERE a.id_iimxxmh = :id_iimxxmh AND a.id_iumxxmh = :id_iumxxmh_unit
        '
        );

    $rs_konversi = $qs_konversi->fetch();
    $jumlah_konversi  = $rs_konversi['jumlah_konversi'];

    if(empty($rs_konversi)){
        $status_code = 500;
        $message = 'ERROR!';
        $type_message = 'error';

    }else{
        $status_code = 200;
        $message = '';
        $type_message = 'success';
        
    }

    $data = array(
        'status_code'       => $status_code,
        'message'           => $message,
        'type_message'      => $type_message,

        'jumlah_konversi'        => $jumlah_konversi,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>