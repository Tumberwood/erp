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

    $qs_c_pl = $db
        ->raw()
        ->exec('SELECT
                    COUNT(id) AS c_id
                FROM wktxxth a
                WHERE a.is_generate_lpn = 1 AND a.transaction_state NOT IN (1,-9,8,9)
        '
        );

    $rs_c_pl = $qs_c_pl->fetch();
    $c_id  = $rs_c_pl['c_id'];

    if(empty($rs_c_pl)){
        $status_code = 500;
        $message = 'PL ERROR!';
        $type_message = 'error';

    }else{
        $status_code = 200;
        $message = '';
        $type_message = 'success';
        
    }

    $data = array(
        'status_code'       => $status_code,
        'message'           => $message,
        'type_message'      => $type_message,

        'c_id'        => $c_id,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>