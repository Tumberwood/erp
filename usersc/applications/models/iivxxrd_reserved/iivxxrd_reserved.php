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
					SUM(jumlah_default) * -1 as jumlah_default_booking,
					SUM(jumlah_terkecil) * -1 as jumlah_terkecil_booking,
					a.wlpxxmh_kode,
					max(batch_number) batch_number,
					max(date_format(expired_date,"%d %b %Y")) as expired_date,
					a.imtxxmh_movement_type,
					CASE 
						WHEN a.imtxxmh_movement_type = "Dispatch" THEN
						(
							SELECT
								z.kode
							FROM wdplptd z
							WHERE z.id = a.id_transaksi_d AND z.wlpxxmh_kode = a.wlpxxmh_kode
						)
						WHEN a.imtxxmh_movement_type = "Picking" THEN
						(
							SELECT
								z.kode
							FROM wpclptd z
							WHERE z.id = a.id_transaksi_d AND z.wlpxxmh_kode = a.wlpxxmh_kode
						)
						WHEN a.imtxxmh_movement_type = "Picking List" THEN
						(
							SELECT
								CONCAT(j.kode, " - ",z.kode) AS kode_d
							FROM wpllptd z
							LEFT JOIN wplxxth j ON j.id_wpllptd = z.id
							WHERE z.id = a.id_transaksi_d AND z.wlpxxmh_kode = a.wlpxxmh_kode
							LIMIT 1
						)
						ELSE ""
					END AS kode_transaksi,
					a.id_transaksi_d
				FROM iivxxrd a
				WHERE tanggal <= :end_date AND is_fisik = 0
				GROUP BY 
					-- id_gbrxxmh, 
					id_iwhxxmh,
					id_iimxxmh,
					id_wloxxmh,
					wlpxxmh_kode
				HAVING jumlah_terkecil_booking <> 0
			');
	$rs_iivxxrd = $qs_iivxxrd->fetchAll();
	if (!empty($rs_iivxxrd)) {
		echo json_encode( ['data' => $rs_iivxxrd]);
	}else{
		echo json_encode( [ "data" => [] ] );
	}
	
?>