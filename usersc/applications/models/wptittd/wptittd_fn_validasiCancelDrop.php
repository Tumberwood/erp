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
                    a.id,
                    a.id_wloxxmh,
                    a.id_wloctmh,
                    a.wlpxxmh_kode,
                    a.wloxxmh_nama,
                    SUM(a.jumlah_terkecil) s_terkecil
                FROM iivxxrd a
                WHERE a.wlpxxmh_kode = :wlpxxmh_kode AND a.id_wloctmh IN (1,6)
                GROUP BY a.id_wloxxmh
                HAVING s_terkecil > 0
        '
        );
    $rs_iivxxrd = $qs_iivxxrd->fetch();

    if(empty($rs_iivxxrd)){
        $status_code = 500;
        $message = 'Stok di Lokasi Receiving Sudah Tidak Ada!';
        $type_message = 'error';
        
        $id_wloctmh        = 0;

    }else{
        $status_code = 200;
        $message = '';
        $type_message = 'success';

        $id_wloctmh        = $rs_iivxxrd['id_wloctmh'];
        
    }

    $data = array(
        'status_code'       => $status_code,
        'message'           => $message,
        'type_message'      => $type_message,

        'id_wloctmh'        => $id_wloctmh,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>