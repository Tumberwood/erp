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
        ->query('select', 'iivxxrd' )
        ->get([
            'iivxxrd.id_iimxxmh as id_iimxxmh',
            'iivxxrd.iimxxmh_kode as iimxxmh_kode',
            'iivxxrd.iimxxmh_nama as iimxxmh_nama',
            'iivxxrd.iumxxmh_unit_kode as iumxxmh_unit_kode',
            'SUM(iivxxrd.jumlah_unit * iivxxrd.is_fisik) as s_jumlah_unit'
        ] )
        ->where('iivxxrd.wlpxxmh_kode', $wlpxxmh_kode )
        ->where('iivxxrd.id_wloctmh', 1 )
        ->exec();
    $rs_iivxxrd = $qs_iivxxrd->fetch();

    if(empty($rs_iivxxrd)){
        $status_code = 500;
        $message = 'Stok di Lokasi Receiving Sudah Tidak Ada!';
        $type_message = 'error';
        
        $id_iimxxmh        = 0;
        $iimxxmh_kode      = '';
        $iimxxmh_nama      = '';
        $s_jumlah_unit     = 0;
        $iumxxmh_unit_kode = '';

    }else{
        $status_code = 200;
        $message = '';
        $type_message = 'success';

        $id_iimxxmh        = $rs_iivxxrd['id_iimxxmh'];
        $iimxxmh_kode      = $rs_iivxxrd['iimxxmh_kode'];
        $iimxxmh_nama      = $rs_iivxxrd['iimxxmh_nama'];
        $s_jumlah_unit     = $rs_iivxxrd['s_jumlah_unit'];
        $iumxxmh_unit_kode = $rs_iivxxrd['iumxxmh_unit_kode'];
        
    }

    $data = array(
        'status_code'       => $status_code,
        'message'           => $message,
        'type_message'      => $type_message,

        'id_iimxxmh'        => $id_iimxxmh,
        'iimxxmh_kode'      => $iimxxmh_kode,
        'iimxxmh_nama'      => $iimxxmh_nama,
        's_jumlah_unit'     => $s_jumlah_unit,
        'iumxxmh_unit_kode' => $iumxxmh_unit_kode
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>