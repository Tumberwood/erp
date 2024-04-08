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
			isset($_POST['table_name']) &&
			isset($_POST['nama_field']) &&
			isset($_POST['nama_field_value'])
		)
		{
			$id_transaksi     = $_POST['id_transaksi'];
			$table_name       = $_POST['table_name'];
			$nama_field       = explode (",", $_POST['nama_field']);
			$nama_field_value = explode (",", $_POST['nama_field_value']);
			$c_where = count($nama_field_value);

			$where = ' WHERE id <> ' . $id_transaksi;
			for ($x = 0; $x < $c_where; $x++) {
				$where = $where . ' AND ' . $nama_field[$x] . '=' . $nama_field_value[$x];
			}

			// build query
			$query = 'SELECT id ' . ' FROM ' . $table_name . $where;
			$qs = $db->sql( $query );
			
			$status_code  = 200;
			$c_result     = $qs->count();
			$message      = 'Cek Berhasil';
			$type_message = 'success';

		}else{
			$status_code  = 500;
			$c_result     = -1;
			$message      = 'Error #101. Harap hubungi administrator!';
			$type_message = 'error';
		}

	}catch(PDOException $e){
		$status_code  = 500;
		$c_result     = -1;
		$message      = 'Cek Gagal. ' . $e->getMessage();
		$type_message = 'error';
	}

	$data = array(
		"count"        => $c_result,
		"status_code"  => $status_code,
		"message"      => $message,
		"type_message" => $type_message,
		"id_transaksi" => $_POST['id_transaksi']
	);

	// tampilkan results
    require_once( "fn_ajax_results.php" );

?>