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

    $id_gfrfltd = $_POST['id_gfrfltd'];

    $qs_option_select = $db
        ->raw()
        ->bind(':id_gfrfltd', $id_gfrfltd)
        ->exec('SELECT
                    nama
                FROM gfroptd
                WHERE id_gfrfltd = :id_gfrfltd AND transaction_state <> -9
        '
        );

    $rs_option_select = $qs_option_select->fetchAll();
    
    $data = array(
        'rs_option_select' => $rs_option_select,
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>