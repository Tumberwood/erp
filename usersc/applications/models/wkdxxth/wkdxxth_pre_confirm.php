<?php
	
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../../usersc/helpers/hakakses_s_fn.php" );
	include_once( "../../../helpers/SolusiIndonesiaUtilities.php" );

    use Carbon\Carbon;
	use
        SolusiIndonesia\Utilities\General;	
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

	$pesan = "";
	// (ROW_NUMBER() OVER (ORDER BY a.id) * (ROW_NUMBER() OVER (ORDER BY a.id) - 1)) / 2 AS result

	try{
		
		$qs_cek_d = $db
			->raw()
			->bind(':id', $id)
			->exec('SELECT
						CONCAT(c.kode, " - ", c.nama) item,
						c.kode,
						c.nama,
						SUM(a.jumlah_terkecil),
						b.jumlah_terkecil,
						MOD(SUM(a.jumlah_terkecil), b.jumlah_terkecil) mod_det
					FROM wkdlptd a
					LEFT JOIN wkdxxth b ON b.id = a.id_wkdxxth
					LEFT JOIN iimxxmh c ON c.id = a.id_iimxxmh
					WHERE b.id = :id
					GROUP BY a.id_iimxxmh
			'
			);

		$rs_cek_d = $qs_cek_d->fetchAll();

		foreach ($rs_cek_d as $key => $det) {
			if ($det['mod_det'] > 0) {
				$pesan .= 'Jumlah tidak valid pada Item '.$det['item']. PHP_EOL;
			}
		}
		
		if($pesan == ''){
			$status_code  = 200;
			$message = "";
			$type_message = "success";
			// parameter lain
		}else{
			$status_code  = 500;
			$message = $pesan;
			$type_message = 'error';
			// parameter lain
		}
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