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

    $qs_wroittd = $db
        ->query('select', 'wroittd' )
        ->get([
            'wroittd.id as id_wroittd',
            'wroittd.jumlah_konversi as jumlah_konversi'
        ] )
        ->where('wroittd.id_wroxxth', $_POST['id_wroxxth'] )
        ->where('wroittd.id_iimxxmh', $_POST['id_iimxxmh'] )
        ->exec();

    $rs_wroittd = $qs_wroittd->fetch();

    $data = array(
        'rs_wroittd' => $rs_wroittd
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>