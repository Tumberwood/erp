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

	try{
		
		if($state == 1){
			$qs_hcd = $db
			->raw()
			->bind(':id', $id)
			->exec('SELECT
						a.id,
						d.kode hrctsmh_kode,
						CONCAT("hrctsth_", LOWER(d.kode)) tabel,
						a.id_hrctsth,
						b.tanggal,
						CONCAT(d.kode, "-",c.ktp_no, "-",b.tanggal) kode,
						a.id_hcdxxmh
					FROM hrctstd a
					LEFT JOIN hrctsth b ON b.id = a.id_hrctsth
					LEFT JOIN hcddcmh c ON c.id_hcdxxmh = a.id_hcdxxmh
					LEFT JOIN hrctsmh d ON d.id = a.id_hrctsmh
					WHERE b.id = :id
					'
					);
		
			$rs_hcd = $qs_hcd->fetchAll();

			foreach ($rs_hcd as $key => $psikotes) {
				$qi_hrctsth_psikotes = $db
				->query('insert', $psikotes['tabel'])
				->set('kode', $psikotes['kode'])
				->set('tanggal', $psikotes['tanggal'])
				->set('id_hcdxxmh', $psikotes['id_hcdxxmh'])
				->set('id_hrctsth', $id)
				->exec();

				$qu_hrctstd = $db
					->query('update', 'hrctstd')
					->set('kode',$psikotes['kode'])
					->where('id',$psikotes['id'])
					->exec();
			}
		} // end if($state == 1)

		if(!empty($qi_hrctsth_psikotes)){
			$status_code  = 200;
			$message = "Konfirmasi Berhasil";
			$type_message = "success";
			// parameter lain
		}else{
			$status_code  = 500;
			$message = "Konfirmasi Gagal";
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