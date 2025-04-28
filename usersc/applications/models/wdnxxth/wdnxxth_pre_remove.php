<?php
	
	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
	include( "../../../../usersc/helpers/datatables_fn_debug.php" );
    require '../../../../usersc/vendor/autoload.php';

    use Carbon\Carbon;
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	// BEGIN definisi variable untuk fn_ajax_results.php
	$data      = array();
	$rs_opt    = array();
	$c_rs_opt  = 0;
	$morePages = 0;
	// END definisi variable untuk fn_ajax_results.php
	
	$id = $_POST['id_transaksi'];

	// (ROW_NUMBER() OVER (ORDER BY a.id) * (ROW_NUMBER() OVER (ORDER BY a.id) - 1)) / 2 AS result

	try{
		
		$qs_dispatch = $db
			->raw()
			->bind(':id', $id)
			->exec('SELECT
						a.id_wdplptd,
						a.jumlah_terkecil
					FROM wdnlptd a
					WHERE a.id_wdnxxth = :id'
			);

		$rs_dispatch = $qs_dispatch->fetchAll();

		foreach ($rs_dispatch as $dispatch) {
			$id_wdplptd = $dispatch['id_wdplptd'];
			$jumlah_terkecil = $dispatch['jumlah_terkecil'];

			$db->raw()
				->bind(':id_wdplptd', $id_wdplptd)
				->bind(':jumlah_terkecil', $jumlah_terkecil)
				->exec('UPDATE wdplptd
						SET
							jumlah_terkecil_os = jumlah_terkecil_os + :jumlah_terkecil,
							jumlah_terkecil_next = jumlah_terkecil_next - :jumlah_terkecil
						WHERE id = :id_wdplptd'
				);
		}

		$db->query('delete', 'iivxxrd')
			->where('keterangan', 'id_wdnxxth='.$id)
			->exec();

		$status_code  = 200;
		$message = "";
		$type_message = "success";
	}catch(PDOException $e){
		$status_code  = 500;
		$message      = 'Message Gagal! ' . $e->getMessage();
		$type_message = 'error';
	}
	
	// build response
	$data = array(
		'status_code'    => $status_code,
		'message'        => $message,
		'type_message'   => $type_message
	);	

	// tampilkan results
    include( "../../../../usersc/helpers/fn_ajax_results.php" );

?>