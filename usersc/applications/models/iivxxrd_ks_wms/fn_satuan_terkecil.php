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
    $qs_iumxxmh = $db
        ->raw()
        ->bind(':id_iimxxmh', $id_iimxxmh)
        ->exec('SELECT
                    b.kode
                FROM iimummd a
                LEFT JOIN iumxxmh b ON b.id = a.id_iumxxmh
                WHERE a.id_iimxxmh = :id_iimxxmh AND a.is_terkecil = 1
        '
        );

    $rs_iumxxmh = $qs_iumxxmh->fetch();
    $iumxxmh_kode = $rs_iumxxmh['kode'];
    
    $data = array(
        'iumxxmh_kode' => $iumxxmh_kode,
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>