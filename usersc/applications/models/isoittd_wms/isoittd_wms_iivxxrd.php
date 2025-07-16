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

		$where = $where . ' AND c.id = '.$id_wlpxxmh_filter;
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
						0 id_audit,
						0 is_add_new,
						1 is_iiv_valid,
						0 id_files_pointer,
						"" keterangan,
						id_wloxxmh,
						id_iimxxmh,
						id_iumxxmh_unit,
						a.wloxxmh_nama,
						a.iimxxmh_kode,
						iimxxmh_nama,
						iumxxmh_terkecil_kode,
						iumxxmh_default_kode,
						tanggal,
						(SUM(jumlah_terkecil * is_fisik)) - ifnull(jumlah_terkecil_booking,0) as jumlah_iiv_terkecil,
						SUM(a.jumlah_unit) jumlah_unit,
						jumlah_konversi,
						SUM(a.jumlah_terkecil) jumlah_terkecil,
						SUM(a.jumlah_default) jumlah_default,
						ifnull(jumlah_default_booking,0) as jumlah_default_booking,
						ifnull(jumlah_terkecil_booking,0) as jumlah_terkecil_booking,
						(SUM(jumlah_default * is_fisik)) - ifnull(jumlah_default_booking,0) as jumlah_default_ava,
						(SUM(jumlah_terkecil * is_fisik)) - ifnull(jumlah_terkecil_booking,0) as jumlah_terkecil_ava,
						a.wlpxxmh_kode,
						DATE_FORMAT(max(expired_date), "%d %b %Y") expired_date,
						max(expired_date) expired_date_ymd,
						max(batch_number) batch_number,
						if(CONCAT(a.id_iimxxmh, a.batch_number, a.expired_date, a.wlpxxmh_kode, a.id_wloxxmh) IN (
							SELECT
								CONCAT(c.id_iimxxmh, c.batch_number, c.expired_date, c.wlpxxmh_kode, c.id_wloxxmh) 
							FROM isoittd_wms c
							WHERE c.transaction_state = 0
							), 1, 0
						) AS is_audit
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
					LEFT JOIN wlpxxmh c ON c.kode = a.wlpxxmh_kode
					WHERE a.is_fisik = 1 '.$where.'
					GROUP BY 
						id_gbrxxmh, 
						id_iwhxxmh,
						id_iimxxmh,
						id_wloxxmh,
						wlpxxmh_kode
					HAVING jumlah_terkecil > 0 AND is_audit = 0 AND wlpxxmh_kode IS NOT NULL

					UNION all

					SELECT
						a.id AS id_audit,
						is_add_new,
						1 AS is_iiv_valid,
						id_files_pointer,
						IFNULL(a.keterangan, "") keterangan,
						id_wloxxmh,
						id_iimxxmh,
						id_iumxxmh_unit,
						wloxxmh.nama wloxxmh_nama,
						iimxxmh.kode iimxxmh_kode,
						iimxxmh.nama iimxxmh_nama,
						iumxxmh_terkecil.kode iumxxmh_terkecil_kode,
						iumxxmh_default.kode iumxxmh_default_kode,
						tanggal,
						jumlah_iiv_terkecil,
						jumlah_unit,
						jumlah_konversi,
						jumlah_terkecil,
						jumlah_default,
						0 AS jumlah_default_booking,
						0 AS jumlah_terkecil_booking,
						jumlah_default AS jumlah_default_ava,
						jumlah_terkecil AS jumlah_terkecil_ava,
						wlpxxmh_kode,
						DATE_FORMAT(expired_date, "%d %b %Y") AS expired_date,
						expired_date AS expired_date_ymd,
						batch_number,
						1 AS is_audit
					FROM isoittd_wms a
					INNER JOIN iimxxmh ON iimxxmh.id = a.id_iimxxmh
					INNER JOIN wloxxmh ON wloxxmh.id = a.id_wloxxmh
					INNER JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
					INNER JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
					WHERE a.transaction_state = 0 '.$where.'
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