<?php
	/**
	 * 
	 */

	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );

	require '../../../../usersc/vendor/autoload.php';
	use Carbon\Carbon;
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

		
	$end_date = new Carbon($_POST['end_date']);
	$qs_iivxxrd = $db
		->raw()
		->bind(':end_date', $end_date->format('Y-m-d') )
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
					WHERE tanggal <= :end_date AND is_fisik = 0
					GROUP BY 
						id_gbrxxmh, 
						id_iwhxxmh,
						id_iimxxmh,
						id_wloxxmh,
						wlpxxmh_kode
				) AS b ON b.wloxxmh_nama = a.wloxxmh_nama AND b.iimxxmh_kode = a.iimxxmh_kode AND b.wlpxxmh_kode = a.wlpxxmh_kode
				WHERE tanggal <= :end_date
				GROUP BY 
					id_gbrxxmh, 
					id_iwhxxmh,
					id_iimxxmh,
					id_wloxxmh,
					wlpxxmh_kode
				having jumlah_terkecil > 0
			');
	$rs_iivxxrd = $qs_iivxxrd->fetchAll();
	if (!empty($rs_iivxxrd)) {
		echo json_encode( ['data' => $rs_iivxxrd]);
	}else{
		echo json_encode( [ "data" => [] ] );
	}
	
?>