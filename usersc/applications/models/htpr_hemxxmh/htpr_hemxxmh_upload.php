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
			
			$start_at = date('Y-m-d H:i:s');
			
			$id_users = $hakakses['s_id_users'];
			$username = $hakakses['s_username'];

			$baris_kembar = [];
			if ($sheetData[0]['1'] == "Komponen") {
				for($i = 1;$i < count($sheetData);$i++){
					$id_hpcxxmh = 0;
					$tanggal_efektif 		= strtoupper($sheetData[$i]['0']) ;
					$hpcxxmh_nama 		= strtoupper($sheetData[$i]['1']) ;
					$nominal 		= strtoupper($sheetData[$i]['2']) ;
					$keterangan 		= strtoupper($sheetData[$i]['3']) ;

					$id_header = 0;
					if ($_SERVER["REQUEST_METHOD"] == "POST") {
						if(isset($_POST['id_header'])) {
							$id_header = $_POST['id_header'];
							// print_r($id_header);
						}
					}

					$qs_hpcxxmh = $db
						->query('select', 'hpcxxmh' )
						->get([
							'id'
							] )
						->where('nama', $hpcxxmh_nama )
						->exec();
					$rs_hpcxxmh = $qs_hpcxxmh->fetch();

					if (!empty($rs_hpcxxmh)) {
						$id_hpcxxmh = $rs_hpcxxmh['id'];
					} else {
						$message_data = " Upload Gagal! <br>Komponen belum terdaftar!";
						$type_message_data = "warning";
					}

					$qs_htpr_hemxxmh = $db
						->query('select', 'htpr_hemxxmh' )
						->get(['id'] )
						->where('tanggal_efektif', $tanggal_efektif )
						->where('id_hpcxxmh', $id_hpcxxmh )
						->where('id_hemxxmh', $id_header )
						->exec();
					$rs_htpr_hemxxmh = $qs_htpr_hemxxmh->fetch();

					if ($id_hpcxxmh > 0) {
						if (empty($rs_htpr_hemxxmh)) {
							$qi_detail = $db
								->raw()
								->bind(':keterangan', $keterangan)
								->bind(':id_hpcxxmh', $id_hpcxxmh)
								->bind(':tanggal_efektif', $tanggal_efektif)
								->bind(':id_header', $id_header)
								->bind(':nominal', $nominal)
								->exec('INSERT INTO htpr_hemxxmh
										(
											transaction_state,
											nominal,
											id_hemxxmh,
											tanggal_efektif,
											id_hpcxxmh,
											keterangan
										)
										SELECT
											1,
											:nominal,
											:id_header,
											:tanggal_efektif,
											:id_hpcxxmh,
											:keterangan
								'
							);
							$dataupload = $dataupload +1;
						} else {
							$datakembar = $datakembar +1;
							$baris_kembar[] = $i+1;
						}

						$message_data = "Upload Master Gaji Karyawan Berhasil.</br>" .$dataupload. " data berhasil di import.</br>" . $datakembar. " data kembar TIDAK di import.";
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
					"message" => "Upload Master Gaji Karyawan gagal, template file salah!",
					"type_message" => "error"
				);
			}

		
		$db->commit();
		}catch (PDOException $e){
			$db->rollback();
			$data = array(
				"message" => "Upload Master Gaji Karyawan gagal," . $e,
				"type_message" => "error"
			);
		}
	}else{
		$data = array(
			"message" => "Upload Master Gaji Karyawan gagal, format file salah!",
			"type_message" => "error"
		);
	}

	// tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>