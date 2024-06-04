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
				iwhxxmh_kode,
				iimxxmh_kode,
				iimxxmh_nama,
				SUM(jumlah_default * is_fisik) AS jumlah_default,
				iumxxmh_default_kode,
				SUM(jumlah_terkecil * is_fisik) AS jumlah_terkecil,
				iumxxmh_terkecil_kode
			FROM iivxxrd
			WHERE tanggal <= :end_date
			GROUP BY 
				id_gbrxxmh, 
				id_iwhxxmh,
				id_iimxxmh
		');
	$rs_iivxxrd = $qs_iivxxrd->fetchAll();
	if (!empty($rs_iivxxrd)) {
		echo json_encode( ['data' => $rs_iivxxrd]);
	}else{
		echo json_encode( [ "data" => [] ] );
	}
	
?>