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

    $qs_iimxxmh = $db
        ->query('select', 'iimummd' )
        ->get([
            'iimxxmh.id as id_iimxxmh',
            'iimxxmh.kode as iimxxmh_kode',
            'iimxxmh.nama as iimxxmh_nama',
            'iumxxmh.kode as iumxxmh_kode'
        ] )
        ->join('iimxxmh','iimxxmh.id = iimummd.id_iimxxmh','LEFT' )
        ->join('iumxxmh','iumxxmh.id = iimummd.id_iumxxmh','LEFT' )
        ->where('iimummd.id_iimxxmh', $_POST['id_iimxxmh'] )
        ->where('iimummd.is_terkecil', 1)
        ->exec();

    $rs_iimxxmh = $qs_iimxxmh->fetch();
    

    $data = array(
        'rs_iimxxmh' => $rs_iimxxmh
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>