<?php
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
		$c_rs_opt  = 0;
		$morePages = 0;
		// END definisi variable untuk fn_ajax_results.php
		
		$nama_tabel = $_POST['nama_tabel'];
		
		if (isset($_POST['id_transaksi']) && $_POST['id_transaksi'] > 0) { 
			$id_transaksi = $_POST['id_transaksi'];

			$qs_unit = $db
				->query('select', $nama_tabel )
				->get(['jumlah_unit'] )
				->where('id', $id_transaksi )
				->exec();
			$rs_unit = $qs_unit->fetch();

			$jumlah_unit_old = $rs_unit['jumlah_unit'];
		} else {
			$jumlah_unit_old = 0;
		}
		
		// echo $id_transaksi;
		// echo $nama_tabel;
		// $jumlah_unit_old = $_POST['jumlah_unit_old'];
		$nama_tabel_before = $_POST['nama_tabel_before'];
		$jumlah_unit_input = $_POST['jumlah_unit'];
		

        $sql_select = $db
        ->raw()
		->bind(':id_detail_item_before', $_POST['id_detail_item_before'])
		->exec('SELECT
					a.jumlah_unit AS jumlah_unit,
					a.jumlah_unit_os AS jumlah_unit_os,
					a.jumlah_unit_next AS jumlah_unit_next
				FROM '.$nama_tabel_before.' AS a
				WHERE a.id = :id_detail_item_before
				'
			);
	    $results_select = $sql_select->fetch();

		$jumlah_unit_next = $results_select['jumlah_unit_next'];
		$jumlah_unit_db = $results_select['jumlah_unit'];
		$old_qty = $jumlah_unit_next - $jumlah_unit_old;

		$unit_now = $jumlah_unit_input + $old_qty;
		$sisa = $jumlah_unit_db - $old_qty;

        // echo json_encode($results_select);
			$data = array(
				"jumlah_unit_next" => $jumlah_unit_next,
				"jumlah_unit_db" => $jumlah_unit_db,
				"jumlah_unit_input" => $jumlah_unit_input,
				"jumlah_unit_old" => $jumlah_unit_old,
				"old_qty" => $old_qty,
				"unit_now" => $unit_now,
				"sisa" => $sisa,
			);

		
		// tampilkan results
		require_once( "fn_ajax_results2.php" );
?>