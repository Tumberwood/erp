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
			
			$start_at = date('Y-m-d H:i:s');
			
			$id_users = $hakakses['s_id_users'];
			$username = $hakakses['s_username'];


			$pesan = '';
			if ($sheetData[0]['2'] == "Parent Account") {
				for($i = 1;$i < count($sheetData);$i++){
							
					$is_valid_kode = 0;
					$is_valid_nama = 0;
					$is_valid_aatxxmh = 0;
					$id_aakxxmh_parent = 0;
					
					$urutan = $i +1;
					//detail
					$kode 					= strtoupper($sheetData[$i]['0']) ;
					$nama 					= strtoupper($sheetData[$i]['1']) ;
					$is_parent 				= strtoupper($sheetData[$i]['2']) ;
					$aakxxmh_parent 		= strtoupper($sheetData[$i]['3']) ;
					$aatxxmh 			= strtoupper($sheetData[$i]['4']) ;
					$saldo_awal 			= strtoupper($sheetData[$i]['5']) ;
					$saldo_awal_tanggal 	= strtoupper($sheetData[$i]['6']) ;
					
					$qs_kode = $db
						->query('select', 'aakxxmh' )
						->get(['id'] )
						->where('kode', $kode )
						->exec();
					$rs_kode = $qs_kode->fetch();

					if (empty($rs_kode)) {
						$is_valid_kode = 1;
					} else {
						$is_valid_kode = 0;
						$pesan .= "[{$urutan}] Kode {$kode} sudah pernah dibuat! <br>";
					}
					
					$qs_nama = $db
						->query('select', 'aakxxmh' )
						->get(['id'] )
						->where('nama', $nama )
						->exec();
						$rs_nama = $qs_nama->fetch();

						if (empty($rs_nama)) {
							$is_valid_nama = 1;
					} else {
						$is_valid_nama = 0;
						$pesan .= "[{$urutan}] Nama {$nama} sudah pernah dibuat! <br>";
					}
					
					$qs_aatxxmh = $db
						->query('select', 'aatxxmh' )
						->get(['id'] )
						->where('nama', $aatxxmh )
						->exec();
					$rs_aatxxmh = $qs_aatxxmh->fetch();
					
					if (!empty($rs_aatxxmh)) {
						$id_aatxxmh = $rs_aatxxmh['id'];
						$is_valid_aatxxmh = 1;
					} else {
						$is_valid_aatxxmh = 0;
						$pesan .= "[{$urutan}] COA Type {$aatxxmh} tidak terdaftar! <br>";
					}
					
					if ($aakxxmh_parent != '') {
						$qs_parent = $db
							->query('select', 'aakxxmh' )
							->get(['id'] )
							->where('nama', $aakxxmh_parent )
							->exec();
						$rs_parent = $qs_parent->fetch();

						if (!empty($rs_parent)) {
							$is_valid_parent = 1;
							$id_aakxxmh_parent = $rs_parent['id'];
						} else {
							$is_valid_parent = 0;
							$pesan .= "[{$urutan}] Nama Parent {$aakxxmh_parent} tidak terdaftar! <br>";
						}
					} else {
						$is_valid_parent = 1;
						$id_aakxxmh_parent = 0;
					}
					
	
					if ($is_valid_kode == 1 && $is_valid_nama == 1 && $is_valid_aatxxmh == 1 && $is_valid_parent == 1) {
						$qi_detail = $db
							->raw()
							->bind(':kode', $kode)
							->bind(':nama', $nama)
							->bind(':is_parent', $is_parent)
							->bind(':id_aakxxmh_parent', $id_aakxxmh_parent)
							->bind(':id_aatxxmh', $id_aatxxmh)
							->bind(':saldo_awal', $saldo_awal)
							->bind(':saldo_awal_tanggal', $saldo_awal_tanggal)
							->exec('INSERT INTO aakxxmh (
										transaction_state,
										kode,
										nama,
										is_parent,
										id_aakxxmh_parent,
										id_aatxxmh,
										saldo_awal,
										saldo_awal_tanggal
									)
									SELECT 
										1,
										:kode,
										:nama,
										IF(:is_parent = 1, "YES", "NO"),
										:id_aakxxmh_parent,
										:id_aatxxmh,
										:saldo_awal,
										:saldo_awal_tanggal
									FROM DUAL'
						); 
						
						$id_aakxxmh_insert = $qi_detail->insertId();  // ambil id 
						// Tambahkan FROM DUAL agar bisa SELECT tanpa tabel

						//Jurnal
						$keterangan = "Master aakxxmh = ". $nama;
						$tanggal = date('Y-m-d', strtotime($saldo_awal_tanggal));
						$rs_header['tanggal'] = $tanggal;
						// BEGIN generate kode JV
						include_once("../../../../usersc/helpers/kode_fn_generate_jv.php");
						// END generate kode JV
						
						if ($saldo_awal > 0) {
							$sql_insert_aglxxth = $db
								->raw()
								->bind(':saldo_awal_tanggal', $saldo_awal_tanggal)
								->bind(':s_id_users', $s_id_users)
								->bind(':kode', $kode)
								->bind(':id', $id_aakxxmh_insert)
								->exec('INSERT INTO aglxxth (
											id_gbrxxmh,
											id_transaksi_h,
											kode,
											created_by,
											start_at,
											finish_at,
											tanggal,
											keterangan,
											jenis_transaksi,
											kode_transaksi,
											total_debit,
											total_kredit
										)
										SELECT
											0,
											a.id,
											:kode,
											:s_id_users,
											NOW(),
											NOW(),
											:saldo_awal_tanggal,
											CONCAT("Upload Master aakxxmh = ", a.nama) keterangan,
											"Chart of Account",
											a.kode,
											a.saldo_awal,
											a.saldo_awal
										FROM aakxxmh a
										WHERE a.id = :id
							');
							
							$last_id = $sql_insert_aglxxth->insertId();  // ambil id 
								
							// insert Debit
							$qi_debit = $db
								->query('insert', 'aglaktd')
								->set('id_aglxxth', $last_id)
								->set('id_aakxxmh', $id_aakxxmh_insert)
								->set('id_transaksi_d', 0 )
								->set('created_by',$s_id_users)
								->set('start_at',date('Y-m-d H:i:s') )
								->set('finish_at',date('Y-m-d H:i:s') )
								->set('keterangan',$keterangan)
								->set('debit_kredit', 'Debit')
								->set('debit', $saldo_awal)
								->set('kredit', 0)
								->exec()
							;

							$qs_ggsaksh = $db
								->query('select', 'ggsaksh' )
								->get(['id_aakxxmh_ekuitas'] )
								->where('id', 1 )
								->exec();
							$rs_ggsaksh = $qs_ggsaksh->fetch();
							$id_aakxxmh_ekuitas = $rs_ggsaksh['id_aakxxmh_ekuitas'];
								
							// insert Kredit
							$qi_kredit = $db
								->query('insert', 'aglaktd')
								->set('id_aglxxth', $last_id)
								->set('id_aakxxmh', $id_aakxxmh_ekuitas)
								->set('id_transaksi_d', 0 )
								->set('created_by',$s_id_users)
								->set('start_at',date('Y-m-d H:i:s') )
								->set('finish_at',date('Y-m-d H:i:s') )
								->set('keterangan',$keterangan)
								->set('debit_kredit', 'Kredit')
								->set('debit', 0)
								->set('kredit', $saldo_awal)
								->exec()
							;
						}
						$dataupload = $dataupload +1;
					}
				}
				$data = array(
					"message" => "Upload Master COA Berhasil.</br>" .$dataupload. " data berhasil di import.</br>" 
					. $pesan,
					"type_message" => "success"
				);
			} else {
				$data = array(
					"message" => "Upload Master COA gagal, template file salah!",
					"type_message" => "danger"
				);
			}
		
		$db->commit();
		}catch (PDOException $e){
			$db->rollback();
			$data = array(
				"message" => "Upload Master COA gagal," . $e,
				"type_message" => "danger"
			);
		}
	}else{
		$data = array(
			"message" => "Upload Master COA gagal, format file salah!",
			"type_message" => "danger"
		);
	}

	// tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>