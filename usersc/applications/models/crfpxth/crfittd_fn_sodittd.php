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

    $qs_sodittd = $db
        ->query('select', 'sodittd' )
        ->get([
            'sodittd.id as id_sodittd',
            'sodittd.id_iumxxmh_unit as id_iumxxmh_unit',
            'DATE_FORMAT(sodittd.tanggal_dibutuhkan, "%d %b %Y") as tanggal_dibutuhkan',
        ] )
        ->where('sodittd.id_sodxxth', $_POST['id_sodxxth'] )
        ->where('sodittd.id_iimxxmh', $_POST['id_iimxxmh'] )
        ->exec();

    $rs_sodittd = $qs_sodittd->fetch();

    $data = array(
        'rs_sodittd' => $rs_sodittd
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>