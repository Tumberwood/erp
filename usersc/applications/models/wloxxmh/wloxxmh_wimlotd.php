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

	$id_wloxxmh = $_POST['id_wloxxmh'];
	$qs_wimlotd = $db
		->raw()
		->bind(':id_wloxxmh', $id_wloxxmh)
		->exec('SELECT
				b.kode iimxxmh_kode,
				b.nama iimxxmh_nama
			FROM wimlotd a
			LEFT JOIN iimxxmh b ON b.id = a.id_iimxxmh
			WHERE a.id_wloxxmh = :id_wloxxmh AND b.transaction_state = 1
			GROUP BY a.id_iimxxmh
			');
	$rs_wimlotd = $qs_wimlotd->fetchAll();
	if (!empty($rs_wimlotd)) {
		echo json_encode( ['data' => $rs_wimlotd]);
	}else{
		echo json_encode( [ "data" => [] ] );
	}
	
?>