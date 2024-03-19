<?php
	require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	require_once( "../../../../usersc/vendor/autoload.php" );
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
			$start_at = date('Y-m-d H:i:s');
			for($i = 1;$i < count($sheetData);$i++){
				//header
				// $comp 		= $sheetData[$i]['0'] ; // return 1
				$comp = 1;
				$cab 		= $sheetData[$i]['1'] ;
				$wh 		= $sheetData[$i]['2'] ;
				$tanggal_excel = new Carbon($sheetData[$i]['3']); //gunakan carbon untuk ambil data tanggal
				$tanggal = $tanggal_excel->format('Y-m-d'); //format jadi 2023-09-12
				
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

                // print_r($id_htsxxmh);
				//cari NIK
				// $qs_hemxxmh = $db
				// 	->query('select', 'hemxxmh' )
				// 	->get(['id as id_hemxxmh'] )
				// 	->get(['count(id) as id'] )
				// 	->where('kode', $kode)
				// 	->exec();
				// $rs_hemxxmh = $qs_hemxxmh->fetch();	
				// $id_hemxxmh = $rs_hemxxmh['id_hemxxmh'];

				// if ($rs_hemxxmh['id'] == 0) {
				// 	$emptyPeg[] = array(
				// 		'rowIndex' => $i + 1
				// 	);
				// }

				// $qs_htssctd = $db
				// 	->query('select', 'htssctd' )
				// 	->get([
				// 		'htssctd.id as id_htssctd'
				// 	] )
				// 	->where('htssctd.id_hemxxmh', $id_hemxxmh )
				// 	->where('htssctd.tanggal', $tanggal )
				// 	->where('htssctd.is_active', 1 )
				// 	->exec();
				// $rs_htssctd = $qs_htssctd->fetchAll();
				
				// $c_rs_htssctd = count($rs_htssctd);
				
				// if($c_rs_htssctd == 0){
					
				// 	// Begin insert pengaju
				// 	$qr_htssctd_pengaju = $db
				// 		->raw()
				// 		->bind(':id_htsxxmh', $id_htsxxmh)
				// 		->bind(':id_hemxxmh', $id_hemxxmh)
				// 		->bind(':tanggal', $tanggal)
				// 		->bind(':bagian', $bagian)
				// 		->bind(':grup', $grup)
				// 		->exec('INSERT INTO htssctd
				// 			(
				// 				id_hemxxmh,
				// 				id_htsxxmh,
				// 				keterangan,
				// 				tanggal,
				// 				jam_awal,
				// 				jam_akhir,
				// 				jam_awal_istirahat,
				// 				jam_akhir_istirahat,
				// 				menit_toleransi_awal_in,
				// 				menit_toleransi_akhir_in,
				// 				menit_toleransi_awal_out,
				// 				menit_toleransi_akhir_out,

				// 				tanggaljam_awal_t1,
				// 				tanggaljam_awal,
				// 				tanggaljam_awal_t2,
				// 				tanggaljam_akhir_t1,
				// 				tanggaljam_akhir,
				// 				tanggaljam_akhir_t2,
				// 				tanggaljam_awal_istirahat,
				// 				tanggaljam_akhir_istirahat,
				// 				is_upload_jadwal,
				// 				bagian,
				// 				grup
				// 			)
				// 			SELECT
				// 				:id_hemxxmh,
				// 				:id_htsxxmh,
				// 				"Upload Stok",
				// 				:tanggal,
				// 				htsxxmh.jam_awal,
				// 				htsxxmh.jam_akhir,
				// 				htsxxmh.jam_awal_istirahat,
				// 				htsxxmh.jam_akhir_istirahat,
				// 				htsxxmh.menit_toleransi_awal_in,
				// 				htsxxmh.menit_toleransi_akhir_in,
				// 				htsxxmh.menit_toleransi_awal_out,
				// 				htsxxmh.menit_toleransi_akhir_out,
				// 				CONCAT(:tanggal, " ", TIME(DATE_SUB(htsxxmh.jam_awal, INTERVAL htsxxmh.menit_toleransi_awal_in MINUTE))) AS tanggaljam_awal_t1,
				// 				CONCAT(:tanggal, " ", htsxxmh.jam_awal) AS tanggaljam_awal,
				// 				CONCAT(
				// 					CASE
				// 						WHEN DATE_ADD(htsxxmh.jam_awal, INTERVAL htsxxmh.menit_toleransi_akhir_in MINUTE) >= "24:00:00" THEN DATE_ADD(:tanggal, INTERVAL 1 DAY)
				// 						ELSE :tanggal
				// 					END,
				// 					" ",
				// 					TIME(
				// 						CASE
				// 							WHEN DATE_ADD(htsxxmh.jam_awal, INTERVAL htsxxmh.menit_toleransi_akhir_in MINUTE) >= "24:00:00" THEN
				// 								TIMEDIFF(DATE_ADD(htsxxmh.jam_awal, INTERVAL htsxxmh.menit_toleransi_akhir_in MINUTE), "24:00:00")
				// 							ELSE
				// 								DATE_ADD(htsxxmh.jam_awal, INTERVAL htsxxmh.menit_toleransi_akhir_in MINUTE)
				// 						END
				// 					)
				// 				) AS tanggaljam_awal_t2,

				// 				CASE
				// 					WHEN htsxxmh.kode like "malam%" AND htsxxmh.jam_akhir <= "12:00:00"
				// 					THEN CONCAT(DATE_ADD(:tanggal, INTERVAL 1 DAY), " ", TIME(DATE_SUB(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE)))
				// 					ELSE CONCAT(:tanggal, " ", TIME(DATE_SUB(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE)))
				// 				END AS tanggaljam_akhir_t1,
				// 				CASE
				// 					WHEN htsxxmh.kode like "malam%" AND htsxxmh.jam_akhir <= "12:00:00"
				// 					THEN CONCAT(DATE_ADD(:tanggal, INTERVAL 1 DAY), " ", htsxxmh.jam_akhir)
				// 					ELSE CONCAT(:tanggal, " ", htsxxmh.jam_akhir)
				// 				END AS tanggaljam_akhir,
				// 				CONCAT(
				// 					CASE
				// 						WHEN DATE_ADD(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE) >= "24:00:00" 
				// 							OR htsxxmh.kode like "malam%" AND htsxxmh.jam_akhir <= "12:00:00" THEN DATE_ADD(:tanggal, INTERVAL 1 DAY)
				// 						ELSE :tanggal
				// 					END,
				// 					" ",
				// 					TIME(
				// 						CASE
				// 							WHEN DATE_ADD(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE) >= "24:00:00" THEN
				// 								TIMEDIFF(DATE_ADD(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE), "24:00:00")
				// 							ELSE
				// 								DATE_ADD(htsxxmh.jam_akhir, INTERVAL htsxxmh.menit_toleransi_akhir_out MINUTE)
				// 						END
				// 					)
				// 				) AS tanggaljam_akhir_t2,
				// 				CASE
				// 					WHEN htsxxmh.kode like "malam%" AND htsxxmh.jam_awal_istirahat <= "12:00:00"
				// 					THEN CONCAT(DATE_ADD(:tanggal, INTERVAL 1 DAY), " ", htsxxmh.jam_awal_istirahat)
				// 					ELSE CONCAT(:tanggal, " ", htsxxmh.jam_awal_istirahat)
				// 				END AS tanggaljam_awal_istirahat,
				// 				CASE
				// 					WHEN htsxxmh.kode like "malam%" AND htsxxmh.jam_akhir_istirahat <= "12:00:00"
				// 					THEN CONCAT(DATE_ADD(:tanggal, INTERVAL 1 DAY), " ", htsxxmh.jam_akhir_istirahat)
				// 					ELSE CONCAT(:tanggal, " ", htsxxmh.jam_akhir_istirahat)
				// 				END AS tanggaljam_akhir_istirahat,
				// 				1,
				// 				:bagian,
				// 				:grup
				// 			FROM htsxxmh
				// 			WHERE 
				// 				id = :id_htsxxmh
				// 		');

				// 	// END insert pengaju
					
				// }else{
				// 	$datakembar = $datakembar + 1;
				// }
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
							:comp,
							a.id AS id_gbrxxmh,
							b.id AS id_iwh,
							:tanggal,
							1,
							1,
							:start_at
						FROM gbrxxmh AS a
						LEFT JOIN iwhxxmh AS b ON b.nama = :wh
						WHERE a.nama = :cab
					'
				);

				//Ambil id last insert
				$id_header = $qi_header->insertId();

				//Insert Detail
				$qi_header = $db
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

			//Update Kode dengan SOU/tahun2 digit bulan 2 digit/increment number LPAD 4
			$qi_header = $db
				->raw()
				->bind(':start_at', $start_at)
				->exec('UPDATE isoxxth_upload AS up
						LEFT JOIN (
							WITH start_row AS (
								SELECT
									ROW_NUMBER() OVER (PARTITION BY MONTH(start_at), YEAR(start_at) ORDER BY start_at ASC) AS row_num,
									start_at,
									a.transaction_state
								FROM isoxxth_upload AS a
								WHERE a.start_at IS NOT NULL AND a.is_upload = 1
								GROUP BY MONTH(start_at), YEAR(start_at), start_at
							)
							SELECT
								transaction_state,
								CONCAT(
									"SOU/",
									RIGHT(YEAR(start_at), 2), 
									DATE_FORMAT(start_at, "%m"), 
									"/", 
									LPAD(row_num, 4, "0")
								) AS kode_sou
							FROM start_row
							WHERE start_at = :start_at
						) AS gen_kode ON gen_kode.transaction_state = 1
						SET up.kode = gen_kode.kode_sou
						WHERE up.start_at = :start_at;
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