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
    
    $qs_data = $db
        ->raw()
        ->exec('SELECT
                    a.kode,
                    a.nama
                FROM httlpmh a
                
                UNION ALL
                
                SELECT
                    "HK" AS kode,
                    "Hari Kerja" AS nama
                
                UNION ALL
                
                SELECT
                    "Cuti Khusus" AS kode,
                    "Cuti Khusus" AS nama
                ;
    ');

    $rs_data = $qs_data->fetchAll();
    $data_master = [];
    foreach ($rs_data as $row) {
        $data_master[$row['kode']] = $row['nama'];
    }
    
    $qs_peg = $db
        ->raw()
        ->exec('SELECT
                    a.kode,
                    a.nama,
                    a.id id_hemxxmh
                FROM hemxxmh a
                LEFT JOIN hemjbmh b on b.id_hemxxmh = a.id
                WHERE a.transaction_state = 1
                AND b.tanggal_masuk <= curdate() AND (b.tanggal_keluar IS NULL OR b.tanggal_keluar > curdate()) 
                ;
    ');

    $rs_peg = $qs_peg->fetchAll();
    $peg_master = [];
    foreach ($rs_peg as $row) {
        $peg_master[$row['nama']] = $row['id_hemxxmh'];
    }
    
    $data = array(
        'data_master' => $data_master,
        'peg_master' => $peg_master,
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>