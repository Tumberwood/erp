<?php
	/**
	 * 230602 - 2.1.1
	 * Improve debug
	 * 
	 * 230316 - 2.0.1
	 * Improve where multiple
	 * 	$nama_field (array) : Nama field yang dicek
	 * 	$nama_field_value (array) : Value dari nama_field
	 * 
	 * 230212 - 2.0.0
	 * Digunakan untuk melakukan validasi data unik
	 * Parameter:
	 * 	$table_name: Nama tabel
	 * 	$nama_field: Nama field yang dicek
	 * 	$nama_field_value: Value dari nama_field
	 * 	$id_transaksi: id dari transaksi, dipakai jika edit. jika create maka id harus = 0
	 * 
	 * 200808
	 * Initial version
	 * 	$table_name		: nama table untuk query
	 * 	$where			: kriteria select
	 * result : 
	 * 	0 = Data sudah ada
	 * 	1 = Data baru
	 */

	include_once( "../../usersc/lib/DataTables.php" );
	include_once( "datatables_fn_debug.php" );

	// BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

	try{

		if( 
			isset($_POST['id_transaksi']) &&
			isset($_POST['tbl_name']) &&
			isset($_POST['tanggal_akhir']) &&
			isset($_POST['tanggal_awal'])
		)
		{
			$id_transaksi     		= $_POST['id_transaksi'];
			$tbl_name       		= $_POST['tbl_name'];
			$tanggal_awal       	= $_POST['tanggal_awal'];
			$tanggal_akhir      	= $_POST['tanggal_akhir'];
			$where_query      		= $_POST['where_query'];
			$is_valid_start_date 	= 0;
			$is_valid_end_date 		= 0;
			
			//cek tanggal awal input apakah cross date
			$qs_start_date = $db
				->raw()
				->bind(':id_transaksi', $id_transaksi)
				->bind(':tanggal_awal', $tanggal_awal)
				->exec('SELECT
							COUNT(a.id) c_id
						FROM '.$tbl_name.' a
						WHERE (:tanggal_awal BETWEEN a.tanggal_awal AND a.tanggal_akhir)
						AND a.id <>  :id_transaksi
						'.$where_query.'
			');
			$rs_start_date = $qs_start_date->fetch();

			if ($rs_start_date['c_id'] > 0) {
				$is_valid_start_date = 0;
			} else {
				$is_valid_start_date = 1;
			}
			
			//cek tanggal akhir input apakah cross date
			$qs_end_date = $db
				->raw()
				->bind(':id_transaksi', $id_transaksi)
				->bind(':tanggal_akhir', $tanggal_akhir)
				->exec('SELECT
							COUNT(a.id) c_id
						FROM '.$tbl_name.' a
						WHERE (:tanggal_akhir BETWEEN a.tanggal_awal AND a.tanggal_akhir)
						AND a.id <>  :id_transaksi
						'.$where_query.'
			');
			$rs_end_date = $qs_end_date->fetch();

			if ($rs_end_date['c_id'] > 0) {
				$is_valid_end_date = 0;
			} else {
				$is_valid_end_date = 1;
			}
			
			$status_code  = 200;
			$message      = 'Cek Berhasil';
			$type_message = 'success';

		}else{
			$status_code  			= 500;
			$is_valid_start_date    = -1;
			$is_valid_end_date     	= -1;
			$message      			= 'Error #101. Harap hubungi administrator!';
			$type_message 			= 'error';
		}

	}catch(PDOException $e){
		$status_code  			= 500;
		$is_valid_start_date    = -1;
		$is_valid_end_date     	= -1;
		$message      			= 'Cek Gagal. ' . $e->getMessage();
		$type_message 			= 'error';
	}

	$data = array(
		"is_valid_start_date"    => $is_valid_start_date,
		"is_valid_end_date"     => $is_valid_end_date,
		"status_code"  			=> $status_code,
		"message"      			=> $message,
		"type_message" 			=> $type_message,
		"id_transaksi" 			=> $_POST['id_transaksi']
	);

	// tampilkan results
    require_once( "fn_ajax_results.php" );

?>