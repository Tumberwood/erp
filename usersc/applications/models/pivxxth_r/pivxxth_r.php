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
	
	$start_date = Carbon::parse($_POST['start_date'])->format('Y-m-d');
	$end_date = Carbon::parse($_POST['end_date'])->format('Y-m-d');		
	$id_grlxxmh_supplier = $_POST['id_grlxxmh_supplier'];
	
	if ($id_grlxxmh_supplier > 0) {
		$where = " AND a.id_grlxxmh_supplier = " . $id_grlxxmh_supplier;
	} else {
		$where = "";
	}
	// echo $id_grlxxmh_supplier;

	$qs_pivxxth = $db
		->raw()
		->bind(':start_date',$start_date)
		->bind(':end_date',$end_date)
		// ->bind(':id_grlxxmh_supplier',$id_grlxxmh_supplier)
		->exec('SELECT
					b.id,
					a.kode,
					e.nama supplier,
					DATE_FORMAT(a.tanggal, "%d %b %Y") tanggal,
					c.kode iimxxmh_kode,
					c.nama iimxxmh_nama,
					b.jumlah_unit,
					d.kode AS uom,
					b.harga_unit,
					b.subtotal
				FROM pivxxth a
				LEFT JOIN pivittd b ON b.id_pivxxth = a.id
				LEFT JOIN iimxxmh c ON c.id = b.id_iimxxmh
				LEFT JOIN iumxxmh d ON d.id = b.id_iumxxmh_unit
				LEFT JOIN grlxxmh e ON e.id = a.id_grlxxmh_supplier
				WHERE a.transaction_state = 1 AND b.transaction_state <> -9
				AND a.tanggal BETWEEN :start_date AND :end_date
		' . $where);
	$rs_pivxxth = $qs_pivxxth->fetchAll();

	// print_r($qs_pivxxth);
	if (!empty($rs_pivxxth)) {
		echo json_encode( ['data' => $rs_pivxxth]);
	}else{
		echo json_encode( [ "data" => [] ] );
	}
	
?>