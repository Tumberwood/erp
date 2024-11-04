<?php 
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    require '../../../../usersc/vendor/autoload.php';
	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    $qs_hpcxxmh = $db
        ->raw()
        ->exec('SELECT
                    nama,
                    jenis
                FROM hpcxxmh a 
                WHERE a.transaction_state = 1
        '
        );

    $rs_hpcxxmh = $qs_hpcxxmh->fetchAll();
    
    $data = array(
        'rs_hpcxxmh' => $rs_hpcxxmh,
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>