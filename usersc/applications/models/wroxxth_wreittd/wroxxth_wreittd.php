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

	$kondisi = 'HAVING sisa > 0';
	if (isset($_POST['kondisi'])) {
		if ($_POST['kondisi'] == 0) {
			//ini belum lunas
			$kondisi = 'HAVING sisa > 0';
		} else if($_POST['kondisi'] == 1) {
			//ini lunas
			$kondisi = 'HAVING sisa = 0';
		} else {
			$kondisi = '';
		}
	}

	// echo $kondisi;
	$qs_wroxxth = $db
		->raw()
		->exec('SELECT
					b.id,
					a.kode,
					c.kode iimxxmh_kode,
					c.nama iimxxmh_nama,
					d.kode iumxxmh_kode,
					b.jumlah_unit jumlah_unit_ro,
					f.nama supplier,
					SUM(IFNULL(e.jumlah_terkecil / uo.jumlah_konversi,0)) jumlah_unit_re,
					b.jumlah_unit - SUM(IFNULL(e.jumlah_terkecil / uo.jumlah_konversi,0)) sisa,
					DATE_FORMAT(g.finish_on, "%d %b %Y %H:%i:%s") confirm_ro,
					DATE_FORMAT(e.finish_on, "%d %b %Y %H:%i:%s") confirm_re,
					NOW() today,
					if(e.finish_on is null,
						CONCAT(
						IF(TIMESTAMPDIFF(SECOND, g.finish_on, NOW()) >= 86400, CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, g.finish_on, NOW()) / 86400), "d "), ""),
						IF(TIMESTAMPDIFF(SECOND, g.finish_on, NOW()) % 86400 >= 3600, CONCAT(FLOOR((TIMESTAMPDIFF(SECOND, g.finish_on, NOW()) % 86400) / 3600), "h "), "")
						),
						CONCAT(
							IF(TIMESTAMPDIFF(SECOND, g.finish_on, e.finish_on) >= 86400, CONCAT(FLOOR(TIMESTAMPDIFF(SECOND, g.finish_on, e.finish_on) / 86400), "d "), ""),
							IF(TIMESTAMPDIFF(SECOND, g.finish_on, e.finish_on) % 86400 >= 3600, CONCAT(FLOOR((TIMESTAMPDIFF(SECOND, g.finish_on, e.finish_on) % 86400) / 3600), "h "), ""),
							IF(TIMESTAMPDIFF(SECOND, g.finish_on, e.finish_on) % 3600 >= 60, CONCAT(FLOOR((TIMESTAMPDIFF(SECOND, g.finish_on, e.finish_on) % 3600) / 60), "m "), ""),
							CONCAT(TIMESTAMPDIFF(SECOND, g.finish_on, e.finish_on) % 60, "s")
						)
					) AS pemenuhan
				FROM wroxxth a
				LEFT JOIN wroittd b ON b.id_wroxxth = a.id
				LEFT JOIN iimxxmh c ON c.id = b.id_iimxxmh
				LEFT JOIN iimummd uo ON uo.id_iimxxmh = c.id AND uo.id_iumxxmh = b.id_iumxxmh_unit
				LEFT JOIN iumxxmh d ON d.id = uo.id_iumxxmh
				LEFT JOIN (
					SELECT
						sum(re.jumlah_terkecil) jumlah_terkecil,
						re.id_wroittd,
						ml.id_transaksi,
						max(ml.finish_on) finish_on
					FROM wreittd re
					LEFT JOIN activity_log_ml ml ON ml.id_transaksi = re.id
					WHERE ml.kode = "CONFIRM" AND ml.nama = "wreittd"
					GROUP BY re.id_wroittd
				) e ON e.id_wroittd = b.id
				LEFT JOIN grlxxmh f ON f.id = a.id_grlxxmh_supplier
				LEFT JOIN activity_log_ml g ON g.id_transaksi = a.id AND g.kode = "CONFIRM" AND g.nama = "wroxxth"
				GROUP BY b.id
				'.$kondisi
	);
	$rs_wroxxth = $qs_wroxxth->fetchAll();
	if (!empty($rs_wroxxth)) {
		echo json_encode( ['data' => $rs_wroxxth]);
	}else{
		echo json_encode( [ "data" => [] ] );
	}
	
?>