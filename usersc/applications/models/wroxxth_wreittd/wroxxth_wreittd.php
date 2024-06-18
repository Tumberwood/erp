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

	$qs_wroxxth = $db
		->raw()
		->exec('SELECT
					b.id,
					a.kode,
					c.kode iimxxmh_kode,
					c.nama iimxxmh_nama,
					d.kode iumxxmh_kode,
					b.jumlah_unit jumlah_unit_ro ,
					SUM(IFNULL(e.jumlah_terkecil / uo.jumlah_konversi,0)) jumlah_unit_re,
					b.jumlah_unit - SUM(IFNULL(e.jumlah_terkecil / uo.jumlah_konversi,0)) sisa
				FROM wroxxth a
				LEFT JOIN wroittd b ON b.id_wroxxth = a.id
				LEFT JOIN iimxxmh c ON c.id = b.id_iimxxmh
				LEFT JOIN iimummd uo ON uo.id_iimxxmh = c.id AND uo.id_iumxxmh = b.id_iumxxmh_unit
				LEFT JOIN iumxxmh d ON d.id = uo.id_iumxxmh
				LEFT JOIN wreittd e ON e.id_wroittd = b.id
				GROUP BY b.id
		');
	$rs_wroxxth = $qs_wroxxth->fetchAll();
	if (!empty($rs_wroxxth)) {
		echo json_encode( ['data' => $rs_wroxxth]);
	}else{
		echo json_encode( [ "data" => [] ] );
	}
	
?>