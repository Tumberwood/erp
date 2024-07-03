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
    $id_wpcxxth_old = $_POST['id_wpcxxth_old'];

    $qs_detail = $db
        
        ->raw()
        ->bind(':id_wpcxxth_old', $id_wpcxxth_old)
        ->exec('SELECT
                    count(c.id) as c_id
                FROM wdplptd c
                WHERE c.id_wpcxxth = :id_wpcxxth_old AND c.id_wdpxxth = 0
    
        '
        );
    $rs_detail = $qs_detail->fetch();

    if(empty($rs_detail)){
        $status_code = 500;
        $message = 'Error Kode Picking';
        $type_message = 'error';
        
        $c_id_d        = 0;

    }else{
        $status_code = 200;
        $message = '';
        $type_message = 'success';

        $c_id_d = $rs_detail['c_id'];
        
    }

    $data = array(
        'status_code'       => $status_code,
        'message'           => $message,
        'type_message'      => $type_message,

        'c_id_d'        => $c_id_d
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>