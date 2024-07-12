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

    $id_h = $_POST['id_isoxxth_upload_filter'];
    $qs_def = $db
        ->raw()
        ->bind(':id_h', $id_h)
        ->exec('SELECT
                    is_update_transaksi
                FROM isoxxth_upload a
                WHERE a.id = :id_h
        ');
    $rs_def = $qs_def->fetch();
    $is_update_transaksi_h = $rs_def['is_update_transaksi'];

    $data = array(
        'is_update_transaksi_h' => $is_update_transaksi_h
    );
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>