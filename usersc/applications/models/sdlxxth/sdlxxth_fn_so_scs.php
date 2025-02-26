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

    $id_sodxxth = $_POST['id_sodxxth'];

    $qs_sodxxth_self_konsinyasi = $db
        ->query('select', 'sodxxth')
        ->get([
            'sodxxth.id as id',
            'CONCAT(sodxxth.kode, " - ", scsxxth.kode) as text',
            'scsxxth.id as id_scsxxth',
            'iwhxxmh.id as id_iwhxxmh'
        ])
        ->join('scsxxth','scsxxth.id_sodxxth = sodxxth.id','LEFT' )
        ->join('iwhxxmh','iwhxxmh.id_grlxxmh = sodxxth.id_grlxxmh_customer','LEFT' )
        ->where('sodxxth.id', $id_sodxxth )    
        ->where('scsxxth.transaction_state', 1 )
        ->exec();
    $rs_sodxxth_self_konsinyasi = $qs_sodxxth_self_konsinyasi->fetch();
    
    $id_scsxxth = $rs_sodxxth_self_konsinyasi['id_scsxxth'];
    $id_iwhxxmh = $rs_sodxxth_self_konsinyasi['id_iwhxxmh'];

    $data = array(
        'id_scsxxth' => $id_scsxxth,
        'id_iwhxxmh' => $id_iwhxxmh,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>