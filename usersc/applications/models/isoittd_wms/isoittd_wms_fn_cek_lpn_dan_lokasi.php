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

	$state = $_POST['state'];
	// echo $state;

	if ($state == 1) {
		//cek LPN Inputan di master LPN
		$qs_lpn = $db
			->query('select', 'wlpxxmh' )
			->get(['id'] )
			->where('kode', $_POST['wlpxxmh_filter'] )
			->exec();
		$rs_lpn = $qs_lpn->fetch();

		if (!empty($rs_lpn)) {
			$id_transaksi = $rs_lpn['id'];
		} else {
			$id_transaksi = 0;
		}
	} else {
		//cek loc Inputan di master loc
		$qs_loc = $db
			->query('select', 'wloxxmh' )
			->get(['id'] )
			->where('nama', $_POST['wloxxmh_filter'] )
			->exec();
		$rs_loc = $qs_loc->fetch();

		if (!empty($rs_loc)) {
			$id_transaksi = $rs_loc['id'];
		} else {
			$id_transaksi = 0;
		}
	}

	// echo $id_transaksi;
	if ($id_transaksi > 0) {
		echo json_encode( ['data' => $id_transaksi]);
	}else{
		echo json_encode( [ "data" => [] ] );
	}
	
?>