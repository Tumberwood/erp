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
			 * 10: batch_number number = 
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

			$tanggal_upload_post =  new Carbon($_POST['tanggal_upload']);
			$tanggal_upload = $tanggal_upload_post->format('Y-m-d');
			
			$start_at = date('Y-m-d H:i:s');
			
			$id_users = $hakakses['s_id_users'];
			$username = $hakakses['s_username'];

			$id_parent = 0;
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				if(isset($_POST['id_parent'])) {
					$id_parent = $_POST['id_parent'];
					// print_r($id_parent);
				}
			}
			//Insert Header isoxxth_uplaod
			// $qi_header = $db
			// 	->raw()
			// 	->bind(':comp', $comp)
			// 	->bind(':cab', $cab)
			// 	->bind(':wh', $wh)
			// 	->bind(':tanggal', $tanggal)
			// 	->bind(':start_at', $start_at)
			// 	->exec('INSERT INTO isoxxth_upload
			// 		(
			// 			id_gcpxxmh,
			// 			id_gbrxxmh,
			// 			id_iwhxxmh,
			// 			tanggal,
			// 			transaction_state,
			// 			is_upload,
			// 			start_at
			// 		)
			// 		SELECT
			// 			c.id AS id_gcpxxmh,
			// 			a.id AS id_gbrxxmh,
			// 			b.id AS id_iwh,
			// 			:tanggal,
			// 			1,
			// 			1,
			// 			:start_at
			// 		FROM gbrxxmh AS a
			// 		INNER JOIN iwhxxmh AS b ON b.nama = :wh
			// 		INNER JOIN gcpxxmh AS c ON c.nama = :comp
			// 		WHERE a.nama = :cab
			// 	'
			// );

			//Insert ID diganti Varchar
			$qi_header = $db
				->raw()
				->bind(':comp', $comp)
				->bind(':cab', $cab)
				->bind(':wh', $wh)
				->bind(':tanggal', $tanggal)
				->bind(':tanggal_upload', $tanggal_upload)
				->bind(':start_at', $start_at)
				->bind(':id_parent', $id_parent)
				->exec('INSERT INTO isoxxth_upload
					(
						id_isoxxth_upload_parent,
						company,
						cabang,
						warehouse,
						tanggal,
						tanggal_upload,
						transaction_state,
						is_upload,
						start_at
					)
					SELECT
						:id_parent,
						:comp,
						:cab,
						:wh,
						:tanggal,
						:tanggal_upload,
						1,
						1,
						:start_at
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
				$lokasi 		= strtoupper($sheetData[$i]['8']) ;
				$lpn 		= strtoupper($sheetData[$i]['9']) ;
				$batch_number 		= strtoupper($sheetData[$i]['10']) ;

				$expired_date = new Carbon($sheetData[$i]['11']); //gunakan carbon untuk ambil data expired_date
				// $expired_date = $exp_date_excel->format('Y-m-d'); //format jadi 2023-09-12
				// $exp_date_excel = new Carbon($sheetData[$i]['11']); //gunakan carbon untuk ambil data expired_date
				// $expired_date = $exp_date_excel->format('Y-m-d'); //format jadi 2023-09-12

				// //Insert Detail
				// $qi_detail = $db
				// 	->raw()
				// 	->bind(':id_header', $id_header)
				// 	->bind(':nama_item', $nama_item)
				// 	->bind(':qty', $qty)
				// 	->bind(':uom', $uom)
				// 	->bind(':lokasi', $lokasi)
				// 	->bind(':lpn', $lpn)
				// 	->bind(':batch_number', $batch_number)
				// 	->bind(':expired_date', $expired_date)
				// 	->exec('INSERT INTO isoittd_upload
				// 			(
				// 				id_isoxxth_upload,
				// 				transaction_state,
				// 				is_upload,
				// 				id_iimxxmh,
				// 				jumlah_terkecil,
				// 				id_iumxxmh_terkecil,
				// 				id_wloxxmh,
				// 				lpn,
				// 				batch_number,
				// 				expired_date
				// 			)
				// 			SELECT
				// 				:id_header,
				// 				1,
				// 				1,
				// 				a.id,
				// 				:qty,
				// 				b.id,
				// 				c.id,
				// 				:lpn,
				// 				:batch_number,
				// 				:expired_date
				// 			FROM iimxxmh AS a
				// 			LEFT JOIN iumxxmh AS b ON b.kode = :uom
				// 			LEFT JOIN wloxxmh AS c ON c.nama = :lokasi
				// 			WHERE a.nama = :nama_item
				// 	'
				// );	

				//Jika id parent diisi, atau jika kode dipilih
				if ($id_parent > 0) {

					//nonaktifkan semua data item yang belum diisi fisiknya dan yang bukan skip, sesuai id parent
					$qu_data_kembar = $db
						->raw()
						->bind(':id_parent', $id_parent)
						->bind(':id_header', $id_header)
						->exec('UPDATE isoittd_upload a
								LEFT JOIN isoxxth_upload b ON b.id = a.id_isoxxth_upload
								SET 
									a.transaction_state = -9
								WHERE a.fisik IS NULL AND a.is_skip = 0 AND (a.id_isoxxth_upload = :id_parent OR b.id_isoxxth_upload_parent = :id_parent) AND a.id_isoxxth_upload <> :id_header
							'
					);
					
					//select data kembar yang udah ada fisiknya
					//dengan parameter kode item, lpn, batch_number number dan expired date
					
					$qs_data_kembar = $db
						->raw()
						->bind(':kode_item', $kode_item)
						->bind(':lpn', $lpn)
						->bind(':batch_number', $batch_number)
						->bind(':expired_date', $expired_date)
						->bind(':lokasi', $lokasi)
						->bind(':id_parent', $id_parent)
						->exec('SELECT
									a.kode,
									a.nama,
									a.jumlah_terkecil,
									a.satuan,
									a.lokasi,
									a.lpn,
									a.batch_number,
									a.expired_date
								FROM isoittd_upload a
								LEFT JOIN isoxxth_upload  c ON c.id = a.id_isoxxth_upload
								WHERE (a.fisik >= 0 OR a.is_skip = 1) AND a.transaction_state <> -9 AND (a.id_isoxxth_upload = :id_parent OR c.id_isoxxth_upload_parent = :id_parent)
								AND a.kode = :kode_item AND a.lpn = :lpn AND ifnull(a.batch_number, "") = :batch_number 
								AND a.expired_date = :expired_date AND a.lokasi = :lokasi
								GROUP BY a.id
							'
					);
					$rs_data_kembar = $qs_data_kembar->fetch();
					
					//Jika tidak ditemukan, maka insert data uploadnya
					if (empty($rs_data_kembar)) {
						//Update data lama menjadi non aktif
						// $qu_data_kembar = $db
						// 	->raw()
						// 	->bind(':kode_item', $kode_item)
						// 	->bind(':lpn', $lpn)
						// 	->bind(':batch_number', $batch_number)
						// 	->bind(':expired_date', $expired_date)
						// 	->bind(':lokasi', $lokasi)
						// 	->bind(':id_parent', $id_parent)
						// 	->exec('UPDATE isoittd_upload a
						// 			LEFT JOIN isoxxth_upload  c ON c.id = a.id_isoxxth_upload
						// 			SET 
						// 				a.transaction_state = -9
						// 			WHERE a.transaction_state <> -9 AND (a.id_isoxxth_upload = :id_parent OR c.id_isoxxth_upload_parent = :id_parent)
						// 			AND a.kode = :kode_item AND a.lpn = :lpn AND ifnull(a.batch_number, "") = :batch_number 
						// 			AND a.expired_date = :expired_date AND a.lokasi = :lokasi
						// 		'
						// );
	
						//Insert Detail
						$qi_detail = $db
							->raw()
							->bind(':id_header', $id_header)
							->bind(':kode_item', $kode_item)
							->bind(':nama_item', $nama_item)
							->bind(':qty', $qty)
							->bind(':uom', $uom)
							->bind(':lokasi', $lokasi)
							->bind(':lpn', $lpn)
							->bind(':batch_number', $batch_number)
							->bind(':expired_date', $expired_date)
							->exec('INSERT INTO isoittd_upload
									(
										id_isoxxth_upload,
										transaction_state,
										is_upload,
										kode,
										nama,
										jumlah_terkecil,
										satuan,
										lokasi,
										lpn,
										batch_number,
										expired_date
									)
									SELECT
										:id_header,
										1,
										1,
										:kode_item,
										:nama_item,
										:qty,
										:uom,
										:lokasi,
										:lpn,
										:batch_number,
										:expired_date
							'
						);
						$dataupload = $dataupload + 1;
					}
				} else {
					//Jika tidak memilih kode SOU artinya data ini adalah parent nya
					//Insert Detail
					$qi_detail = $db
						->raw()
						->bind(':id_header', $id_header)
						->bind(':kode_item', $kode_item)
						->bind(':nama_item', $nama_item)
						->bind(':qty', $qty)
						->bind(':uom', $uom)
						->bind(':lokasi', $lokasi)
						->bind(':lpn', $lpn)
						->bind(':batch_number', $batch_number)
						->bind(':expired_date', $expired_date)
						->exec('INSERT INTO isoittd_upload
								(
									id_isoxxth_upload,
									transaction_state,
									is_upload,
									kode,
									nama,
									jumlah_terkecil,
									satuan,
									lokasi,
									lpn,
									batch_number,
									expired_date
								)
								SELECT
									:id_header,
									1,
									1,
									:kode_item,
									:nama_item,
									:qty,
									:uom,
									:lokasi,
									:lpn,
									:batch_number,
									:expired_date
						'
					);
					$dataupload = $dataupload + 1;
				}
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
							"company", a.company,
							"cabang", a.cabang,
							"warehouse", a.warehouse,
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
							"kode", a.kode,
							"nama", a.nama,
							"satuan", a.satuan,
							"lokasi", a.lokasi,
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