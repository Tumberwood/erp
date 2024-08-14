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
    $id_putaway_header = $_POST['id_putaway_header'];
    $id_wpttpmh = $_POST['id_wpttpmh'];
    
    if ($id_wpttpmh == 2) {
        $where_wloctmh = 'AND rd.id_wloctmh IN (1,6)';
    } else {
        $where_wloctmh = 'AND rd.id_wloctmh = 1';
    }

    if ($id_putaway_header > 0) {
        //cek apakah lokasi tujuan sudah pernah diinsert di detail lain?
		$qs_wptittd = $db
            ->raw()
            ->bind(':id_putaway_header', $id_putaway_header)
            ->exec('SELECT
                        b.id_wloxxmh_tujuan
                    FROM wptxxth a
                    LEFT JOIN wptittd b ON b.id_wptxxth = a.id
                    WHERE a.id = :id_putaway_header
            '
			);
	
		$rs_wptittd = $qs_wptittd->fetchAll();
        $ids = [];

        // Loop through the results and collect IDs
        foreach ($rs_wptittd as $row) {
            $ids[] = $row['id_wloxxmh_tujuan'];
        }

        $id_list = '('.implode(',', $ids).')';

        $where_loc = ' AND wloxxmh.id NOT IN '.$id_list;
    } else {
        $where_loc = '';
    }

    $qs_wloxxmh = $db
        ->raw()
        ->bind(':wlpxxmh_kode', $wlpxxmh_kode)
        ->bind(':id_putaway_header', $id_putaway_header)
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
                            '.$where_loc.'
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
                                WHERE a.wlpxxmh_kode = :wlpxxmh_kode  AND c.id_wloxxmh_tujuan > 0
                            )

                        ORDER BY wimlotd.urutan
                        LIMIT 1
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