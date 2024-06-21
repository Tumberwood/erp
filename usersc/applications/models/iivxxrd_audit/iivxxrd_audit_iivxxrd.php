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
	$wloxxmh_nama = '';
	$wlpxxmh_kode = '';
	$id_wloxxmh_filter = 0;
	if (isset($_POST['id_wlpxxmh_filter']) && $_POST['id_wlpxxmh_filter'] > 0) {
		$id_wlpxxmh_filter = $_POST['id_wlpxxmh_filter'];
		$qs_lpn = $db
			->query('select', 'wlpxxmh' )
			->get(['kode'] )
			->where('id', $id_wlpxxmh_filter)
			->exec();
		$rs_lpn = $qs_lpn->fetch();
		$wlpxxmh_kode = $rs_lpn['kode'];

		$where = $where . ' AND b.id = '.$id_wlpxxmh_filter;
	}

	if (isset($_POST['id_wloxxmh_filter']) && $_POST['id_wloxxmh_filter'] > 0) {
		$id_wloxxmh_filter = $_POST['id_wloxxmh_filter'];
		$qs_loc = $db
			->query('select', 'wloxxmh' )
			->get(['nama'] )
			->where('id', $id_wloxxmh_filter)
			->exec();
		$rs_loc = $qs_loc->fetch();
		$wloxxmh_nama = $rs_loc['nama'];

		$where = $where . ' AND a.id_wloxxmh = '.$id_wloxxmh_filter;
	}

	// echo $_POST['wloxxmh_filter'];
	// echo $_POST['wlpxxmh_filter'];

	$qs_iivxxrd = $db
		->raw()
		->exec('SELECT
					1 is_iiv_valid,
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
		');
	$rs_iivxxrd = $qs_iivxxrd->fetchAll();
	if (!empty($rs_iivxxrd)) {
		echo json_encode( ['data' => $rs_iivxxrd]);
	}else{
		$rs_iivxxrd_custom = [
			[
				'is_audit' => 0,
				'is_iiv_valid' => 0,
				'id_iimxxmh' => 0,
				'batch_number' => '',
				'expired_date_ymd' => '',
				'wlpxxmh_kode' => $wlpxxmh_kode,
				'id_wloxxmh' => $id_wloxxmh_filter,
				'wloxxmh_nama' => $wloxxmh_nama,
			]
		];

		echo json_encode( [ "data" => $rs_iivxxrd_custom] );
	}
	
?>