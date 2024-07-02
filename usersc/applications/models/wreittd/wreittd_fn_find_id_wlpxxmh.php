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

    $qs_wlpxxmh = $db
        ->query('select', 'wlpxxmh' )
        ->get([
            'wlpxxmh.id as id_wlpxxmh'
        ] )
        ->where('wlpxxmh.kode', $_POST['wlpxxmh_kode'] )
        ->exec();

    $rs_wlpxxmh = $qs_wlpxxmh->fetch();

    if (!empty($rs_wlpxxmh)) {
        $id_wlpxxmh = $rs_wlpxxmh['id_wlpxxmh'];
    } else {
        $id_wlpxxmh = 0;
    }

    $data = array(
        'id_wlpxxmh' => $id_wlpxxmh
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>