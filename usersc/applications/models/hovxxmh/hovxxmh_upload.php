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
			$message_data = "";
			$type_message_data = "";
			$emptyPeg = array();
			/**
             *                      : nama
             * 0: Company           : id hov = 1
             * 1: Cabang            : id_gbrxxmh = HO
             * 2: kode Division
			 * 3: nama Division
			 * 
			 * Buat kode header isoxxth_upload auto generate SOU/2403/0001
             */
			//header
			$start_at = date('Y-m-d H:i:s');
			
			$id_users = $hakakses['s_id_users'];
			$username = $hakakses['s_username'];

			$baris_kembar = [];
			if ($sheetData[0]['1'] == "Division") {
				for($i = 1;$i < count($sheetData);$i++){

					$kode 		= strtoupper($sheetData[$i]['0']) ;
					$nama 		= strtoupper($sheetData[$i]['1']) ;
					$keterangan 		= strtoupper($sheetData[$i]['2']) ;
					
					$qs_hovxxmh = $db
						->query('select', 'hovxxmh' )
						->get(['id'] )
						->where('kode', $kode )
						->where('nama', $nama )
						->exec();
					$rs_hovxxmh = $qs_hovxxmh->fetch();

					if (empty($rs_hovxxmh)) {
						$qi_detail = $db
							->raw()
							->bind(':keterangan', $keterangan)
							->bind(':kode', $kode)
							->bind(':nama', $nama)
							->exec('INSERT INTO hovxxmh
									(
										transaction_state,
										nama,
										kode,
										keterangan
									)
									SELECT
										1,
										:nama,
										:kode,
										:keterangan
							'
						);
						$dataupload = $dataupload +1;
					} else {
						$datakembar = $datakembar +1;
						$baris_kembar[] = $i+1;
					}

					$message_data = "Upload Master Division Berhasil.</br>" .$dataupload. " data berhasil di import.</br>" . $datakembar. " data kembar TIDAK di import.";
					$type_message_data = "success";
				}

				$data = array(
					"message" => $message_data,
					"type_message" => $type_message_data,
					"baris_kembar" => $baris_kembar
				);
			} else {
				$data = array(
					"message" => "Upload Master Division gagal, template file salah!",
					"type_message" => "error"
				);
			}

		
		$db->commit();
		}catch (PDOException $e){
			$db->rollback();
			$data = array(
				"message" => "Upload Master Division gagal," . $e,
				"type_message" => "error"
			);
		}
	}else{
		$data = array(
			"message" => "Upload Master Division gagal, format file salah!",
			"type_message" => "error"
		);
	}

	// tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>