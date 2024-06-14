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

    $qs_podittd = $db
        ->query('select', 'podittd' )
        ->get([
            'podittd.id as id_podittd',
            'podittd.jumlah_konversi as jumlah_konversi'
        ] )
        ->where('podittd.id_podxxth', $_POST['id_podxxth'] )
        ->where('podittd.id_iimxxmh', $_POST['id_iimxxmh'] )
        ->exec();

    $rs_podittd = $qs_podittd->fetch();

    $data = array(
        'rs_podittd' => $rs_podittd
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>