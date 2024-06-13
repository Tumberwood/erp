<?php
	/**
	 * 
	 */

	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	include_once( "../../../../usersc/vendor/autoload.php") ;
	use Carbon\Carbon;
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	$results = [];

	// $end_date = new Carbon($_POST['end_date']);
	$end_date = $_POST['end_date'];

	if( isset($_POST['id_iwhxxmh']) && $_POST['id_iwhxxmh'] > 0 ){
		$where_iwhxxmh = " AND id_iwhxxmh = " . $_POST['id_iwhxxmh'] . " ";
	}else{
		$where_iwhxxmh = "";
	}

	$qs_iivxxrd = $db
		->raw()
		->bind(':end_date', $end_date )
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
			WHERE 1
				AND tanggal <= :end_date '
				.$where_iwhxxmh.
			'GROUP BY 
				id_gbrxxmh, 
				id_iwhxxmh,
				id_iimxxmh
		');
	$rs_iivxxrd = $qs_iivxxrd->fetchAll();

	// if (!empty($rs_iivxxrd)) {
	// 	echo json_encode( ['data' => $rs_iivxxrd]);
	// }else{
	// 	echo json_encode( [ "data" => [] ] );
	// }

	if (!empty($rs_iivxxrd)) {
		$data = $rs_iivxxrd;
	}else{
		$data = [];
	}

	$results = array(
		"data" => $data,
		"debug" => $debug
	);

	echo json_encode($results);
	
?>