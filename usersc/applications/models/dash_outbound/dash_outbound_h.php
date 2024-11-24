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
	
	// $start_date = new Carbon($_POST['start_date']);
	// $end_date = new Carbon($_POST['end_date']);
	// $id_iwhxxmh = $_POST['id_iwhxxmh'];

	$qs_dash = $db
		->raw()
		// ->bind(':start_date',$start_date)
		// ->bind(':end_date',$end_date)
		// ->bind(':id_iwhxxmh',$id_iwhxxmh)
		->exec('SELECT
					a.id id_wplxxth,
					b.id_wdoittd,
					d.id id_wdoxxth,
					DATE_FORMAT(a.tanggal, "%d %b %Y") tanggal,
					a.kode wplxxth_kode,
					e.nama customer
				FROM wplxxth a
				LEFT JOIN wplittd b ON b.id_wplxxth = a.id
				LEFT JOIN wdoittd c ON c.id = b.id_wdoittd
				LEFT JOIN wdoxxth d ON d.id = c.id_wdoxxth
				LEFT JOIN grlxxmh e ON e.id = b.id_grlxxmh_customer
				WHERE a.transaction_state = 1
				GROUP BY d.id
				ORDER BY tanggal DESC
				;
		');
	$rs_dash = $qs_dash->fetchAll();
	if (!empty($rs_dash)) {
		echo json_encode( ['data' => $rs_dash]);
	}else{
		echo json_encode( [ "data" => [] ] );
	}
	
?>