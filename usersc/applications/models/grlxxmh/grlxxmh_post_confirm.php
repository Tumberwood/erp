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

	$qs_grlxxmh = $db
		->raw()
		->bind(':id', $id)
		->exec('SELECT
					is_konsinyasi,
					CONCAT("WH-",nama) nama
				FROM grlxxmh
				WHERE id = :id
	');
	
	$rs_grlxxmh = $qs_grlxxmh->fetch();

	try{
			
		$is_valid = 0;
		if($state == 1){
			$is_konsinyasi = $rs_grlxxmh['is_konsinyasi'];
			$nama = $rs_grlxxmh['nama'];

			if ($is_konsinyasi == 1) {
				$qi_iwhxxmh = $db
					->query('insert', 'iwhxxmh')
					->set('transaction_state',1)
					->set('id_gbrxxmh',1)
					->set('id_iwhctmh',7)
					->set('id_grlxxmh',$id)
					->set('kode',$nama)
					->set('nama',$nama)
					->exec()
				;

				//kalau insert berhasil
				if ($qi_iwhxxmh) {
					$is_valid = 1;
				} else {
					$is_valid = 0;
				}
				
			} else {
				$is_valid = 1;
			}
		} // end if($state == 1)

		if(!empty($is_valid == 1)){
			$status_code  = 200;
			$message = "Purchase Payment Berhasil Diupdate";
			$type_message = "success";
			// parameter lain
		}else{
			$status_code  = 500;
			$message = "Purchase Payment Gagal Diupdate";
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