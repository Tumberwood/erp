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

    $id_iimxxmh = $_POST['id_iimxxmh'];
    $id_scsxxth = $_POST['id_scsxxth'];

    $qs_scsittd = $db
        ->raw()
        ->bind(':id_scsxxth', $id_scsxxth)
        ->bind(':id_iimxxmh', $id_iimxxmh)
        ->exec('SELECT
                    id as id_scsittd
                FROM scsittd
                WHERE id_iimxxmh = :id_iimxxmh AND id_scsxxth = :id_scsxxth
    ');
    
    $rs_scsittd = $qs_scsittd->fetch();

    $data = array(
        'id_scsittd' => $rs_scsittd['id_scsittd'],
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>