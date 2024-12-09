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
    $id_wlpxxmh = $_POST['id_wlpxxmh'];
    $qs_kit = $db
        ->raw()
        ->bind(":id_wlpxxmh", $id_wlpxxmh)
        ->exec('SELECT
                    lpn.id,
                    concat(a.wlpxxmh_kode, " - ", a.iimxxmh_nama) text,
                    item.id_iicxxmh,
                    a.id_iimxxmh,
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
                LEFT JOIN iimxxmh item ON item.id = a.id_iimxxmh
                LEFT JOIN wlpxxmh lpn ON lpn.kode = a.wlpxxmh_kode
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
                having jumlah_terkecil > 0 
                AND id_wloctmh = 4
                AND id_iicxxmh = 4
                AND lpn.id = :id_wlpxxmh
        '
        );

    $rs_kit = $qs_kit->fetch();

    if(empty($rs_kit)){
        $status_code = 500;
        $message = 'PL ERROR!';
        $type_message = 'error';

    }else{
        $status_code = 200;
        $message = '';
        $type_message = 'success';
        
    }

    $data = array(
        'status_code'       => $status_code,
        'message'           => $message,
        'type_message'      => $type_message,

        'rs_kit'        => $rs_kit,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>