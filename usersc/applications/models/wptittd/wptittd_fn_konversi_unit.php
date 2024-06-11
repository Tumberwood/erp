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

    $id_iimxxmh         = $_POST['id_iimxxmh'];
    $id_iumxxmh_unit    = $_POST['id_iumxxmh_unit'];
    $jumlah_unit        = $_POST['jumlah_unit'];

    // BEGIN get jumlah_konversi
    $qs_jumlah_konversi = $db
        ->query('select', 'iimummd')
        ->get('jumlah_konversi')
        ->where('id_iimxxmh',$id_iimxxmh)
        ->where('id_iumxxmh',$id_iumxxmh_unit)
        ->exec();
    $rs_jumlah_konversi = $qs_jumlah_konversi->fetch();

    $jumlah_konversi    = $rs_jumlah_konversi['jumlah_konversi'];
    $jumlah_terkecil    = $jumlah_konversi * $jumlah_unit; 
    // END get jumlah_konversi

    // BEGIN get UoM terkecil
    $qs_iumxxmh_terkecil = $db
        ->query('select', 'iimummd' )
        ->get([
            'id_iumxxmh as id_iumxxmh_terkecil'
        ] )
        ->where('iimummd.id_iimxxmh', $id_iimxxmh )
        ->where('iimummd.is_terkecil', 1 )
        ->exec();
    $rs_iumxxmh_terkecil = $qs_iumxxmh_terkecil->fetch();

    $id_iumxxmh_terkecil = $rs_iumxxmh_terkecil['id_iumxxmh_terkecil'];
    // END get UoM terkecil

    // BEGIN get UoM default
    $qs_iumxxmh_default = $db
        ->query('select', 'iimummd' )
        ->get([
            'id_iumxxmh as id_iumxxmh_default',
            'jumlah_konversi as jumlah_konversi_default'
        ] )
        ->where('iimummd.id_iimxxmh', $id_iimxxmh )
        ->where('iimummd.is_default', 1 )
        ->exec();
    $rs_iumxxmh_default = $qs_iumxxmh_default->fetch();

    $id_iumxxmh_default         = $rs_iumxxmh_default['id_iumxxmh_default'];
    $jumlah_konversi_default    = $rs_iumxxmh_default['jumlah_konversi_default'];

    $jumlah_default = $jumlah_konversi * $jumlah_unit / $jumlah_konversi_default;
    // END get UoM default

    if(empty($rs_jumlah_konversi)){
        $status_code = 500;
        $message = 'UoM tidak ditemukan!';
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

        'id_iumxxmh_default'        => $id_iumxxmh_default,
        'id_iumxxmh_terkecil'        => $id_iumxxmh_terkecil,
        'jumlah_default'        => $jumlah_default,
        'jumlah_konversi'        => $jumlah_konversi,
        'jumlah_terkecil'        => $jumlah_terkecil,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>