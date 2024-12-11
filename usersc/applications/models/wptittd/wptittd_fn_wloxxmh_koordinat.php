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
                    SELECT 
                        id_wloxxmh,
                        id_iwhxxmh,
                        wloxxmh_nama,
                        -- wloxxmh_asal,
                        -- tujuan_koord_x,
                        -- tujuan_koord_y,
                        -- tujuan_koord_z,
                        -- asal_koord_x,
                        -- asal_koord_y,
                        -- asal_koord_z,
                        -- hasil_koor_x,
                        -- hasil_koor_y,
                        -- hasil_koor_z,
                        -- is_koordinat,
                        -- koefisien_level,
                        -- urutan,
                        -- sum_koor,
                        loc_alogritma
                    FROM (
                        SELECT 
                            wimlotd.id_wloxxmh as id_wloxxmh,
                            wloxxmh.id_iwhxxmh as id_iwhxxmh,
                            wloxxmh.nama as wloxxmh_nama,
	                        --  asal.nama wloxxmh_asal,
	                        --  wloxxmh.koord_x tujuan_koord_x,
	                        --  wloxxmh.koord_y tujuan_koord_y,
	                        --  wloxxmh.koord_z tujuan_koord_z,
	                        --  asal.koord_x asal_koord_x,
	                        --  asal.koord_y asal_koord_y,
	                        --  asal.koord_z asal_koord_z,
                            -- ABS(wloxxmh.koord_x - asal.koord_x) hasil_koor_x,
                            -- ABS(wloxxmh.koord_y - asal.koord_y) hasil_koor_y,
                            -- ABS(wloxxmh.koord_z - asal.koord_z) * koefisien_level hasil_koor_z,
                            --  gg.is_koordinat,
                            --  gg.koefisien_level,
                            -- wimlotd.urutan,
                            -- ABS(wloxxmh.koord_x - asal.koord_x) + ABS(wloxxmh.koord_y - asal.koord_y) + (ABS(wloxxmh.koord_z - asal.koord_z) * koefisien_level) sum_koor,
                            if(is_koordinat = 0, 
                                wimlotd.urutan,
                                ABS(wloxxmh.koord_x - asal.koord_x) + ABS(wloxxmh.koord_y - asal.koord_y) + (ABS(wloxxmh.koord_z - asal.koord_z) * koefisien_level)
                            ) loc_alogritma
                        FROM wimlotd
                        LEFT JOIN wloxxmh ON wloxxmh.id = wimlotd.id_wloxxmh
                        LEFT JOIN 
                            iivxxrd ON iivxxrd.id_wloxxmh = wimlotd.id_wloxxmh AND 
                            wimlotd.id_iimxxmh = iivxxrd.id_iimxxmh
                     	LEFT JOIN (
			                    SELECT
			                        rd.id_wloxxmh,
			                        rd.wlpxxmh_kode,
			                        SUM(rd.jumlah_terkecil) s_terkecil
			                    FROM iivxxrd rd
			                    WHERE rd.wlpxxmh_kode = :wlpxxmh_kode 
			                    AND rd.id_wloctmh = 1
			                    GROUP BY rd.id_wloxxmh
			                    HAVING s_terkecil > 0
			                ) iiv_asal ON iiv_asal.wlpxxmh_kode = :wlpxxmh_kode
                        LEFT JOIN wloxxmh asal ON asal.id = iiv_asal.id_wloxxmh
                        LEFT JOIN ggswmsh gg on gg.id = 1
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

                        ORDER BY loc_alogritma ASC
                        LIMIT 1
                    ) location
                    
                    UNION all
                    
                    SELECT
                        id_wloxxmh,
                        id_iwhxxmh,
                        wloxxmh_nama,
                        0 loc_alogritma
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