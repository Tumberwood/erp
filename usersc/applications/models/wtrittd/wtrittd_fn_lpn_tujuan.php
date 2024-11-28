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
    $wlpxxmh_kode_tujuan = $_POST['wlpxxmh_kode_tujuan'];
    $id_wloxxmh_tujuan = $_POST['id_wloxxmh_tujuan'];

    $qs_lpn = $db
        ->raw()
        ->bind(':wlpxxmh_kode_tujuan', $wlpxxmh_kode_tujuan)
        ->bind(':id_wloxxmh_tujuan', $id_wloxxmh_tujuan)
        ->exec('SELECT
                    id AS c_id,
                    a.id_iimxxmh,
                    a.batch_number,
                    a.expired_date
                FROM iivxxrd a
                WHERE a.wlpxxmh_kode = :wlpxxmh_kode_tujuan AND a.id_wloctmh IN (3,7) AND a.id_wloxxmh = :id_wloxxmh_tujuan AND a.jumlah_terkecil > 0
        '
        );
    $rs_lpn = $qs_lpn->fetch();

    if(empty($rs_lpn)){
        $status_code = 500;
        $message = 'LPN tidak ada di lokasi tujuan!';
        $type_message = 'error';
        $c_id = 0;
        $id_iimxxmh = 0;
        $batch_number = '';
        $expired_date = null;
    }else{
        $status_code = 200;
        $message = '';
        $type_message = 'success';
        $c_id = $rs_lpn['c_id'];
        $id_iimxxmh = $rs_lpn['id_iimxxmh'];
        $batch_number = $rs_lpn['batch_number'];
        $expired_date = $rs_lpn['expired_date'];
    }

    $data = array(
        'status_code'    => $status_code,
        'message'        => $message,
        'type_message'   => $type_message,
        'c_id' => $c_id,
        'id_iimxxmh' => $id_iimxxmh,
        'batch_number' => $batch_number,
        'expired_date' => $expired_date,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>