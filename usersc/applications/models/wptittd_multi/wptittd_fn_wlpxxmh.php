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
    $wlpxxmh_kode = $_POST['wlpxxmh_kode'];

    $qs_wlpxxmh = $db
        ->query('select', 'wlpxxmh' )
        ->get([
            'wlpxxmh.id as id'
        ] )
        
        ->where('wlpxxmh.kode', $wlpxxmh_kode )
        ->exec();
    $rs_wlpxxmh = $qs_wlpxxmh->fetch();
    if(empty($rs_wlpxxmh)){
        $status_code = 500;
        $message = 'LPN tidak terdaftar!';
        $type_message = 'error';
        $wlpxxmh_kode_status = 0;
    }else{

        $qs_wptittd = $db
            ->query('select', 'wptittd' )
            ->get([
                'count(wptittd.id) as c_id'
            ] )
            
            ->join('wptxxth','wptxxth.id = wptittd.id_wptxxth','LEFT' )
            ->where('wptittd.created_by', $s_id_users )
            ->where('wptxxth.transaction_state', 0)
            ->where('wptittd.transaction_state', 0)
            ->where('wptittd.wlpxxmh_kode', $wlpxxmh_kode )
            ->exec();
        $rs_wptittd = $qs_wptittd->fetch();
        $c_id = $rs_wptittd['c_id'];
        
        if($c_id > 0){
            $status_code = 500;
            $message = 'LPN tidak boleh kembar!';
            $type_message = 'error';
            $wlpxxmh_kode_status = 0;
        }else{
            $status_code = 200;
            $message = '';
            $type_message = 'success';
            $wlpxxmh_kode_status = 1;
        }
    }

    $data = array(
        'status_code'    => $status_code,
        'message'        => $message,
        'type_message'   => $type_message,
        'wlpxxmh_kode_status' => $wlpxxmh_kode_status,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>