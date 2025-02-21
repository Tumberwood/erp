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

    $qs_loc = $db
        ->raw()
        ->bind(':id_iwhxxmh', $_POST['id_iwhxxmh'])
        ->exec('SELECT
                    a.id,
                    a.nama
                FROM wloxxmh a
                WHERE a.id_iwhxxmh = :id_iwhxxmh AND a.id_wloctmh = 1 AND a.transaction_state = 1
                LIMIT 1
        ');
    $rs_loc = $qs_loc->fetch();

    $data = array(
        'rs_loc' => $rs_loc
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>