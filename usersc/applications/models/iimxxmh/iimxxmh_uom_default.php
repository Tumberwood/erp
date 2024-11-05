<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : gbrxxmh
     * Parameter        : 
     *  - id_gbrxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
     */
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    require_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    $id_iimxxmh = $_POST['id_iimxxmh'];
    $qs_htssctd = $db
        ->raw()
        ->bind(':id_iimxxmh', $id_iimxxmh )
        ->exec('SELECT
                    COUNT(a.id) c_id
                FROM iimummd a
                WHERE a.id_iimxxmh = :id_iimxxmh AND a.transaction_state <> -9 AND a.is_default = 1
    
    ');
    $rs_htssctd = $qs_htssctd->fetch();

    $data = array(
        'id_iimxxmh' => $id_iimxxmh,
        'c_id' => $rs_htssctd['c_id']
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>