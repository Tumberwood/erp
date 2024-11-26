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

    $id_wktxxth = $_POST['id_wktxxth'];

    $qs_wktlptd = $db
        ->raw()
        ->bind(':id_wktxxth', $id_wktxxth)
        ->exec('SELECT
                    COUNT(a.id) c_id
                FROM wktlptd a
                WHERE a.status_picking <> 3 AND a.id_wktxxth = :id_wktxxth
        '
        );

    $rs_wktlptd = $qs_wktlptd->fetch();
    $c_id  = $rs_wktlptd['c_id'];

    $qs_finalisasi = $db
        ->raw()
        ->bind(':id_wktxxth', $id_wktxxth)
        ->exec('SELECT
                    SUM(a.jumlah_unit) s_jumlah_unit
                FROM wktrstd a
                WHERE a.id_wktxxth = :id_wktxxth
        '
        );
    $rs_finalisasi = $qs_finalisasi->fetch();
    $s_jumlah_unit  = $rs_finalisasi['s_jumlah_unit'];

    //ambil nilai terkecil dari datail
    $qs_terkecil_d = $db
        ->raw()
        ->bind(':id_wktxxth', $id_wktxxth)
        ->exec('SELECT
                    MIN(a.jumlah_unit) min_jumlah_unit
                FROM wktlptd a
                WHERE a.id_wktxxth = :id_wktxxth
        '
        );
    $rs_terkecil_d = $qs_terkecil_d->fetch();
    $min_jumlah_unit  = $rs_terkecil_d['min_jumlah_unit'];
    

    if(empty($rs_wktlptd)){
        $status_code = 500;
        $message = 'Kitting ERROR!';
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
        's_jumlah_unit'        => $s_jumlah_unit,
        'min_jumlah_unit'        => $min_jumlah_unit,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>