<?php 
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    require '../../../../usersc/vendor/autoload.php';
	include_once( "../../../helpers/hakakses_s_fn.php" );
    
	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    $qs_hrremth = $db
        ->raw()
        ->bind(':s_id_hemxxmh', $s_id_hemxxmh)
        ->exec('SELECT
                    nama
                FROM hemxxmh
                WHERE id = :s_id_hemxxmh
                '
        );
    $rs_hrremth = $qs_hrremth->fetch();
    $data = array(
        'rs_hrremth' => $rs_hrremth
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>