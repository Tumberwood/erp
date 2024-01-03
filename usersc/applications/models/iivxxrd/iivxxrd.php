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
		->exec('
			SELECT
				a.id_gbrxxmh, 
				a.id_iwhxxmh, 
				a.id_iimxxmh,
				e.kode AS iwhxxmh_kode,
				b.kode AS iimxxmh_kode,
				b.nama AS iimxxmh_nama,
				a.id_iumxxmh_unit,
				a.id_iumxxmh_terkecil,
				SUM(a.jumlah_unit) AS jumlah_unit,
				c.kode AS iumxxmh_unit_kode,
				SUM(a.jumlah_terkecil) AS jumlah_terkecil,
				d.kode AS iumxxmh_terkecil_kode
			FROM iivxxrd a
			LEFT JOIN iimxxmh b ON b.id = a.id_iimxxmh
			LEFT JOIN iumxxmh c ON c.id = a.id_iumxxmh_unit
			LEFT JOIN iumxxmh d ON d.id = a.id_iumxxmh_terkecil
			LEFT JOIN iwhxxmh e ON e.id = a.id_iwhxxmh
			WHERE a.tanggal <= :end_date
			GROUP BY 
				a.id_gbrxxmh, 
				a.id_iwhxxmh,
				a.id_iimxxmh
		');
	$rs_iivxxrd = $qs_iivxxrd->fetchAll();
	if (!empty($rs_iivxxrd)) {
		echo json_encode( ['data' => $rs_iivxxrd]);
	}else{
		echo json_encode( [ "data" => [] ] );
	}
	
?>