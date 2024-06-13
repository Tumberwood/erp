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

    $qs_itoittd = $db
        ->query('select', 'itoittd' )
        ->get([
            'itoittd.id as id_itoittd',
            'itoittd.jumlah_konversi as jumlah_konversi'
        ] )
        ->where('itoittd.id_itoxxth', $_POST['id_itoxxth'] )
        ->where('itoittd.id_iimxxmh', $_POST['id_iimxxmh'] )
        ->exec();

    $rs_itoittd = $qs_itoittd->fetch();

    $data = array(
        'rs_itoittd' => $rs_itoittd
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>