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
             * 0: Company           : id hod = 1
             * 1: Cabang            : id_gbrxxmh = HO
             * 2: kode Section
			 * 3: nama Section
			 * 
			 * Buat kode header isoxxth_upload auto generate SOU/2403/0001
             */
			//header
			$start_at = date('Y-m-d H:i:s');
			
			$id_users = $hakakses['s_id_users'];
			$username = $hakakses['s_username'];

			$baris_kembar = [];
			if ($sheetData[0]['1'] == "Section") {
				for($i = 1;$i < count($sheetData);$i++){
					$id_hodxxmh = 0;
					$kode 		= strtoupper($sheetData[$i]['0']) ;
					$nama 		= strtoupper($sheetData[$i]['1']) ;
					$hodxxmh_nama 		= strtoupper($sheetData[$i]['2']) ;
					$keterangan 		= strtoupper($sheetData[$i]['3']) ;
					
					$qs_hodxxmh = $db
						->query('select', 'hodxxmh' )
						->get([
							'id',
							'kode'
							] )
						->where('nama', $hodxxmh_nama )
						->exec();
					$rs_hodxxmh = $qs_hodxxmh->fetch();

					if (!empty($rs_hodxxmh)) {
						$id_hodxxmh = $rs_hodxxmh['id'];
					} else {
						$message_data = " Upload Gagal! <br>Department belum terdaftar di master Department!";
						$type_message_data = "warning";
					}

					$qs_hosxxmh = $db
						->query('select', 'hosxxmh' )
						->get(['id'] )
						->where('kode', $kode )
						->where('nama', $nama )
						->where('id_hodxxmh', $id_hodxxmh )
						->exec();
					$rs_hosxxmh = $qs_hosxxmh->fetch();

					if ($id_hodxxmh > 0) {
						if (empty($rs_hosxxmh)) {
							$qi_detail = $db
								->raw()
								->bind(':keterangan', $keterangan)
								->bind(':id_hodxxmh', $id_hodxxmh)
								->bind(':kode', $kode)
								->bind(':nama', $nama)
								->exec('INSERT INTO hosxxmh
										(
											transaction_state,
											nama,
											kode,
											id_hodxxmh,
											keterangan
										)
										SELECT
											1,
											:nama,
											:kode,
											:id_hodxxmh,
											:keterangan
								'
							);
							$dataupload = $dataupload +1;
						} else {
							$datakembar = $datakembar +1;
							$baris_kembar[] = $i+1;
						}

						$message_data = "Upload Master Section Berhasil.</br>" .$dataupload. " data berhasil di import.</br>" . $datakembar. " data kembar TIDAK di import.";
						$type_message_data = "success";
					}
				}

				$data = array(
					"message" => $message_data,
					"type_message" => $type_message_data,
					"baris_kembar" => $baris_kembar
				);
			} else {
				$data = array(
					"message" => "Upload Master Section gagal, template file salah!",
					"type_message" => "error"
				);
			}

		
		$db->commit();
		}catch (PDOException $e){
			$db->rollback();
			$data = array(
				"message" => "Upload Master Section gagal," . $e,
				"type_message" => "error"
			);
		}
	}else{
		$data = array(
			"message" => "Upload Master Section gagal, format file salah!",
			"type_message" => "error"
		);
	}

	// tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>