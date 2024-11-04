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
             * 2: kode Department
			 * 3: nama Department
			 * 
			 * Buat kode header isoxxth_upload auto generate SOU/2403/0001
             */
			//header
			$start_at = date('Y-m-d H:i:s');
			
			$id_users = $hakakses['s_id_users'];
			$username = $hakakses['s_username'];

			$baris_kembar = [];
			if ($sheetData[0]['1'] == "Department") {
				for($i = 1;$i < count($sheetData);$i++){
					$id_hovxxmh = 0;
					$kode 		= strtoupper($sheetData[$i]['0']) ;
					$nama 		= strtoupper($sheetData[$i]['1']) ;
					$hovxxmh_nama 		= strtoupper($sheetData[$i]['2']) ;
					$keterangan 		= strtoupper($sheetData[$i]['3']) ;
					
					$qs_hovxxmh = $db
						->query('select', 'hovxxmh' )
						->get([
							'id',
							'kode'
							] )
						->where('nama', $hovxxmh_nama )
						->exec();
					$rs_hovxxmh = $qs_hovxxmh->fetch();

					if (!empty($rs_hovxxmh)) {
						$id_hovxxmh = $rs_hovxxmh['id'];
					} else {
						$message_data = " Upload Gagal! <br>Divisi belum terdaftar di master Divisi!";
						$type_message_data = "warning";
					}

					$qs_hodxxmh = $db
						->query('select', 'hodxxmh' )
						->get(['id'] )
						->where('kode', $kode )
						->where('nama', $nama )
						->where('id_hovxxmh', $id_hovxxmh )
						->exec();
					$rs_hodxxmh = $qs_hodxxmh->fetch();

					if ($id_hovxxmh > 0) {
						if (empty($rs_hodxxmh)) {
							$qi_detail = $db
								->raw()
								->bind(':keterangan', $keterangan)
								->bind(':id_hovxxmh', $id_hovxxmh)
								->bind(':kode', $kode)
								->bind(':nama', $nama)
								->exec('INSERT INTO hodxxmh
										(
											transaction_state,
											nama,
											kode,
											id_hovxxmh,
											keterangan
										)
										SELECT
											1,
											:nama,
											:kode,
											:id_hovxxmh,
											:keterangan
								'
							);
							$dataupload = $dataupload +1;
						} else {
							$datakembar = $datakembar +1;
							$baris_kembar[] = $i+1;
						}

						$message_data = "Upload Master Department Berhasil.</br>" .$dataupload. " data berhasil di import.</br>" . $datakembar. " data kembar TIDAK di import.";
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
					"message" => "Upload Master Department gagal, template file salah!",
					"type_message" => "error"
				);
			}

		
		$db->commit();
		}catch (PDOException $e){
			$db->rollback();
			$data = array(
				"message" => "Upload Master Department gagal," . $e,
				"type_message" => "error"
			);
		}
	}else{
		$data = array(
			"message" => "Upload Master Department gagal, format file salah!",
			"type_message" => "error"
		);
	}

	// tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>