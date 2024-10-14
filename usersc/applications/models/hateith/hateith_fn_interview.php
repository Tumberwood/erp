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

    $qs_interview = $db
        ->raw()
        ->exec('SELECT
                    b.label
                FROM gfrxxth a
                LEFT JOIN gfrfltd b ON b.id_gfrxxth = a.id
                WHERE a.nama_tabel = "hateitd" AND b.urutan = 1
        '
        );
	
    $rs_interview = $qs_interview->fetch();
    $data = array(
        'rs_interview' => $rs_interview
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>