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

	$wlpxxmh_kode = $_POST['wlpxxmh_kode'];
	// $qs_iivxxrd = $db
	// 	->raw()
	// 	->bind(':wlpxxmh_kode', $wlpxxmh_kode)
	// 	->exec('SELECT DISTINCT
	// 				a.iimxxmh_kode,
	// 				a.iimxxmh_nama,
	// 				max(batch_number) batch_number,
	// 				max(date_format(expired_date,"%d %b %Y")) as expired_date
	// 			FROM iivxxrd a
	// 			LEFT JOIN (
	// 				SELECT
	// 					wloxxmh_nama,
	// 					iimxxmh_kode,
	// 					SUM(jumlah_default) * -1 as jumlah_default_booking,
	// 					SUM(jumlah_terkecil) * -1 as jumlah_terkecil_booking,
	// 					wlpxxmh_kode
	// 				FROM iivxxrd
	// 				WHERE is_fisik = 0
	// 				GROUP BY 
	// 					-- id_gbrxxmh, 
	// 					id_iwhxxmh,
	// 					id_iimxxmh,
	// 					id_wloxxmh,
	// 					wlpxxmh_kode
	// 			) AS b ON b.wloxxmh_nama = a.wloxxmh_nama AND b.iimxxmh_kode = a.iimxxmh_kode AND b.wlpxxmh_kode = a.wlpxxmh_kode
	// 			WHERE a.wlpxxmh_kode = :wlpxxmh_kode
	// 			GROUP BY 
	// 				-- id_gbrxxmh, 
	// 				id_iwhxxmh,
	// 				id_iimxxmh,
	// 				id_wloxxmh,
	// 				a.wlpxxmh_kode
	// 			having SUM(jumlah_terkecil * is_fisik) > 0
	// 		');
	// $rs_iivxxrd = $qs_iivxxrd->fetchAll();
	
	$qs_iivxxrd = $db
		->raw()
		->bind(':wlpxxmh_kode', $wlpxxmh_kode)
		->exec('SELECT
					b.kode iimxxmh_kode,
	 				b.nama iimxxmh_nama,
	 				batch_number batch_number,
	 				date_format(expired_date,"%d %b %Y") as expired_date
				FROM wreittd a
				INNER JOIN iimxxmh b on b.id = a.id_iimxxmh
				WHERE a.wlpxxmh_kode = :wlpxxmh_kode
			');
	$rs_iivxxrd = $qs_iivxxrd->fetchAll();
	if (!empty($rs_iivxxrd)) {
		echo json_encode( ['data' => $rs_iivxxrd]);
	}else{
		echo json_encode( [ "data" => [] ] );
	}
	
?>