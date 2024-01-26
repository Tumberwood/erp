
<?php    
	
	// BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

	function integerToRoman($integer){
		// Convert the integer into an integer (just to make sure)
		$integer = intval($integer);
		$result = '';
	 
		// Create a lookup array that contains all of the Roman numerals.
		$lookup = array(
			'M' => 1000,
			'CM' => 900,
			'D' => 500,
			'CD' => 400,
			'C' => 100,
			'XC' => 90,
			'L' => 50,
			'XL' => 40,
			'X' => 10,
			'IX' => 9,
			'V' => 5,
			'IV' => 4,
			'I' => 1);
	 
		foreach($lookup as $roman => $value){
			// Determine the number of matches
			$matches = intval($integer/$value);
	 
			// Add the same number of characters to the string
			$result .= str_repeat($roman,$matches);
	 
			// Set the integer to be the remainder of the integer and the value
			$integer = $integer % $value;
		}
	 
		// The Roman numeral should be built, return it
		return $result;
	}


	// BEGIN ambil data dari variable confirm
	$state 			= 0;
	$nama_tabel 	= '';
	$id_transaksi 	= 0;
	$message 		= '';
	$type_message 	= '';
	$formatted_kode = '';

	if (isset($_POST['state']) && !empty($_POST['state'])) {
		$state 			= $_POST['state'];
	}
	if (isset($_POST['nama_tabel']) && !empty($_POST['nama_tabel'])) {
		$nama_tabel 	= $_POST['nama_tabel'];
	}
	if (isset($_POST['id_transaksi']) && !empty($_POST['id_transaksi'])) {
		$id_transaksi 	= $_POST['id_transaksi'];
	}
	// END ambil data dari variable confirm
	
	if($state == 1){
		require_once( "../../users/init.php" );
		require_once( "../../usersc/lib/DataTables.php" );
		require_once( "datatables_fn_debug.php" );
		
		// BEGIN ambil data tambahan dari variable confirm
		$kategori_dokumen 		= $_POST['kategori_dokumen'];
		$kategori_dokumen_value = $_POST['kategori_dokumen_value'];
		// END ambil data tambahan dari variable confirm

		// BEGIN cek parameter kategori_dokumen
		// jika blank		: tidak ada where kategori_dokumen
		// jika tidak blank	: tambahkan where kategori_dokumen dan kategori_dokumen_value
		if ($_POST['kategori_dokumen'] == ''){
			$_and_where_kategori_dokumen = '';
		}else{
			$_and_where_kategori_dokumen = " AND kategori_dokumen = '" . $_POST['kategori_dokumen'] . "' AND kategori_dokumen_value = " . $_POST['kategori_dokumen_value'];
		}
		// END cek parameter kategori_dokumen

		// BEGIN ambil data dari table gdnxxsh
		$qs_gdnxxsh = $db
			->raw()
			->exec('
				SELECT
					*
				FROM 
					gdnxxsh
				WHERE 
					nama_tabel = "' . $nama_tabel . '"'  . $_and_where_kategori_dokumen
			);
		$rs_gdnxxsh = $qs_gdnxxsh->fetch();

		$mode 					= $rs_gdnxxsh['mode'];
		$prefix                 = $rs_gdnxxsh['prefix'];
		$suffix                 = $rs_gdnxxsh['suffix'];
		$total_digit            = $rs_gdnxxsh['total_digit'];
		$is_romawi_bulan        = $rs_gdnxxsh['is_romawi_bulan'];
		$reset_by               = $rs_gdnxxsh['reset_by'];
		$digit_tahun            = $rs_gdnxxsh['digit_tahun'];
		$separator              = $rs_gdnxxsh['separator'];
		$nama_field_tanggal     = $rs_gdnxxsh['field_tanggal'];
		$by_cabang 				= $rs_gdnxxsh['by_cabang'];
		// END ambil data dari table gdnxxsh

		// BEGIN ambil data dari table transaksi
		$qs_transaksi = $db
			->raw()
			->bind(':id_transaksi', $id_transaksi)
			->exec('
				SELECT
					*
				FROM 
					'.$nama_tabel.'
				WHERE 
					id = :id_transaksi
			');
		$rs_transaksi = $qs_transaksi->fetch();
		// END ambil data dari table transaksi

		// BEGIN check field tanggal yang digunakan
		// Jika created_on, maka harus query dulu dari table activity_log_ml untuk kode = CONFIRM
		if ( is_null($nama_field_tanggal) || $nama_field_tanggal == '' ){
			$nama_field_tanggal = 'activity_log_ml.created_on';
			$field_tanggal 		= date('Y-m-d');

		}else{
			$nama_field_tanggal 	 = $nama_tabel.".".$nama_field_tanggal;
			$field_tanggal_transaksi = $rs_transaksi[$nama_field_tanggal];
			$field_tanggal 			 = date_create($field_tanggal_transaksi);
			$field_tanggal 			 = date_format($field_tanggal,"Y-m-d");
		}
		$field_tanggal_dt	= strtotime($field_tanggal);
		// END check field tanggal yang digunakan

		// BEGIN check format tahun 2 digit atau 4 digit
		// menggunakan format string, bukan date
		if($digit_tahun == 2){
			$tahun = substr($field_tanggal,2,2);
		}else if ($digit_tahun == 4){
			$tahun = substr($field_tanggal,0,4);
		}
		// END check format tahun 2 digit atau 4 digit

		/* *** FITUR BULAN ROMAWI DITIADAKAN DULU *** */
		// check apakah menggunakan bulan dalam angka romawi
		// if ($is_romawi_bulan == 1){
			// $bulan = integerToRoman(date_format ($field_tanggal, 'm'));
		// } else{
			// $bulan = date_format ($field_tanggal, 'm');
		// }
		$bulan = substr($field_tanggal,5,2);

		// BEGIN generate WHERE
		
		$tanggal = $field_tanggal;
	
		$where = " WHERE activity_log_ml.kode = 'CONFIRM' AND activity_log_ml.nama = '" . $nama_tabel . "' ";

		// BEGIN check nomor dokumen direset per Tahun, Bulan atau tanpa reset
		if ($reset_by == "Tahun"){
			$where = $where . " AND YEAR(".$nama_field_tanggal.") = YEAR('" . $tanggal . "') ";
		}else if ($reset_by == "Bulan"){
			$where = $where . " AND YEAR(".$nama_field_tanggal.") = YEAR('" . $tanggal . "') AND MONTH(".$nama_field_tanggal.") = MONTH('" . $tanggal . "') ";
		}
		// END check nomor dokumen direset per Tahun, Bulan atau tanpa reset

		// BEGIN check last kode berdasarkan kategori_dokumen
		if ($kategori_dokumen !== ""){
			$where = $where . " AND " . $kategori_dokumen ." = " . $kategori_dokumen_value;
		}
		// END check last kode berdasarkan kategori_dokumen

		// BEGIN ambil id
		// c_id_new tidak perlu di + 1, karena melihat dari transaction_state = 1 (confirm)
		// generate kode ini dipanggil setelah transaction_state = 1
		$qs_c_id_new = $db
			->raw()
			->exec('
				SELECT
					count(activity_log_ml.id) as c_id_new
				FROM '.$nama_tabel.'
				LEFT JOIN activity_log_ml ON
					activity_log_ml.id_transaksi = '.$nama_tabel.'.id 
					AND  activity_log_ml.kode = "CONFIRM" 
					AND activity_log_ml.nama = "'.$nama_tabel.'" 
				' 
				. $where 

			);
		$rs_c_id_new 	= $qs_c_id_new->fetch();
		$new_number  	= $rs_c_id_new['c_id_new'];
		$tr_kode 		= str_pad($new_number,$total_digit,"0",STR_PAD_LEFT);

		/* generate document number by mode */
		if ($mode == 1){
			// mode 1	: 
			// 	contoh reset bulan: PO/2201/0123	
			// 	contoh reset tahun: PO/22/0123
			
			// parameter:
			// - $reset_by
			// - $prefix
			// - $separator
			// - $tahun
			if ($reset_by == "Tahun"){
				// prefix/tahun + nomorurut
				$formatted_kode = $prefix . $separator . $tahun . $tr_kode;
			}else if ($reset_by == "Bulan"){
				// prefix/tahunbulan/nomorurut
				$formatted_kode = $prefix . $separator . $tahun . $bulan . $separator . $tr_kode;
			}
		}else if ($mode == 2){
			// mode 2: 
			//	contoh: P00001

			// parameter:
			// - $prefix
			$formatted_kode = $prefix . $tr_kode;
		}else if ($mode == 3){
			// mode 3: 
			// 	contoh: 391/SPL/PNW/VIII/2019

			// parameter:
			// - $reset_by
			// - $prefix
			// - $suffix
			// - $bulan
			// - $separator
			// - $tahun
			$formatted_kode = $tr_kode . $separator . $prefix . $separator . $suffix . $separator . $bulan . $separator. $tahun ;
		}else if ($mode == 4){
			/*
				mode 4: 
				Kode Cabang/Prefix/Tahun/Bulan/nomorurut
			*/
			$formatted_kode = $_SESSION['kodemhcabang'] . $separator . $prefix . $separator . $tahun . $separator . $bulan . $separator . $tr_kode;
		}

		// BEGIN update field kode
		$result = $db
			->query('update', $nama_tabel)
			->set('kode',$formatted_kode)
			->where('id',$id_transaksi)
			->exec();
		// END update field kode

		if ($result){
			$message      = 'Generate Kode Berhasil';
			$type_message = 'success';
		}else{
			$message      = 'Generate Kode Gagal!';
			$type_message = 'danger';
		} 
		
	}
	
	$data = array(
		'message'      	=> $message,
		'type_message' 	=> $type_message,
		'tr_kode' => $tr_kode,
		'new_number' => $new_number,
		'nama_field_tanggal' => $nama_field_tanggal
	);

	// tampilkan results
    require_once( "fn_ajax_results.php" );

?>