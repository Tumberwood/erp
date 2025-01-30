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

    $qs_uom = $db
        ->raw()
        ->bind(':id_iimxxmh', $_POST['id_iimxxmh'])
        ->exec('SELECT
                    id_iumxxmh
                FROM iimummd
                WHERE id_iimxxmh = :id_iimxxmh AND is_iumxxmh_beli = 1 AND transaction_state <> -9
    ');
    $rs_uom = $qs_uom->fetch();

    $id_iumxxmh = $rs_uom['id_iumxxmh'];

    $data = array(
        'id_iumxxmh' => $id_iumxxmh
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>