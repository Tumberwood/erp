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

	$wlpxxmh_kode = $_POST['wlpxxmh_kode'];
	$id_wloxxmh = $_POST['id_wloxxmh'];

	$qs_wpllptd = $db
		->raw()
		->bind(':wlpxxmh_kode', $wlpxxmh_kode)
		->bind(':id_wloxxmh', $id_wloxxmh)
		->exec('SELECT
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
					WHERE is_fisik = 0
					GROUP BY 
						-- id_gbrxxmh, 
						id_iwhxxmh,
						id_iimxxmh,
						id_wloxxmh,
						wlpxxmh_kode
				) AS b ON b.wloxxmh_nama = a.wloxxmh_nama AND b.iimxxmh_kode = a.iimxxmh_kode AND b.wlpxxmh_kode = a.wlpxxmh_kode
				WHERE a.wlpxxmh_kode = :wlpxxmh_kode AND a.id_wloxxmh = :id_wloxxmh
				GROUP BY 
					-- id_gbrxxmh, 
					id_iwhxxmh,
					id_iimxxmh,
					id_wloxxmh,
					wlpxxmh_kode
				having jumlah_terkecil > 0'
		);
	$rs_wpllptd = $qs_wpllptd->fetch();

    if (!empty($rs_wpllptd)) {
        $message = "";
        $status_code = 200;
    } else {
        $message = "Harap menuju Menu Item Transfer Replenishment untuk melakukan konfirmasi Replenishment!";
        $status_code = 500;
    }

    $data = array(
        'message' => $message,
        'status_code' => $status_code,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>