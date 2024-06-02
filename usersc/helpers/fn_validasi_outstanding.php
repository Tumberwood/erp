<?php
	/**
	 * Digunakan untuk mendapatkan data jumlaj_unit_os
	 * 
	 * Dipanggil dari 
	 * 	validation.js validasiOutstanding()
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
	 * 	unit_now: jumlah_unit total yang sudah diinput
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
		
		$tbl_name          = $_POST['tbl_name'];
		$tbl_name_before   = $_POST['tbl_name_before'];
		$jumlah_unit_input = $_POST['jumlah_unit'];
		
		if (isset($_POST['id_transaksi']) && $_POST['id_transaksi'] > 0) { 
			$id_transaksi = $_POST['id_transaksi'];

			$qs_transaksi = $db
				->query('select', $tbl_name )
				->get(['jumlah_unit'] )
				->where('id', $id_transaksi )
				->exec();
			$rs_transaksi = $qs_transaksi->fetch();

			$jumlah_unit_transaksi_old = $rs_transaksi['jumlah_unit'];
		} else {
			$jumlah_unit_transaksi_old = 0;
		}
		
        $qs_transaksi_before = $db
			->raw()
			->bind(':id_transaksi_before', $_POST['id_transaksi_before'])
			->exec('
				SELECT
					a.jumlah_unit AS jumlah_unit,
					a.jumlah_unit_os AS jumlah_unit_os,
					a.jumlah_unit_next AS jumlah_unit_next
				FROM '.$tbl_name_before.' AS a
				WHERE 
					a.id = :id_transaksi_before
			');
	    $rs_transaksi_before = $qs_transaksi_before->fetch();

		$jumlah_unit_next_before = $rs_transaksi_before['jumlah_unit_next'];
		$jumlah_unit_before      = $rs_transaksi_before['jumlah_unit'];
		
		$unit_now = $jumlah_unit_input + $jumlah_unit_next_before - $jumlah_unit_transaksi_old;
		$sisa     = $jumlah_unit_before - $jumlah_unit_next_before - $jumlah_unit_transaksi_old;

		$data = array(
			"jumlah_unit_next"  => $jumlah_unit_next_before,
			"jumlah_unit"       => $jumlah_unit_before,
			"jumlah_unit_input" => $jumlah_unit_input,
			"jumlah_unit_transaksi_old"   => $jumlah_unit_transaksi_old,
			"unit_now"          => $unit_now,
			"sisa"              => $sisa,
		);

		
		// tampilkan results
		require_once( "fn_ajax_results.php" );
?>