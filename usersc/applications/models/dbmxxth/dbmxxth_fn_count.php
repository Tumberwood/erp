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

    $id_iimxxmh = $_POST['id_iimxxmh'];

    $qs_dbmxxth = $db
        ->raw()
        ->bind(':id_iimxxmh', $id_iimxxmh)
        ->exec('SELECT
                    COUNT(a.id) c_id
                FROM dbmxxth a
                WHERE a.id_iimxxmh = :id_iimxxmh
    ');
    
    $rs_dbmxxth = $qs_dbmxxth->fetch();

    $data = array(
        'c_id' => $rs_dbmxxth['c_id'],
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>