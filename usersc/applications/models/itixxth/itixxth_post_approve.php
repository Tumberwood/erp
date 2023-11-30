<?php
	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
	include( "../../../../usersc/helpers/datatables_fn_debug.php" );
    require '../../../../usersc/vendor/autoload.php';

    use Carbon\Carbon;
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	// BEGIN definisi variable untuk fn_ajax_results.php
	$data      = array();
	$rs_opt    = array();
	$c_rs_opt  = 0;
	$morePages = 0;
	// END definisi variable untuk fn_ajax_results.php
	
	$id = $_POST['id_transaksi_h'];
	$state = $_POST['state'];
	
	$qs_kode = $db
		->raw()
		->bind(':id', $id)
		->exec(' SELECT
					a.kode,
					a.id_hemxxmh
				FROM harxxth AS a
				WHERE a.id = :id
				'
				);
	$rs_kode = $qs_kode->fetch();

	if($state == 1){

	} else if($state == 2) {
	}

	

?>