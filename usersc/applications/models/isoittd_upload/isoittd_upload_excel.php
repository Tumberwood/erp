<?php
	require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	require_once( "../../../../usersc/vendor/autoload.php" );
	include_once( "../../../helpers/hakakses_s_fn.php" );
	use Carbon\Carbon;
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Reader\Csv;
	use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

	// BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

	$file_mimes = array(
		'application/octet-stream', 
		'application/vnd.ms-excel', 
		'application/x-csv', 
		'text/x-csv', 
		'text/csv', 
		'application/csv', 
		'application/excel', 
		'application/vnd.msexcel', 
		'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
	);
	
	if(isset($_FILES['filename']['name']) && in_array($_FILES['filename']['type'], $file_mimes)) {
		
		$arr_file = explode('.', $_FILES['filename']['name']);
		$extension = end($arr_file);

        if('csv' == $extension) {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
		} elseif('xls' == $extension) {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
		} else {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		}
 
		$spreadsheet = $reader->load($_FILES['filename']['tmp_name']);
     
		$sheetData = $spreadsheet->getActiveSheet()->toArray();
		
		try{
			$db->transaction();
			
			$datakembar = 0;
			$dataupload = 0;
			
			$label 		= $sheetData['1']['0'] ; // return 1
			$start_at = $_POST['start_at'];
			
			$id_users = $hakakses['s_id_users'];
			$username = $hakakses['s_username'];

			if ($label == "ID") {
				for($i = 2;$i < count($sheetData);$i++){
					//detail
					$id_isoittd_upload 	= $sheetData[$i]['0'] ;
					$transaksi_in 		= $sheetData[$i]['11'] ;
					$transaksi_out		= $sheetData[$i]['12'] ;

					$qu_data_kembar = $db
						->raw()
						->bind(':id_isoittd_upload', $id_isoittd_upload)
						->bind(':transaksi_in', $transaksi_in)
						->bind(':transaksi_out', $transaksi_out)
						->exec('UPDATE isoittd_upload a
								SET 
									transaksi_in = :transaksi_in,
									transaksi_out = :transaksi_out,
									selisih_final = a.fisik + :transaksi_out - a.jumlah_terkecil - :transaksi_in
								WHERE a.id = :id_isoittd_upload
							'
					);

					$end = date('Y-m-d H:i:s');
					$durasi_detik = strtotime($end) - strtotime($start_at);
					
					//Insert Detail Activity Log
					$qi_log = $db
						->raw()
						->bind(':id_users', $id_users)
						->bind(':username', $username)
						->bind(':start_at', $start_at)
						->bind(':end', $end)
						->bind(':durasi_detik', $durasi_detik)
						->bind(':id_isoittd_upload', $id_isoittd_upload)
						->exec('INSERT INTO activity_log_ml
							(
								id_transaksi,
								kode,
								nama,
								keterangan,
								created_by,
								username,
								start_on,
								finish_on,
								durasi_detik
							)
							SELECT 
								a.id,
								"UPLOAD",
								"isoittd_upload",
								concat("Upload Transaksi In & Transaksi_out ", 
									JSON_OBJECT(
										"id", a.id,
										"id_isoxxth_upload", a.id_isoxxth_upload,
										"kode", a.kode,
										"nama", a.nama,
										"satuan", a.satuan,
										"lokasi", a.lokasi,
										"jumlah_terkecil", a.jumlah_terkecil,
										"lpn", a.lpn,
										"batch_number", a.batch_number,
										"expired_date", a.expired_date
									)
								) AS json_data,
								:id_users,
								:username,
								:start_at,
								:end,
								:durasi_detik
							FROM isoittd_upload AS a
							WHERE a.id = :id_isoittd_upload
						'
					);
				}
				
			}
		
			$data = array(
				"message" => "Upload Transaksi Berhasil",
				"type_message" => "success",
				// "debug" => $emptyPeg
				// "hem" => $rs_hemxxmh
			);

		
		$db->commit();
		}catch (PDOException $e){
			$db->rollback();
			$data = array(
				"message" => "Upload Transaksi gagal," . $e,
				"type_message" => "danger"
			);
		}
	}else{
		$data = array(
			"message" => "Upload Transaksi gagal, format file salah!",
			"type_message" => "danger"
		);
	}

	// tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>