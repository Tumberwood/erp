<?php 
    /**
     * Digunakan untuk populate options data httxxrd
     * Table terkait    : httxxrd
     * Parameter        : 
     *  - id_httxxrd_old       : data existing (untuk keperluan edit), dipakai di query self
     */
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    // END definisi variable untuk fn_ajax_results.php

    // $qs_httxxrd = $db
    //     ->raw()
    //     ->exec('SELECT DISTINCT
    //                 a.id_transaksi,
    //                 concat(httlpmh_kode, " - ", kode) as title,
    //                 DATE_FORMAT(concat(tanggal, " ", ifnull(jam_awal, "00:00:00") ), "%Y-%m-%dT%T") as start,
    //                 DATE_FORMAT(concat(tanggal, " ", ifnull(jam_akhir, "00:00:00") ), "%Y-%m-%dT%T") as end
    //             FROM httxxrd a
    //             WHERE a.id_httlpmh > 0 -- ini yang tampil hanya yang transaksi Leave and Permission, karena di httxxrd juga menyimpan saldo cuti dan sisa saldo
    //     '
    //     );

    // $rs_httxxrd = $qs_httxxrd->fetchAll();
    
    //ini bisa long event
    $qs_httxxrd = $db
        ->raw()
        ->exec('SELECT DISTINCT
                    a.id_transaksi,
                    concat(httlpmh_kode, " - ", a.kode) as title,
                    if(a.jenis = 2, DATE_FORMAT(MIN(concat(tanggal, " ", ifnull(jam_awal, "00:00:00") )), "%Y-%m-%dT%T"), MIN(tanggal)) as start,
                    if(a.jenis = 2, DATE_FORMAT(Max(CONCAT(tanggal, " ", IFNULL(jam_akhir, "00:00:00") )), "%Y-%m-%dT%T"), MAX(tanggal)) AS end ,
	                if(a.kode LIKE "CB/%", concat("../../views/httgltd/httgltd.php?rowId=", id_transaksi), concat("../../views/httlptd/httlptd.php?rowId=", id_transaksi) ) AS url,
	                b.warna as color
                FROM httxxrd a
                LEFT JOIN httlpmh b on b.id = a.id_httlpmh
                WHERE a.id_httlpmh > 0
                GROUP BY a.kode
        '
        );

    $rs_httxxrd = $qs_httxxrd->fetchAll();

    $data = array(
        'rs_httxxrd' => $rs_httxxrd
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>