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
				a.id_iumxxmh_default,
				a.id_iumxxmh_terkecil,
				SUM(a.jumlah_default * a.is_fisik) AS jumlah_default,
				iumxxmh_default.kode AS iumxxmh_default_kode,
				SUM(a.jumlah_terkecil * a.is_fisik) AS jumlah_terkecil,
				iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode
			FROM iivxxrd a
			LEFT JOIN iimxxmh b ON b.id = a.id_iimxxmh
			LEFT JOIN iumxxmh as iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
			LEFT JOIN iumxxmh as iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
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