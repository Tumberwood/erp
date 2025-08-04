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
    $uniqueToken = $_POST['uniqueToken'];
    $id_wpttpmh = $_POST['id_wpttpmh'];
    
    if ($id_wpttpmh == 2) {
        $where_wloctmh = 'AND rd.id_wloctmh IN (1,6)';
    } else {
        $where_wloctmh = 'AND rd.id_wloctmh = 1';
    }

    $qs_wloxxmh = $db
        ->raw()
        ->bind(':wlpxxmh_kode', $wlpxxmh_kode)
        ->bind(':uniqueToken', $uniqueToken)
        ->exec('SELECT
                    loc.id_wloxxmh id_wloxxmh_tujuan ,
                    r.id_wloxxmh id_wloxxmh_asal,
                    loc.id_iwhxxmh,
                    loc.wloxxmh_nama
                FROM (
                    -- bukan drive in
                    SELECT 
                        id_wloxxmh,
                        id_iwhxxmh,
                        wloxxmh_nama
                    FROM (
                        SELECT 
                            wimlotd.id_wloxxmh as id_wloxxmh,
                            wloxxmh.id_iwhxxmh as id_iwhxxmh,
                            wloxxmh.nama as wloxxmh_nama,
                            wloxxmh.id_wlotpmh
                        FROM wimlotd
                        LEFT JOIN wloxxmh ON wloxxmh.id = wimlotd.id_wloxxmh
                        LEFT JOIN 
                            iivxxrd ON iivxxrd.id_wloxxmh = wimlotd.id_wloxxmh AND 
                            wimlotd.id_iimxxmh = iivxxrd.id_iimxxmh
                        WHERE 1
                            AND id_wlotpmh <> 4
                            AND wimlotd.id_iimxxmh = 
                            (
                                SELECT 
                                    wreittd.id_iimxxmh
                                FROM wreittd
                                WHERE wreittd.wlpxxmh_kode = :wlpxxmh_kode
                            )
                            AND 
                                CASE 
                                WHEN wloxxmh.id_iumxxmh_kapasitas = 14 then 
                                    wimlotd.id_wloxxmh NOT IN ( -- yang location tidak termasuk dalam select dibawah ini
                                        SELECT -- select lokasi yang sudah masuk storage dan fisik 1 dan jumlah terkecil > 0
                                            a.id_wloxxmh
                                        FROM iivxxrd a
                                        WHERE a.id_wloctmh = 3 AND a.is_fisik = 1 AND a.wlpxxmh_kode <> :wlpxxmh_kode
                                        GROUP BY a.id_wloxxmh
                                        HAVING SUM(a.jumlah_terkecil) > 0
                                    )
                                ELSE 1
                            END
                            
                            AND wimlotd.id_wloxxmh NOT IN 
                            (
                                    SELECT
                                    c.id_wloxxmh_tujuan
                                FROM wreittd a
                                LEFT JOIN wimlotd b ON b.id_iimxxmh = a.id_iimxxmh
                                LEFT JOIN iivxxrd c ON c.id_iimxxmh = a.id_iimxxmh AND c.id_wloxxmh_tujuan = b.id_wloxxmh
                                WHERE a.wlpxxmh_kode = :wlpxxmh_kode  AND c.id_wloxxmh_tujuan > 0 AND c.keterangan <> :uniqueToken
                            )

                        ORDER BY wimlotd.urutan
                        LIMIT 1
                    ) location
                    
                    UNION all
                    
                    -- drive in
                    SELECT 
                        id_wloxxmh,
                        id_iwhxxmh,
                        wloxxmh_nama
                    FROM (
                        SELECT 
                            wimlotd.id_wloxxmh as id_wloxxmh,
                            wloxxmh.id_iwhxxmh as id_iwhxxmh,
                            wloxxmh.nama as wloxxmh_nama,
                            wloxxmh.id_wlotpmh
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
                                WHEN wloxxmh.id_iumxxmh_kapasitas = 14 then 
                                    wimlotd.id_wloxxmh NOT IN ( -- yang location tidak termasuk dalam select dibawah ini
                                        SELECT -- select lokasi yang sudah masuk storage dan fisik 1 dan jumlah terkecil > 0
                                            a.id_wloxxmh
                                        FROM iivxxrd a
                                        WHERE a.id_wloctmh = 3 AND a.is_fisik = 1 AND a.wlpxxmh_kode <> :wlpxxmh_kode
                                        GROUP BY a.id_wloxxmh
                                        HAVING SUM(a.jumlah_terkecil) > 0
                                    )
                                ELSE 1
                            END
                            
                            AND wimlotd.id_wloxxmh NOT IN 
                            (
                                    SELECT
                                    c.id_wloxxmh_tujuan
                                FROM wreittd a
                                LEFT JOIN wimlotd b ON b.id_iimxxmh = a.id_iimxxmh
                                LEFT JOIN iivxxrd c ON c.id_iimxxmh = a.id_iimxxmh AND c.id_wloxxmh_tujuan = b.id_wloxxmh
                                WHERE a.wlpxxmh_kode = :wlpxxmh_kode  AND c.id_wloxxmh_tujuan > 0 AND c.keterangan <> :uniqueToken
                            )

                            AND CONCAT(wloxxmh.rack_name,"-",wloxxmh.bay_name) NOT IN 
                            (
                                SELECT DISTINCT
                                    CONCAT(b.rack_name,"-",b.bay_name) item_udah_terisi
                                FROM iivxxrd a
                                LEFT JOIN wloxxmh b ON b.id = a.id_wloxxmh OR b.id = a.id_wloxxmh_tujuan
                                LEFT JOIN iimxxmh i ON i.id = a.id_iimxxmh
                                WHERE b.id_wlotpmh = 4
                                AND a.id_iimxxmh NOT IN (
                                    SELECT 
                                        wreittd.id_iimxxmh
                                    FROM wreittd
                                    WHERE wreittd.wlpxxmh_kode = :wlpxxmh_kode
                                )
                                ORDER BY a.id DESC
                            )
                            AND wloxxmh.status_drive_in IN ("in", "netral")
                        ORDER BY 
                            FIELD(wloxxmh.status_drive_in, "in", "netral"), 
                            wimlotd.urutan
                        LIMIT 1
                    ) drive_in
                    
                    UNION all
                    
                    -- OVERFLOW
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
                        WHERE b.id_wloctmh = 8 AND b.is_default = 1 AND a.wlpxxmh_kode = :wlpxxmh_kode
                        LIMIT 1
                    ) overflow
                ) loc
                LEFT JOIN (
                    SELECT
                        rd.id_wloxxmh,
                        rd.wlpxxmh_kode,
                        SUM(rd.jumlah_terkecil) s_terkecil
                    FROM iivxxrd rd
                    WHERE rd.wlpxxmh_kode = :wlpxxmh_kode 
                    '.$where_wloctmh.'
                    GROUP BY rd.id_wloxxmh
                    HAVING s_terkecil > 0
                ) r ON r.wlpxxmh_kode = :wlpxxmh_kode
        ');

    $rs_wloxxmh = $qs_wloxxmh->fetch();

    $qs_wpttpmh = $db
        ->query('select', 'wpttpmh' )
        ->get([
            'CONCAT(kode," - ",nama) as text'
        ] )
        ->where('id', 2 )
        ->exec();
    $rs_wpttpmh = $qs_wpttpmh->fetch();

    
    $qs_asal = $db
        ->raw()
        ->bind(':wlpxxmh_kode', $wlpxxmh_kode)
        ->exec('SELECT
                    rd.id_wloxxmh,
                    rd.wlpxxmh_kode,
                    rd.id_wloctmh,
                    SUM(rd.jumlah_terkecil) s_terkecil
                FROM iivxxrd rd
                WHERE rd.wlpxxmh_kode = :wlpxxmh_kode AND rd.id_wloctmh IN (1,6)
                GROUP BY rd.id_wloxxmh
                HAVING s_terkecil > 0
        '
        );

    $rs_asal = $qs_asal->fetch();
    if(!empty($rs_asal)){
        $id_wloctmh = $rs_asal['id_wloctmh'];
    } else {
        $id_wloctmh = 0;
    }

    $jenis_put = $rs_wpttpmh['text'];

    if(empty($rs_wloxxmh)){
        $status_code = 500;
        $message = 'Loc Pref Tidak ditemukan!';
        $type_message = 'error';
        $id_wloxxmh_asal = 0;
        $id_wloxxmh_tujuan = 0;
        $wloxxmh_nama = '';
        $id_iwhxxmh = '';
    }else{
        $status_code = 200;
        $message = '';
        $type_message = 'success';
        $id_wloxxmh_asal = $rs_wloxxmh['id_wloxxmh_asal'];
        $id_wloxxmh_tujuan = $rs_wloxxmh['id_wloxxmh_tujuan'];
        $wloxxmh_nama = $rs_wloxxmh['wloxxmh_nama'];
        $id_iwhxxmh = $rs_wloxxmh['id_iwhxxmh'];
    }

    $data = array(
        'status_code'    => $status_code,
        'message'        => $message,
        'type_message'   => $type_message,
        'id_wloxxmh_asal' => $id_wloxxmh_asal,
        'id_wloxxmh_tujuan' => $id_wloxxmh_tujuan,
        'wloxxmh_nama' => $wloxxmh_nama,
        'id_iwhxxmh' => $id_iwhxxmh,
        'jenis_put' => $jenis_put,
        'id_wloctmh' => $id_wloctmh,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>