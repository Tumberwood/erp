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
	
	$id = $_POST['id_transaksi'];
	$state = $_POST['state'];

	// (ROW_NUMBER() OVER (ORDER BY a.id) * (ROW_NUMBER() OVER (ORDER BY a.id) - 1)) / 2 AS result

	$qs_id_iitxxmh = $db
		->query('select', 'sivxxth' )
		->get([
			'sivxxth.id_iitxxmh as id_iitxxmh'
		] )
		->where('sivxxth.id', $id )
		->exec();
	$rs_id_iitxxmh = $qs_id_iitxxmh->fetch();

	//Update tanggal_jatuh_tempo
	$qu_tanggal_jatuh_tempo = $db
		->raw()
		->bind(':id', $id)
		->exec('UPDATE sivxxth a
				LEFT JOIN fpytmmh b ON b.id = a.id_fpytmmh
				LEFT JOIN ggsfnsh c ON c.id = 1
				SET 
					a.selisih_bayar = a.grand_total,
					a.tanggal_jatuh_tempo = DATE_ADD(a.tanggal, INTERVAL b.jatuh_tempo DAY)
				WHERE a.id = :id
	');

	if ($qu_tanggal_jatuh_tempo) {
		$status_code  = '200';
		$message      = '';
		$type_message = 'success';
	} else {
		$status_code  = 500;
		$message = "Gagal";
		$type_message = 'error';
	}	

	// build response
	$data = array(
		'status_code'    => $status_code,
		'message'        => $message,
		'type_message'   => $type_message
	);	

	// tampilkan results
	include( "../../../../usersc/helpers/fn_ajax_results.php" );

?>