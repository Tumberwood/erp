<?php
	/**
	 * Digunakakn untuk upload data saldo awal inventory
	 * DEFINISI kolom dari Excel
	 * 0: Branch Name
	 * 1: Warehouse Name
	 * 2: Location Name
	 * 3: Tanggal
	 * 4: Item Code
	 * 5: Item Name
	 * 6: Quantity Terkecil
	 * 7: UoM Terkecil
	 * 8: LPN
	 * 9: Expired Date
	 * 10: Batch Number
	 */

	require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	require_once( "../../../../usersc/vendor/autoload.php" );
	include_once( "../../../helpers/hakakses_s_fn.php" );
	include_once( "../../../helpers/general_fn.php" );

	use Carbon\Carbon;
	
	use PhpOffice\PhpSpreadsheet\IOFactory;
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Reader\Csv;
	use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
	use PhpOffice\PhpSpreadsheet\Shared\Date;

	// BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
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
	
	if(isset($_FILES['inputfileUpload']['name']) && in_array($_FILES['inputfileUpload']['type'], $file_mimes)) {

		$c_uploaded    = 0;
		$c_failed      = 0;
		$c_skipped_row = 0;

		$token = getRandomStringRandomInt();
		$file  = $_FILES['inputfileUpload']['tmp_name'];

		try {
			$spreadsheet = IOFactory::load($file);
			$hasil       = "Spreadsheet berhasil dimuat.";
			$worksheet   = $spreadsheet->getActiveSheet();
			
			if (!empty($worksheet->toArray())) {
				$hasil = "Worksheet OK.";
				$rowIterator = $worksheet->getRowIterator();
				$dataWorksheet = $worksheet->toArray();

				$startRow    = 2;                            // 1 adalah judul kolom
				$endRow      = $worksheet->getHighestRow();
				$startColumn = 1;
				$endColumn   = 11;

				$db->transaction();

				// Looping data
				for ($row = $startRow; $row <= $endRow; $row++) {

					$rowData = $worksheet->rangeToArray('A' . $row . ':' . $worksheet->getHighestColumn() . $row, null, true, true, true);
					$colData = $rowData[$row];
					
					// hanya memproses baris data yang ada isinya minimal 1 kolom
					if(array_filter($colData)) {
					
						$upload_state = 1;
						for ($col = $startColumn; $col <= $endColumn; $col++) {
							$cellValue    = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
							$cellDataType = $worksheet->getCellByColumnAndRow($col, $row)->getDataType();
							
							switch ($col) {
								case 1:
									$gbrxxmh_nama = $cellValue;
									break;
								case 2:
									$iwhxxmh_nama = $cellValue;
									break;
								case 3:
									if($_POST['is_location'] == 1){
										if($cellValue != ""){
											$wloxxmh_nama = $cellValue;
										}else{
											$wloxxmh_nama = null;
											$upload_state = 2;
										}
									}else{
										$wloxxmh_nama = null;
									}

									break;
								case 4:
									if($cellValue != ""){
										if($cellDataType == 'd' || $cellDataType == 'n'){
											$tanggal_ymd = Date::excelToDateTimeObject($cellValue)->format('Y-m-d');
										}else{
											// jika format salah
											$tanggal_ymd = null;
											$upload_state = 2;
										}
									}else{
										// jika blank
										$tanggal_ymd = null;
										$upload_state = 2;
									}
									break;
								case 5:
									$iimxxmh_kode = $cellValue;
									break;
								case 6:
									$iimxxmh_nama = $cellValue;
									break;
								case 7:
									$jumlah_terkecil = $cellValue;
									break;
								case 8:
									$iumxxmh_kode_terkecil = $cellValue;
									break;
								case 9:
									if($_POST['is_lpn'] == 1){
										if($cellValue != ""){
											$lpn = $cellValue;
										}else{
											$lpn = null;
											$upload_state = 2;
										}
									}else{
										$lpn = null;
									}
									
									break;
								case 10:
									if($_POST['is_expired_date'] == 1){
										if($cellValue != ""){
											if($cellDataType == 'd' || $cellDataType == 'n'){
												$expired_date_ymd = Date::excelToDateTimeObject($cellValue)->format('Y-m-d');
											}else{
												// jika format salah
												$expired_date_ymd = null;
												$upload_state = 2;
											}
										}else{
											// jika blank
											$expired_date_ymd = null;
											$upload_state = 2;
										}
									}else{
										$expired_date_ymd = null;
									}
									
									break;
								case 11:
									if($_POST['is_batch_number'] == 1){
										if($cellValue != ""){
											$batch_number = $cellValue;
										}else{
											$batch_number = null;
											$upload_state = 2;
										}
									}else{
										$batch_number = null;
									}
								default:
									break;
							}
						
						}

						$qi_iivxxrd_sa = $db
							->query('insert', 'iivxxrd_sa')
							->set('kode',$token)
							->set('gbrxxmh_nama',$gbrxxmh_nama)
							->set('iwhxxmh_nama',$iwhxxmh_nama)
							->set('wloxxmh_nama',$wloxxmh_nama)
							->set('tanggal',$tanggal_ymd)
							->set('iimxxmh_kode',$iimxxmh_kode)
							->set('iimxxmh_nama',$iimxxmh_nama)
							->set('jumlah_terkecil',$jumlah_terkecil)
							->set('iumxxmh_kode_terkecil',$iumxxmh_kode_terkecil)
							->set('lpn',$lpn)							
							->set('expired_date',$expired_date_ymd)
							->set('batch_number',$batch_number)
							->set('upload_state', $upload_state)
							->exec();

						if($qi_iivxxrd_sa){
							$c_uploaded = $c_uploaded + 1;
						}else{
							$c_failed = $c_failed + 1;
						}

						// ambil dan update id_parent
						$qs_parent = $db
							->raw()
							->bind(':token', $token )
							->exec('
								UPDATE iivxxrd_sa p
								LEFT JOIN 
								(
									SELECT
										a.id as id_iivxxrd_sa,
										b.id AS id_gbrxxmh,
										c.id AS id_iwhxxmh,
										d.id AS id_wloxxmh,
										e1.id AS id_iimxxmh_kode,
										e2.id AS id_iimxxmh_nama,
										f.id AS id_iumxxmh_terkecil,
										CASE
											WHEN b.id IS NULL OR
												c.id IS NULL OR
												d.id IS NULL OR
												e1.id IS NULL OR
												e2.id IS NULL OR
												f.id IS NULL THEN 1
											ELSE 0
										END AS ada_null
									FROM iivxxrd_sa a
									LEFT JOIN gbrxxmh b ON b.nama = a.gbrxxmh_nama
									LEFT JOIN iwhxxmh c ON c.nama = a.iwhxxmh_nama
									LEFT JOIN wloxxmh d ON d.nama = a.wloxxmh_nama
									LEFT JOIN iimxxmh e1 ON e1.kode = a.iimxxmh_kode
									LEFT JOIN iimxxmh e2 ON e2.nama = a.iimxxmh_nama
									LEFT JOIN iumxxmh f ON f.kode = a.iumxxmh_kode_terkecil
									WHERE 1
										AND a.kode = :token
								) q ON p.id = q.id_iivxxrd_sa
								SET
									p.id_gbrxxmh = q.id_gbrxxmh,
									p.id_iwhxxmh = q.id_iwhxxmh,
									p.id_wloxxmh = q.id_wloxxmh,
									p.id_iimxxmh = q.id_iimxxmh_kode,
									p.id_iumxxmh_terkecil = q.id_iumxxmh_terkecil
								WHERE
									p.kode = :token
								
							');

					}else{
						$c_skipped_row = $c_skipped_row + 1;
					}

				}

				$status_code = 200;
				$message = 'Berhasil: ' . $c_uploaded . '</br>' . 'Gagal: ' . $c_failed . '</br>'. 'Skip: ' . $c_skipped_row . '</br>';
				$type_message = 'success';
	
				$db->commit();
	
			} else {
				$status_code  = 500;
				$message      = "Upload Stok Gagal! Worksheet kosong.";
				$type_message = "error";
			}
			
		

		} catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
			$status_code  = 500;
			$message      = "Terjadi kesalahan saat memuat spreadsheet: " . $e->getMessage();
			$type_message = "error";
		}

		
	}else{
		$status_code  = 500;
		$message      = "Upload Stok gagal, format file salah!";
		$type_message = "error";
	}

	$data = array(
		"status_code" => $status_code,
		"message" => $message,
		"type_message" => $type_message
	);

	// tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>