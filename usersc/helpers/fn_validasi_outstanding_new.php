<?php
	/**
	 * Digunakan untuk mendapatkan data jumlah outstanding
	 * Data yang ditampilkan dalam UoM default
	 * 
	 * Dipanggil dari 
	 * 	validation.js validasiOutstanding()
	 * 
	 * Terminology
	 * 	old		: data transaksi sebelum di edit. 
	 * 	before	: data relasi transaksi yang akan dicek outstandingnya. 
	 * 
	 * Contoh
	 * 	Transaksi Goods Receipt dan Purchase Order
	 * 	berarti saat detail item Goods Receipt dibuat, validasi ini dipasang
	 * 	old
	 * 		saat action create detail item Goods Receipt, maka old nya akan 0, karena belum ada data detail item Goods Receipt nya
	 * 		saat action edit detail item Goods Receipt, maka old nya akan di cek dulu dari baris data tersebut yang sudah ter-submit di database
	 * before
	 * 		dalam contoh ini, before merujuk ke data Purchase Order, sesuai baris data detail item Goods Receipt terkait
	 * 		di table detail item Goods Receipt terkait, harus ada relasi ke detail item Purchase Order
	 * 	
	 * Parameter:
	 * 	id_transaksi
	 * 	id_transaksi_before
	 * 	tbl_name
	 * 	tbl_name_before
	 * 	jumlah_unit
	 * 
	 * Return:
	 * 	sisa	: jumlah_unit yang masih bisa diinput
	 * 	jumlah_unit_after: jumlah_unit total yang sudah diinput
	 * 	
	 */
	include( "../../users/init.php" );
	include( "../../usersc/lib/DataTables.php" );
	require_once( "../../usersc/helpers/datatables_fn_debug.php" );
	
	use
		DataTables\Editor,
		DataTables\Editor\Field,
		DataTables\Editor\Format,
		DataTables\Editor\Mjoin,
		DataTables\Editor\Options,
		DataTables\Editor\Upload,
		DataTables\Editor\Validate,
		DataTables\Editor\ValidateOptions,
		DataTables\Editor\Query,
		DataTables\Editor\Result;
	
		// BEGIN definisi variable untuk fn_ajax_results.php
		$data      = array();
		$rs_opt    = array();
		// END definisi variable untuk fn_ajax_results.php
		
		$tbl_name              = $_POST['tbl_name'];
		$id_transaksi              = $_POST['id_transaksi'];
		$tbl_name_before       = $_POST['tbl_name_before'];
		$id_transaksi_before       = $_POST['id_transaksi_before'];
		$id_iimxxmh_input      = $_POST['id_iimxxmh'];
		$id_iumxxmh_unit_input = $_POST['id_iumxxmh_unit'];

		//jika create
		if ($id_transaksi == 0) {
			$selectQuery = '
				if('.$id_iumxxmh_unit_input.' = terkecil.id_iumxxmh, 
					tbl_before.jumlah_terkecil_os, 
					(tbl_before.jumlah_terkecil_os) / uom_input.jumlah_konversi
				) AS jumlah_terkecil_os_validasi';

			$joinTblNow = '';
		} else {
			//Jika edit, maka akan dilakukan join ke tbl now untuk mendapatkan jumlah_terkecil dari tbl now
			$selectQuery = '
				if('.$id_iumxxmh_unit_input.' = terkecil.id_iumxxmh, 
					tbl_before.jumlah_terkecil_os + tbl_now.jumlah_terkecil, 
					(tbl_before.jumlah_terkecil_os + tbl_now.jumlah_terkecil) / uom_input.jumlah_konversi
				) AS jumlah_terkecil_os_validasi';

			$joinTblNow = 'LEFT JOIN '.$tbl_name.' tbl_now ON tbl_now.id_'.$tbl_name_before.' = tbl_before.id AND tbl_now.id = '.$id_transaksi;
		}

        $qs_os_tbl_before = $db
			->raw()
			->bind(':id_transaksi_before', $id_transaksi_before)
			->bind(':id_iumxxmh_unit_input', $id_iumxxmh_unit_input)
			->exec('SELECT
						tbl_before.id_iimxxmh,
					--	tbl_before.jumlah_unit,
					--	tbl_before.jumlah_terkecil,
						uom_input.jumlah_konversi,
						b.kode AS iumxxmh_kode_input,
						'.$selectQuery.'
					FROM '.$tbl_name_before.' tbl_before
					LEFT JOIN iimummd uom_input ON uom_input.id_iimxxmh = tbl_before.id_iimxxmh AND uom_input.id_iumxxmh = :id_iumxxmh_unit_input
					LEFT JOIN iimummd terkecil ON terkecil.id_iimxxmh = tbl_before.id_iimxxmh AND terkecil.is_terkecil = 1
					LEFT JOIN iumxxmh b ON b.id = uom_input.id_iumxxmh
					'.$joinTblNow.'
					WHERE tbl_before.id = :id_transaksi_before'
			);
	    $rs_os_tbl_before = $qs_os_tbl_before->fetch();

		$jumlah_konversi      = $rs_os_tbl_before['jumlah_konversi'];
		$iumxxmh_kode_input      = $rs_os_tbl_before['iumxxmh_kode_input'];
		$jumlah_terkecil_os_validasi      = $rs_os_tbl_before['jumlah_terkecil_os_validasi'];
		
		$data = array(
			  // untuk ditampikan
			"iumxxmh_kode_input"       => $iumxxmh_kode_input,
			"jumlah_terkecil_os_validasi"       => $jumlah_terkecil_os_validasi,

		);

		
		// tampilkan results
		require_once( "fn_ajax_results.php" );
?>