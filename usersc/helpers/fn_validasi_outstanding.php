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
		$tbl_name_before       = $_POST['tbl_name_before'];
		$jumlah_unit_input     = floatval($_POST['jumlah_unit']);
		$id_iimxxmh_input      = $_POST['id_iimxxmh'];
		$id_iumxxmh_unit_input = $_POST['id_iumxxmh_unit'];

		/**
		 * ambil data uom default untuk item terpilih 
		 * output: 
		 * 	$jumlah_konversi_default_ke_terkecil	nilai pengali uom default ke uom terkecil
		 * 	$iumxxmh_default_kode					kode uom yang akan ditampilkan pada informasi validasi di form
		 * 
		 */
		// BEGIN get iimummd_default
		$qs_iimummd_default = $db
			->query('select', 'iimummd' )
			->get([
				'iimummd.jumlah_konversi as jumlah_konversi_default_ke_terkecil',
				'iumxxmh.kode as iumxxmh_default_kode'
			] )
			->join('iumxxmh','iumxxmh.id = iimummd.id_iumxxmh','LEFT' )
			->where('iimummd.id_iimxxmh', $id_iimxxmh_input )
			->where('iimummd.is_default', 1 )
			->exec();
		// END get iimummd_default
		$rs_iimummd_default                  = $qs_iimummd_default->fetch();
		$jumlah_konversi_default_ke_terkecil = $rs_iimummd_default['jumlah_konversi_default_ke_terkecil'];
		$iumxxmh_default_kode                = $rs_iimummd_default['iumxxmh_default_kode'];

		/**
		 * hitung nilai konversi dari uom inputan user (unit) ke nilai uom terkecil
		 * pengecekan outstanding selalu dilakukan dalam nilai uom terkecil
		 * output : 
		 * 	$jumlah_terkecil_input		hasil konversi dari jumlah inputan ke nilai dalam uom terkecil
		 */
		// BEGIN get iimummd_terkecil
		$qs_iimummd_terkecil = $db
			->query('select', 'iimummd' )
			->get([
				'iimummd.jumlah_konversi as jumlah_konversi_terkecil'
			] )
			->where('iimummd.id_iimxxmh', $id_iimxxmh_input )
			->where('iimummd.id_iumxxmh', $id_iumxxmh_unit_input )
			->exec();
		$rs_iimummd_terkecil      = $qs_iimummd_terkecil->fetch();
		$jumlah_konversi_terkecil = $rs_iimummd_terkecil['jumlah_konversi_terkecil'];
		$jumlah_terkecil_input    = $jumlah_unit_input * $jumlah_konversi_terkecil ;
		// END get iimummd_terkecil

		if (isset($_POST['id_transaksi']) && $_POST['id_transaksi'] > 0) { 
			
			$id_transaksi = $_POST['id_transaksi'];
			/**
			 * ambil data nilai transaksi sebelum di submit
			 * ini bisa dilakukan di function ini, karena function ini dipanggil saat event edt preSubmit
			 * term old merujuk pada data sebelum transaksi diubah
			 * output:
			 * 	$jumlah_terkecil_input_old	nilai yang sudah ada di database, belum di edit
			 */
			// BEGIN get data transaksi_old
			$qs_transaksi_old = $db
				->query('select', $tbl_name )
				->get(['jumlah_unit'] )
				->get(['jumlah_terkecil'] )
				->get(['jumlah_default'] )
				->where('id', $id_transaksi )
				->exec();
			$rs_transaksi_old = $qs_transaksi_old->fetch();
			// END get data transaksi_old

			$jumlah_unit_input_old = $rs_transaksi_old['jumlah_unit'];
			$jumlah_terkecil_input_old = $rs_transaksi_old['jumlah_terkecil'];
		} else {
			$jumlah_unit_input_old = 0;
			$jumlah_terkecil_input_old = 0;
		}
		
		/**
		 * ambil nilai data before.
		 * term before merujuk pada transaksi terkait. lihat terminology di bagian penjelasan functoin diatas
		 */
        $qs_transaksi_before = $db
			->raw()
			->bind(':id_transaksi_before', $_POST['id_transaksi_before'])
			->exec('SELECT
					jumlah_unit AS jumlah_unit,
					jumlah_unit_os AS jumlah_unit_os,
					jumlah_unit_next AS jumlah_unit_next,
					jumlah_terkecil AS jumlah_terkecil,
					jumlah_terkecil_os AS jumlah_terkecil_os,
					jumlah_terkecil_next AS jumlah_terkecil_next
				FROM '.$tbl_name_before.' 
				WHERE 
					id = :id_transaksi_before'
			);
	    $rs_transaksi_before = $qs_transaksi_before->fetch();

		$jumlah_unit_next_before = $rs_transaksi_before['jumlah_unit_next'];
		$jumlah_unit_before      = $rs_transaksi_before['jumlah_unit'];
		$jumlah_unit_after       = $jumlah_unit_input + $jumlah_unit_next_before - $jumlah_unit_input_old;
		$jumlah_unit_sisa        = $jumlah_unit_before - $jumlah_unit_next_before + $jumlah_unit_input_old;

		$jumlah_terkecil_next_before = $rs_transaksi_before['jumlah_terkecil_next'];
		$jumlah_terkecil_before      = $rs_transaksi_before['jumlah_terkecil'];
		$jumlah_terkecil_after       = $jumlah_terkecil_input + $jumlah_terkecil_next_before - $jumlah_terkecil_input_old;
		$jumlah_terkecil_sisa        = $jumlah_terkecil_before - $jumlah_terkecil_next_before + $jumlah_terkecil_input_old;

		$jumlah_default_sisa  = $jumlah_terkecil_sisa / $jumlah_konversi_default_ke_terkecil;

		$data = array(
			  // untuk info debug jangan dihapus dulu yang di komen
			  // "jumlah_unit_next"      => $jumlah_unit_next_before,
			  // "jumlah_unit"           => $jumlah_unit_before,
			  // "jumlah_unit_input"     => $jumlah_unit_input,
			  // "jumlah_unit_input_old" => $jumlah_unit_input_old,
			  // "jumlah_unit_after"     => $jumlah_unit_after,
			  // "jumlah_unit_sisa"		=> $jumlah_unit_sisa,
			  // "jumlah_terkecil_next"      => $jumlah_terkecil_next_before,
			  // "jumlah_terkecil_input"     => $jumlah_terkecil_input,
			  // "jumlah_terkecil_input_old" => $jumlah_terkecil_input_old,
			  // "jumlah_terkecil_sisa"		=> $jumlah_terkecil_sisa,
			  // "jumlah_konversi_default_ke_terkecil"		=> $jumlah_konversi_default_ke_terkecil,
			  // "id_iimxxmh_input" => $id_iimxxmh_input,
			  // "id_iumxxmh_unit_input" => $id_iumxxmh_unit_input,
			
			  // untuk ditampikan
			"jumlah_terkecil"       => $jumlah_terkecil_before,
			"jumlah_terkecil_after" => $jumlah_terkecil_after,
			"jumlah_default_sisa"   => $jumlah_default_sisa,
			"iumxxmh_default_kode"  => $iumxxmh_default_kode

		);

		
		// tampilkan results
		require_once( "fn_ajax_results.php" );
?>