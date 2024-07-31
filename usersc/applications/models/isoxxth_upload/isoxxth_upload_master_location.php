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
             * 2: warehouse         : id iwh  = Warehouse Surabaya 01 - 04
             * 3: kode lokasi
			 * 4: nama lokasi
			 * 
			 * Buat kode header isoxxth_upload auto generate SOU/2403/0001
             */
			//header
			$start_at = date('Y-m-d H:i:s');
			
			$id_users = $hakakses['s_id_users'];
			$username = $hakakses['s_username'];

			if ($sheetData[0]['2'] == "warehouse") {
				for($i = 1;$i < count($sheetData);$i++){
					//detail
					$comp 		= strtoupper($sheetData[$i]['0']) ;
					$cab 		= strtoupper($sheetData[$i]['1']) ;
					$warehouse 		= strtoupper($sheetData[$i]['2']) ;
					$kode_lokasi 		= strtoupper($sheetData[$i]['3']) ;
					$nama_lokasi 		= strtoupper($sheetData[$i]['4']) ;
					
					$qs_lokasi_db = $db
						->query('select', 'wloxxmh_upload' )
						->get(['id'] )
						->where('kode', $kode_lokasi )
						->exec();
					$rs_lokasi_db = $qs_lokasi_db->fetch();
	
					if (empty($rs_lokasi_db)) {
						$qi_detail = $db
							->raw()
							->bind(':kode_lokasi', $kode_lokasi)
							->bind(':nama_lokasi', $nama_lokasi)
							->bind(':comp', $comp)
							->bind(':cab', $cab)
							->bind(':warehouse', $warehouse)
							->exec('INSERT INTO wloxxmh_upload
									(
										transaction_state,
										company,
										cabang,
										warehouse,
										kode,
										nama
									)
									SELECT
										1,
										:comp,
										:cab,
										:warehouse,
										:kode_lokasi,
										:nama_lokasi
							'
						);
						$dataupload = $dataupload +1;
					} else {
						$datakembar = $datakembar +1;
					}
				}
				$data = array(
					"message" => "Upload Master Location Berhasil.</br>" .$dataupload. " data berhasil di import.</br>" . $datakembar. " data kembar TIDAK di import.",
					"type_message" => "success"
				);
			} else {
				$data = array(
					"message" => "Upload Master Item gagal, template file salah!",
					"type_message" => "danger"
				);
			}

		
		$db->commit();
		}catch (PDOException $e){
			$db->rollback();
			$data = array(
				"message" => "Upload Master Location gagal," . $e,
				"type_message" => "danger"
			);
		}
	}else{
		$data = array(
			"message" => "Upload Master Location gagal, format file salah!",
			"type_message" => "danger"
		);
	}

	// tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>