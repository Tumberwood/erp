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

    $qs_iivxxrd = $db
        ->raw()
        ->bind(':wlpxxmh_kode', $wlpxxmh_kode)
        ->exec('SELECT
                    COUNT(id) AS c_id,
                    SUM(a.jumlah_terkecil) s_terkecil,
                    SUM(a.jumlah_unit) s_unit
                FROM iivxxrd a
                WHERE a.wlpxxmh_kode = :wlpxxmh_kode AND a.id_wloctmh = 1 AND a.is_fisik = 0
                HAVING s_unit < 0
        '
        );
    $rs_iivxxrd = $qs_iivxxrd->fetch();

    if(empty($rs_iivxxrd)){
        $status_code = 500;
        $message = 'LPN yang dibooking Tidak Ada!';
        $type_message = 'error';
        
        $c_id        = 0;

    }else{
        $status_code = 200;
        $message = '';
        $type_message = 'success';

        $c_id        = $rs_iivxxrd['c_id'];
        
    }

    $data = array(
        'status_code'       => $status_code,
        'message'           => $message,
        'type_message'      => $type_message,

        'c_id'        => $c_id,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>