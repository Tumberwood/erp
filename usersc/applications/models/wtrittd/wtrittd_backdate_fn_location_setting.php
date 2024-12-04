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
    $wloxxmh_nama_scan = $_POST['wloxxmh_nama_scan'];
    $wlpxxmh_kode = $_POST['wlpxxmh_kode'];
    $is_gabung_lpn = $_POST['is_gabung_lpn'];
    $id_iimxxmh = $_POST['id_iimxxmh'];
    $id_iumxxmh_unit = $_POST['id_iumxxmh_unit'];
    $keterangan = $_POST['keterangan'];
    
    $is_next = 0;
    $is_inventory = 0;
    // print_r($wloxxmh_nama_scan);
    // print_r($id_iimxxmh);
    
    $qs_loc_pref = $db
        ->raw()
        ->bind(':wloxxmh_nama_scan', $wloxxmh_nama_scan)
        ->bind(':id_iimxxmh', $id_iimxxmh)
        ->exec('SELECT
                    b.id id_wloxxmh_tujuan,
                    b.nama,
                    a.urutan,
                    a.id_iimxxmh,
                    b.kapasitas,
                    b.id_iumxxmh_kapasitas,
                    c.kode
                FROM wimlotd a
                LEFT JOIN wloxxmh b ON b.id = a.id_wloxxmh OR (b.is_default = 1 AND b.id_wloctmh IN (3,4))
                LEFT JOIN iumxxmh c ON c.id = b.id_iumxxmh_kapasitas
                WHERE a.id_iimxxmh = :id_iimxxmh AND b.nama = :wloxxmh_nama_scan
                GROUP BY b.id
                ORDER BY
                CASE
                    WHEN b.nama NOT LIKE "Overflow%" THEN a.urutan
                    ELSE 9999
                END ASC,
                b.nama ASC; 
        '
        );

    $rs_loc_pref = $qs_loc_pref->fetch();

    $qs_loc_pref = $db
        ->raw()
        ->bind(':wloxxmh_nama_scan', $wloxxmh_nama_scan)
        ->exec('SELECT
                    b.id id_wloxxmh_tujuan,
                    b.nama
                FROM wloxxmh b
                WHERE b.nama = :wloxxmh_nama_scan; 
        '
        );

    $rs_loc_pref = $qs_loc_pref->fetch();

    if(empty($rs_loc_pref)){
        $status_code = 500;
        $message = 'Lokasi tidak terdaftar!';
        $type_message = 'error';

        $id_wloxxmh_tujuan = 0;
        
    }else{
        $status_code = 200;
        $message = '';
        $type_message = 'success';
        
        $id_wloxxmh_tujuan = $rs_loc_pref['id_wloxxmh_tujuan'];
        
    }

    $data = array(
        'status_code'       => $status_code,
        'message'           => $message,
        'type_message'      => $type_message,

        'id_wloxxmh_tujuan'        => $id_wloxxmh_tujuan,
        'is_gabung_lpn'        => $is_gabung_lpn,
        'is_inventory'        => $is_inventory,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>