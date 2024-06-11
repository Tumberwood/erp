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

    $qs_ggswsmh = $db
    ->raw()
    ->bind(':wlpxxmh_kode', $wlpxxmh_kode)
    ->bind(':wloxxmh_nama_scan', $wloxxmh_nama_scan)
    ->exec('SELECT
                loc.id_wloxxmh id_wloxxmh_tujuan ,
                r.id_wloxxmh id_wloxxmh_asal,
                loc.id_iwhxxmh,
                loc.wloxxmh_nama
            FROM (
                SELECT 
                    id_wloxxmh,
                    id_iwhxxmh,
                    wloxxmh_nama
                FROM (
                    SELECT 
                        wimlotd.id_wloxxmh as id_wloxxmh,
                        wloxxmh.id_iwhxxmh as id_iwhxxmh,
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
                            WHEN wloxxmh.id_iumxxmh_kapasitas = 5 then iivxxrd.id_wloxxmh IS NULL
                            ELSE ""
                        END
                        
                    ORDER BY wimlotd.urutan
                ) location
                
                UNION all
                
                SELECT
                    id_wloxxmh,
                    id_iwhxxmh,
                    wloxxmh_nama
                FROM (
                    SELECT
                        b.id as id_wloxxmh,
                        b.id_iwhxxmh,
                        b.nama as wloxxmh_nama
                    FROM wreittd a
                    LEFT JOIN wloxxmh b ON b.id_iwhxxmh = a.id_iwhxxmh
                    WHERE b.id_wloctmh = 3 AND b.is_defaultprogram = 1 AND a.wlpxxmh_kode = :wlpxxmh_kode
                    LIMIT 1
                ) overflow
            ) loc
            LEFT JOIN (
                SELECT
                    rd.id_wloxxmh,
                    rd.wlpxxmh_kode
                FROM iivxxrd rd
                WHERE rd.wlpxxmh_kode = :wlpxxmh_kode 
                LIMIT 1
            ) r ON r.wlpxxmh_kode = :wlpxxmh_kode
            WHERE wloxxmh_nama = :wloxxmh_nama_scan
    '
    );
    $rs_ggswsmh = $qs_ggswsmh->fetch();
    
    if(empty($rs_ggswsmh)){
        $status_code = 500;
        $message = 'LPN yang dibooking Tidak Ada!';
        $type_message = 'error';
        $id_wloxxmh_tujuan = 0;
        
    }else{
        $status_code = 200;
        $message = '';
        $type_message = 'success';
        
        $id_wloxxmh_tujuan = $rs_ggswsmh['id_wloxxmh_tujuan'];
        
    }

    $data = array(
        'status_code'       => $status_code,
        'message'           => $message,
        'type_message'      => $type_message,

        'id_wloxxmh_tujuan'        => $id_wloxxmh_tujuan,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>