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
    $wlpxxmh_kode = $_POST['wlpxxmh_kode'];

    $qs_wlpxxmh = $db
        ->raw()
        ->bind(':wlpxxmh_kode', $wlpxxmh_kode)
        ->exec('SELECT
                    a.id
                FROM wlpxxmh a
                WHERE kode = :wlpxxmh_kode
                AND a.is_nextprocess IS NULL
                AND kode NOT IN
                (
                    SELECT
                        wlpxxmh_kode
                    FROM iivxxrd b
                    GROUP BY b.wlpxxmh_kode
                )
    ');
    $rs_wlpxxmh = $qs_wlpxxmh->fetch();

    if(empty($rs_wlpxxmh)){
        $status_code = 500;
        $message = 'LPN yang diinput salah atau sudah digunakan!';
        $type_message = 'error';
        $wlpxxmh_kode_status = 0;
    }else{
        $status_code = 200;
        $message = '';
        $type_message = 'success';
        $wlpxxmh_kode_status = 1;
    }

    $data = array(
        'status_code'    => $status_code,
        'message'        => $message,
        'type_message'   => $type_message,
        'rs_wlpxxmh'   => $rs_wlpxxmh,
        'wlpxxmh_kode_status' => $wlpxxmh_kode_status,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>