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
				wloxxmh_nama,
				iimxxmh_kode,
				iimxxmh_nama,
				iumxxmh_default_kode,
				iumxxmh_terkecil_kode,
				SUM(jumlah_default * is_fisik) as jumlah_default,
				SUM(jumlah_terkecil * is_fisik) as jumlah_terkecil,
				wlpxxmh_kode,
				batch_number,
				date_format(expired_date,"%d %b %Y") as expired_date
			FROM iivxxrd
			WHERE tanggal <= :end_date
			GROUP BY 
				id_gbrxxmh, 
				id_iwhxxmh,
				id_iimxxmh,
				id_wloxxmh,
				wlpxxmh_kode
		');
	$rs_iivxxrd = $qs_iivxxrd->fetchAll();
	if (!empty($rs_iivxxrd)) {
		echo json_encode( ['data' => $rs_iivxxrd]);
	}else{
		echo json_encode( [ "data" => [] ] );
	}
	
?>