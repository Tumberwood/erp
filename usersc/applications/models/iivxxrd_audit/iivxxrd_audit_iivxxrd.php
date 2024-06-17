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

	$where = '';
	if (isset($_POST['id_wlpxxmh_filter']) && $_POST['id_wlpxxmh_filter'] > 0) {
		$id_wlpxxmh_filter = $_POST['id_wlpxxmh_filter'];
		$where = $where . ' AND b.id = '.$id_wlpxxmh_filter;
	}

	if (isset($_POST['id_wloxxmh_filter']) && $_POST['id_wloxxmh_filter'] > 0) {
		$id_wloxxmh_filter = $_POST['id_wloxxmh_filter'];
		$where = $where . ' AND a.id_wloxxmh = '.$id_wloxxmh_filter;
	}

	$qs_iivxxrd = $db
		->raw()
		->exec('SELECT
					id_transaksi_h,
					id_transaksi_d,
					id_gcpxxmh,
					id_gbrxxmh,
					id_iwhxxmh,
					id_wloctmh,
					id_wloxxmh,
					id_relasi_m,
					id_iimxxmh,
					id_iumxxmh_unit,
					id_iumxxmh_terkecil,
					id_iumxxmh_default,
					a.kode,
					a.keterangan,
					confirmed_at,
					a.created_by,
					gcpxxmh_kode,
					gcpxxmh_nama,
					gbrxxmh_kode,
					gbrxxmh_nama,
					iwhxxmh_kode,
					iwhxxmh_nama,
					wloxxmh_kode,
					wloxxmh_nama,
					relasi_m_kode,
					relasi_m_nama,
					iimxxmh_kode,
					iimxxmh_nama,
					iumxxmh_unit_kode,
					iumxxmh_unit_nama,
					iumxxmh_terkecil_kode,
					iumxxmh_terkecil_nama,
					iumxxmh_default_kode,
					iumxxmh_default_nama,
					imtxxmh_kode,
					imtxxmh_movement_type,
					tanggal,
					is_fisik,
					SUM(a.jumlah_unit) jumlah_unit,
					jumlah_konversi,
					SUM(a.jumlah_terkecil) jumlah_terkecil,
					SUM(a.jumlah_default) jumlah_default,
					a.wlpxxmh_kode,
					DATE_FORMAT(max(expired_date), "%d %b %Y") expired_date,
					max(expired_date) expired_date_ymd,
					max(batch_number) batch_number,
					if(CONCAT(a.id_iimxxmh, a.batch_number, a.expired_date, a.wlpxxmh_kode, a.id_wloxxmh) IN (
						SELECT
							CONCAT(c.id_iimxxmh, c.batch_number, c.expired_date, c.wlpxxmh_kode, c.id_wloxxmh) 
						FROM iivxxrd_audit c
						), 1, 0
					) AS is_audit
				FROM iivxxrd a
				LEFT JOIN wlpxxmh b ON b.kode = a.wlpxxmh_kode
				WHERE a.is_fisik = 1 '.$where.'
				GROUP BY 
					id_gbrxxmh, 
					id_iwhxxmh,
					id_iimxxmh,
					id_wloxxmh,
					wlpxxmh_kode
				HAVING jumlah_terkecil > 0 
				-- AND CONCAT(a.id_iimxxmh, a.batch_number, a.expired_date, a.wlpxxmh_kode, a.id_wloxxmh) 
				-- 	NOT IN (
				-- 		SELECT
				-- 			CONCAT(c.id_iimxxmh, c.batch_number, c.expired_date, c.wlpxxmh_kode, c.id_wloxxmh) 
				-- 		FROM iivxxrd_audit c
				-- 	);
		');
	$rs_iivxxrd = $qs_iivxxrd->fetchAll();
	if (!empty($rs_iivxxrd)) {
		echo json_encode( ['data' => $rs_iivxxrd]);
	}else{
		echo json_encode( [ "data" => [] ] );
	}
	
?>