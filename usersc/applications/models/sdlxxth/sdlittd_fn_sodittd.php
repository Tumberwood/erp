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
            'sodittd.id_sodxxth as id_sodxxth',
            'sodittd.jumlah_konversi as jumlah_konversi',
            'sodittd.harga_unit as harga_unit',
            'sodittd.diskon_jenis as diskon_jenis',
            'sodittd.diskon_persen as diskon_persen',
            'sodittd.diskon_value as diskon_value'
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