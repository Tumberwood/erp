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

	$qs_wms_log_r = $db
		->raw()
		->exec('WITH log AS (
					SELECT
						a.id AS id,
						a.id_transaksi,
						CASE 
							WHEN a.nama = "wreittd" then "Receive Entry"
							WHEN a.nama = "wptittd" then "Putaway"
							WHEN a.nama = "wtrittd" then "Item Transfer"
							WHEN a.nama = "iivxxrd_audit" then "Audit LPN & Lokasi"
							WHEN a.nama = "wpclptd" then "Detail Picking"
							ELSE ""
						END
						activity,
						CASE 
							WHEN a.nama = "wreittd" then (
								select
									kode
								from wreittd
								where id = a.id_transaksi
							)
							WHEN a.nama = "wptittd" then (
								select
									kode
								from wptittd
								where id = a.id_transaksi
							)
							WHEN a.nama = "wtrittd" then (
								select
									kode
								from wtrittd
								where id = a.id_transaksi
							)
							WHEN a.nama = "wtrittd" then (
								select
									kode
								from wtrittd
								where id = a.id_transaksi
							)
							WHEN a.nama = "iivxxrd_audit" then (
								select
									kode
								from iivxxrd_audit
								where id = a.id_transaksi
							)
							WHEN a.nama = "wpclptd" then (
								select
									kode
								from wpclptd
								where id = a.id_transaksi
							)
							ELSE ""
						END
						kode_transaksi,
						a.username,
						DATE_FORMAT(a.start_on, "%d %b %Y %H:%i:%s") AS start_on,
						DATE_FORMAT(b.finish_on, "%d %b %Y %H:%i:%s") AS finish_on,
						TIMESTAMPDIFF(SECOND, a.start_on, b.finish_on) AS durasi
					FROM activity_log_ml AS a
					LEFT JOIN activity_log_ml AS b ON a.id_transaksi = b.id_transaksi AND b.kode = "CONFIRM" AND b.nama = a.nama
					WHERE a.kode = "CREATE"
						AND a.nama IN ("wreittd", "wptittd", "wtrittd", "iivxxrd_audit", "wpclptd")
					GROUP BY a.id_transaksi, a.nama
					ORDER BY a.start_on DESC
				)
				select
					z.*,
					ifnull(iv.wloxxmh_nama, "") wloxxmh_nama,
					ifnull(iv.iwhxxmh_kode, "") iwhxxmh_kode,
					ifnull(iv.id_wloxxmh, 0 ) id_wloxxmh
				from log z
				LEFT JOIN (
					SELECT
						kode,
						wloxxmh_nama,
						iwhxxmh_kode,
						id_wloxxmh
					FROM iivxxrd
					WHERE jumlah_terkecil > 0
					ORDER BY id desc
				) iv on iv.kode = z.kode_transaksi
				GROUP BY z.id
		');
	$rs_wms_log_r = $qs_wms_log_r->fetchAll();
	if (!empty($rs_wms_log_r)) {
		echo json_encode( ['data' => $rs_wms_log_r]);
	}else{
		echo json_encode( [ "data" => [] ] );
	}
	
?>