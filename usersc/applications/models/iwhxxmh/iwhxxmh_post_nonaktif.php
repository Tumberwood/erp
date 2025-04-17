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
	$state = $_POST['transaction_state'];

	// (ROW_NUMBER() OVER (ORDER BY a.id) * (ROW_NUMBER() OVER (ORDER BY a.id) - 1)) / 2 AS result

	try{
		
		if($state == -9){
			$qs_iwhxxmh = $db
				->query('select', 'iwhxxmh' )
				->get(['kode'] )
				->where('id', $id )
				->exec();
			$rs_iwhxxmh = $qs_iwhxxmh->fetch();
			$kode = $rs_iwhxxmh['kode'];

			$qu_iwhxxmh = $db
				->raw()
				->exec('UPDATE iwhxxmh a
						SET transaction_state = -9
						WHERE a.kode LIKE "%'.$kode.'%"
			');

		} // end if($state == 1)

		if(!empty($qu_iwhxxmh)){
			$status_code  = 200;
			$message = "Warehouse Transit (System) Berhasil Dinonaktifkan";
			$type_message = "success";
			// parameter lain
		}else{
			$status_code  = 500;
			$message = "Warehouse Transit (System) Gagal Dinonaktifkan";
			$type_message = 'error';
			// parameter lain
		}
	}catch(PDOException $e){
		$status_code  = 500;
		$message      = 'Message Gagal! ' . $e->getMessage();
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