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

    // ambil variable dari ajax data
    $wloxxmh_nama_asal = $_POST['wloxxmh_nama_asal'];

    $qs_loc = $db
        ->raw()
        ->bind(':wloxxmh_nama_asal', $wloxxmh_nama_asal)
        ->exec('SELECT
                    id AS id_loc
                FROM wloxxmh a
                WHERE a.nama = :wloxxmh_nama_asal AND transaction_state <> -9
        '
        );
    $rs_loc = $qs_loc->fetch();

    if(empty($rs_loc)){
        $status_code = 500;
        $message = 'LPN yang dibooking Tidak Ada!';
        $type_message = 'error';
        
        $id_loc        = 0;

    }else{
        $status_code = 200;
        $message = '';
        $type_message = 'success';

        $id_loc        = $rs_loc['id_loc'];
        
    }

    $data = array(
        'status_code'       => $status_code,
        'message'           => $message,
        'type_message'      => $type_message,

        'id_loc'        => $id_loc,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>