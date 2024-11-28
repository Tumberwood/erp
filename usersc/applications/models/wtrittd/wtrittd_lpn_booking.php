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
    $id_wloxxmh_asal = $_POST['id_wloxxmh_asal'];

    // $qs_iivxxrd = $db
    //     ->raw()
    //     ->bind(':wlpxxmh_kode', $wlpxxmh_kode)
    //     ->exec('SELECT
    //                 COUNT(id) AS c_id,
    //                 SUM(a.jumlah_terkecil) s_terkecil,
    //                 SUM(a.jumlah_unit) s_unit
    //             FROM iivxxrd a
    //             WHERE a.wlpxxmh_kode = :wlpxxmh_kode AND a.id_wloctmh IN (3,4) AND a.is_fisik = 0
    //             HAVING s_unit < 0
    //     '
    //     );
    // $rs_iivxxrd = $qs_iivxxrd->fetch();

    $qs_iivxxrd = $db
        ->raw()
        ->bind(':wlpxxmh_kode', $wlpxxmh_kode)
        ->bind(':id_wloxxmh_asal', $id_wloxxmh_asal)
        ->exec('WITH iiv AS (
                    SELECT
                        a.id_wloxxmh,
                        a.id_wloctmh,
                        a.iwhxxmh_kode,
                        a.wloxxmh_nama,
                        a.iimxxmh_kode,
                        a.iimxxmh_nama,
                        a.iumxxmh_default_kode,
                        a.iumxxmh_terkecil_kode,
                        SUM(jumlah_default * is_fisik) as jumlah_default,
                        SUM(jumlah_terkecil * is_fisik) as jumlah_terkecil,
                        ifnull(jumlah_default_booking,0) as jumlah_default_booking,
                        ifnull(jumlah_terkecil_booking,0) as jumlah_terkecil_booking,
                        (SUM(jumlah_default * is_fisik)) - ifnull(jumlah_default_booking,0) as jumlah_default_ava,
                        (SUM(jumlah_terkecil * is_fisik)) - ifnull(jumlah_terkecil_booking,0) as jumlah_terkecil_ava,
                        a.wlpxxmh_kode,
                        max(batch_number) batch_number,
                        max(date_format(expired_date,"%d %b %Y")) as expired_date
                    FROM iivxxrd a
                    LEFT JOIN (
                        SELECT
                            wloxxmh_nama,
                            iimxxmh_kode,
                            SUM(jumlah_default) * -1 as jumlah_default_booking,
                            SUM(jumlah_terkecil) * -1 as jumlah_terkecil_booking,
                            wlpxxmh_kode
                        FROM iivxxrd
                        WHERE tanggal <= curdate() AND is_fisik = 0
                        GROUP BY 
                            -- id_gbrxxmh, 
                            id_iwhxxmh,
                            id_iimxxmh,
                            id_wloxxmh,
                            wlpxxmh_kode
                    ) AS b ON b.wloxxmh_nama = a.wloxxmh_nama AND b.iimxxmh_kode = a.iimxxmh_kode AND b.wlpxxmh_kode = a.wlpxxmh_kode
                    WHERE tanggal <= curdate()
                    GROUP BY 
                        -- id_gbrxxmh, 
                        id_iwhxxmh,
                        id_iimxxmh,
                        id_wloxxmh,
                        wlpxxmh_kode
                    having jumlah_terkecil > 0 AND wlpxxmh_kode = :wlpxxmh_kode AND jumlah_terkecil_booking > 0 AND id_wloxxmh = :id_wloxxmh_asal
                )
                SELECT
                    count(id_wloxxmh) c_id
                FROM iiv
        '
        );
    $rs_iivxxrd = $qs_iivxxrd->fetch();

    if(empty($rs_iivxxrd)){
        $status_code = 500;
        $message = 'LPN yang dibooking Tidak Ada!';
        $type_message = 'error';
        
        $c_id        = 0;

    }else{
        $status_code = 200;
        $message = '';
        $type_message = 'success';

        $c_id        = $rs_iivxxrd['c_id'];
        
    }

    $data = array(
        'status_code'       => $status_code,
        'message'           => $message,
        'type_message'      => $type_message,

        'c_id'        => $c_id,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>