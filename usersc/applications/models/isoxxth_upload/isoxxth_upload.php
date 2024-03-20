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
			$emptyPeg = array();
			/**
             *                      : nama
             * 0: Company           : id gcp = 1
             * 1: Cabang            : id_gbrxxmh = HO
             * 2: Warehouse         : id iwh  = Warehouse Surabaya 01 - 04
             * 3: Tanggal
			 * 4: item code : 20090903
			 * 5: item Name
			 * 6: qty
			 * 7: uom = kode iumxxmh = PCS, BOX
			 * 8: location : id_wloxxmh
			 * 9 : lpn = 
			 * 10: batch number = 
			 * 11: expr date
			 * 
			 * Buat kode header isoxxth_upload auto generate SOU/2403/0001
             */
			//header
			$comp 		= $sheetData['1']['0'] ; // return 1
			// $comp = 1;
			$cab 		= $sheetData['1']['1'] ;
			$wh 		= $sheetData['1']['2'] ;
			$tanggal_excel = new Carbon($sheetData['1']['3']); //gunakan carbon untuk ambil data tanggal
			$tanggal = $tanggal_excel->format('Y-m-d'); //format jadi 2023-09-12
			
			$start_at = date('Y-m-d H:i:s');
			
			$id_users = $hakakses['s_id_users'];
			$username = $hakakses['s_username'];
			//Insert Header isoxxth_uplaod
			$qi_header = $db
				->raw()
				->bind(':comp', $comp)
				->bind(':cab', $cab)
				->bind(':wh', $wh)
				->bind(':tanggal', $tanggal)
				->bind(':start_at', $start_at)
				->exec('INSERT INTO isoxxth_upload
					(
						id_gcpxxmh,
						id_gbrxxmh,
						id_iwhxxmh,
						tanggal,
						transaction_state,
						is_upload,
						start_at
					)
					SELECT
						c.id AS id_gcpxxmh,
						a.id AS id_gbrxxmh,
						b.id AS id_iwh,
						:tanggal,
						1,
						1,
						:start_at
					FROM gbrxxmh AS a
					INNER JOIN iwhxxmh AS b ON b.nama = :wh
					INNER JOIN gcpxxmh AS c ON c.nama = :comp
					WHERE a.nama = :cab
				'
			);
			
			//Ambil id last insert
			$id_header = $qi_header->insertId();
			
			//Update Kode dengan SOU/tahun2 digit bulan 2 digit/increment number LPAD 4
			$qi_header = $db
				->raw()
				->bind(':id_header', $id_header)
				->exec('UPDATE isoxxth_upload AS up
						LEFT JOIN (
							WITH header AS (
								SELECT
									tanggal,
									transaction_state
								FROM isoxxth_upload
								WHERE id = :id_header
							)
							SELECT
								b.transaction_state,
								CONCAT(
									"SOU/",
									RIGHT(YEAR(header.tanggal), 2), 
									DATE_FORMAT(header.tanggal, "%m"), 
									"/", 
									LPAD(COUNT(b.id), 4, "0")
								) AS kode_sou
							FROM header
							LEFT JOIN isoxxth_upload AS b ON b.transaction_state = 1 AND MONTH(header.tanggal) = MONTH(b.tanggal) AND YEAR(header.tanggal) = YEAR(b.tanggal)
						) AS gen_kode ON gen_kode.transaction_state = 1
						SET up.kode = gen_kode.kode_sou
						WHERE up.id = :id_header;
					'
			);

			for($i = 1;$i < count($sheetData);$i++){
				//detail
				$kode_item 		= strtoupper($sheetData[$i]['4']) ;
				$nama_item 		= strtoupper($sheetData[$i]['5']) ;
				$qty 		= strtoupper($sheetData[$i]['6']) ;
				$uom 		= strtoupper($sheetData[$i]['7']) ;
				$id_wloxxmh 		= strtoupper($sheetData[$i]['8']) ;
				$lpn 		= strtoupper($sheetData[$i]['9']) ;
				$batch 		= strtoupper($sheetData[$i]['10']) ;

				$exp_date_excel = new Carbon($sheetData[$i]['11']); //gunakan carbon untuk ambil data exp_date
				$exp_date = $exp_date_excel->format('Y-m-d'); //format jadi 2023-09-12

				//Insert Detail
				$qi_detail = $db
					->raw()
					->bind(':id_header', $id_header)
					->bind(':nama_item', $nama_item)
					->bind(':qty', $qty)
					->bind(':uom', $uom)
					->bind(':id_wloxxmh', $id_wloxxmh)
					->bind(':lpn', $lpn)
					->bind(':batch', $batch)
					->bind(':exp_date', $exp_date)
					->exec('INSERT INTO isoittd_upload
							(
								id_isoxxth_upload,
								transaction_state,
								id_iimxxmh,
								jumlah_terkecil,
								id_iumxxmh_terkecil,
								id_wloxxmh,
								lpn,
								batch_number,
								expired_date
							)
							SELECT
								:id_header,
								1,
								a.id,
								:qty,
								b.id,
								c.id,
								:lpn,
								:batch,
								:exp_date
							FROM iimxxmh AS a
							LEFT JOIN iumxxmh AS b ON b.kode = :uom
							LEFT JOIN wloxxmh AS c ON c.nama = :id_wloxxmh
							WHERE a.nama = :nama_item
					'
				);
				$dataupload = $dataupload + 1;
			}
			
			$end = date('Y-m-d H:i:s');
			$durasi_detik = strtotime($end) - strtotime($start_at);

			//Insert Activity Log isoxxth_uplaod
			$qi_log = $db
				->raw()
				->bind(':id_users', $id_users)
				->bind(':username', $username)
				->bind(':start_at', $start_at)
				->bind(':end', $end)
				->bind(':durasi_detik', $durasi_detik)
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
						"isoxxth_upload",	
						JSON_OBJECT(
							"id", id,
							"kode", a.kode,
							"id_gcpxxmh", a.id_gcpxxmh,
							"id_gbrxxmh", a.id_gbrxxmh,
							"id_iwhxxmh", a.id_iwhxxmh,
							"tanggal", a.tanggal,
							"start_at", a.start_at,
							"is_upload", a.is_upload
						) AS json_data,
						:id_users,
						:username,
						:start_at,
						:end,
						:durasi_detik
					FROM isoxxth_upload AS a
					WHERE a.start_at = :start_at AND a.is_upload = 1
				'
			);

			//Insert Detail Activity Log
			$qi_log = $db
				->raw()
				->bind(':id_users', $id_users)
				->bind(':username', $username)
				->bind(':start_at', $start_at)
				->bind(':end', $end)
				->bind(':durasi_detik', $durasi_detik)
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
						JSON_OBJECT(
							"id", a.id,
							"id_isoxxth_upload", a.id_isoxxth_upload,
							"id_iimxxmh", a.id_iimxxmh,
							"id_iumxxmh_terkecil", a.id_iumxxmh_terkecil,
							"id_wloxxmh", a.id_wloxxmh,
							"jumlah_terkecil", a.jumlah_terkecil,
							"lpn", a.lpn,
							"batch_number", a.batch_number,
							"expired_date", a.expired_date
						) AS json_data,
						:id_users,
						:username,
						:start_at,
						:end,
						:durasi_detik
					FROM isoittd_upload AS a
					LEFT JOIN isoxxth_upload AS b ON b.id = a.id_isoxxth_upload
					WHERE b.start_at = :start_at AND b.is_upload = 1
				'
			);
			
			// print_r(count($emptyPeg));
			// if (count($emptyPeg) >= 1) {
			// 	$errorMessage = "";
			// 	foreach ($emptyPeg as $index => $emptyPegawai) {
			// 		$rowIndex = $emptyPegawai['rowIndex'];
			// 		$errorMessage .= $rowIndex;
			// 		if ($index < count($emptyPeg) - 1) {
			// 			$errorMessage .= ", ";
			// 		}
			// 	}
			// 	$data = array(
			// 		"message" => "No Akun tidak sesuai pada Baris " . $errorMessage,
			// 		"type_message" => "danger"
			// 	);
			// } else {
				$data = array(
					"message" => "Upload Stok Berhasil.</br>" .$dataupload. " data berhasil di import.</br>" . $datakembar. " data kembar TIDAK di import.",
					"type_message" => "success",
					"debug" => $emptyPeg
					// "hem" => $rs_hemxxmh
				);
			// }

		
		$db->commit();
		}catch (PDOException $e){
			$db->rollback();
			$data = array(
				"message" => "Upload Stok gagal," . $e,
				"type_message" => "danger"
			);
		}
	}else{
		$data = array(
			"message" => "Upload Stok gagal, format file salah!",
			"type_message" => "danger"
		);
	}

	// tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>