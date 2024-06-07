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

    $qs_wloxxmh = $db
        ->raw()
        ->bind(':wlpxxmh_kode', $wlpxxmh_kode)
        ->exec('
            SELECT 
                wimlotd.id_wloxxmh as id_wloxxmh,
                wloxxmh.id_iwhxxmh,
                wloxxmh.nama as wloxxmh_nama
            FROM wimlotd
            LEFT JOIN wloxxmh ON wloxxmh.id = wimlotd.id_wloxxmh
            LEFT JOIN 
                iivxxrd ON iivxxrd.id_wloxxmh = wimlotd.id_wloxxmh AND 
                wimlotd.id_iimxxmh = iivxxrd.id_iimxxmh
            WHERE 1
                AND wimlotd.id_iimxxmh = 
                (
                    SELECT 
                        wreittd.id_iimxxmh
                    FROM wreittd
                    WHERE wreittd.wlpxxmh_kode = :wlpxxmh_kode
                )
                AND 
                CASE 
	                WHEN wloxxmh.id_iumxxmh_kapasitas = 14 then iivxxrd.id_wloxxmh IS NULL
	                ELSE ""
                END
            ORDER BY wimlotd.urutan
            LIMIT 1
        ');

    $rs_wloxxmh = $qs_wloxxmh->fetch();

    if(empty($rs_wloxxmh)){
        $status_code = 500;
        $message = 'Loc Pref Tidak ditemukan!';
        $type_message = 'error';
        $id_wloxxmh = 0;
        $wloxxmh_nama = '';
        $id_iwhxxmh = '';
    }else{
        $status_code = 200;
        $message = '';
        $type_message = 'success';
        $id_wloxxmh = $rs_wloxxmh['id_wloxxmh'];
        $wloxxmh_nama = $rs_wloxxmh['wloxxmh_nama'];
        $id_iwhxxmh = $rs_wloxxmh['id_iwhxxmh'];
    }

    $data = array(
        'status_code'    => $status_code,
        'message'        => $message,
        'type_message'   => $type_message,
        'id_wloxxmh' => $id_wloxxmh,
        'wloxxmh_nama' => $wloxxmh_nama,
        'id_iwhxxmh' => $id_iwhxxmh,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>