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

    $id_hemxxmh = $_POST['id_hemxxmh'];
    $tanggal_awal = $_POST['tanggal_awal'];
    $tanggal_akhir = $_POST['tanggal_akhir'];

    $tanggal_awal = date('Y-m-d', strtotime($tanggal_awal));
    $tanggal_akhir = date('Y-m-d', strtotime($tanggal_akhir));

    $qs_htssctd = $db
        ->raw()
        ->bind(':id_hemxxmh', $id_hemxxmh )
        ->bind(':tanggal_awal', $tanggal_awal )
        ->bind(':tanggal_akhir', $tanggal_akhir )
        ->exec('SELECT
                    COUNT(a.id) c_jadwal
                FROM htssctd a
                WHERE a.transaction_state = 1 AND a.id_hemxxmh = :id_hemxxmh AND a.tanggal BETWEEN :tanggal_awal AND :tanggal_akhir AND TIME(a.tanggaljam_awal) <> "00:00:00"
    
    ');
    $rs_htssctd = $qs_htssctd->fetch();

    $data = array(
        'id_hemxxmh' => $id_hemxxmh,
        'c_jadwal' => $rs_htssctd['c_jadwal']
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>