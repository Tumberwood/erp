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

    $ids_itoxxth   = $_POST['ids_itoxxth'];
    $id_iimxxmh = $_POST['id_iimxxmh'];
    $id_iumxxmh = $_POST['id_iumxxmh'];
    $jumlah_unit = $_POST['jumlah_unit'];
    $jumlah_unit_old = $_POST['jumlah_unit_old'];

    $qs_out = $db
        ->raw()
        ->exec('SELECT 
                    concat(ROUND( (a.jumlah_terkecil_os + IFNULL(jumlah_old, 0)) / a.jumlah_konversi), " ", c.nama) AS text,
                    a.id_iumxxmh,
                    a.jumlah_terkecil_os + IFNULL(d.jumlah_old, 0)  AS jumlah_terkecil_os,
                    a.jumlah_terkecil
                FROM itoittd AS a
                LEFT JOIN iimummd AS b ON b.id_iumxxmh = a.id_iumxxmh AND b.id_iimxxmh = a.id_iimxxmh
                LEFT JOIN iumxxmh AS c ON c.id = a.id_iumxxmh
                LEFT JOIN (
                    SELECT 
                        ROUND(a.jumlah_konversi * '.$jumlah_unit_old.', 2) AS jumlah_old,
                        c.nama AS satuan
                    FROM iimummd AS a
                    LEFT JOIN iumxxmh AS c ON c.id = '.$id_iumxxmh.'
                    WHERE a.id_iimxxmh = '.$id_iimxxmh.' AND a.id_iumxxmh = ' .$id_iumxxmh . '
                ) AS d on d.jumlah_old > 0

                WHERE a.id_itoxxth = '.$ids_itoxxth.' AND a.id_iimxxmh = ' . $id_iimxxmh
                );

    $rs_out = $qs_out->fetch();

    $qs_in = $db
        ->raw()
        ->exec('SELECT 
                    ROUND(a.jumlah_konversi * '.$jumlah_unit.', 2) AS jumlah_terkecil,
                    ROUND(a.jumlah_konversi * '.$jumlah_unit_old.', 2) AS jumlah_old,
                    c.nama AS satuan
                FROM iimummd AS a
                LEFT JOIN iumxxmh AS c ON c.id = '.$id_iumxxmh.'
                WHERE a.id_iimxxmh = '.$id_iimxxmh.' AND a.id_iumxxmh = ' .$id_iumxxmh
                );
    $rs_in = $qs_in->fetch();

    $terkecil_in = $rs_in['jumlah_terkecil'];
    
    $data = array(
        'rs_out' => $rs_out,
        'rs_in' => $rs_in
    );
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>