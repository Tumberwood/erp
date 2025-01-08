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

	try{
		
		$qs_cek_d = $db
			->raw()
			->bind(':id', $id)
			->exec('SELECT
						SUM(a.bobot_persen) s_bobot
					FROM hfkobtd a
					WHERE a.id_hfkxxth = :id AND a.transaction_state <> -9
			'
			);

		$rs_cek_d = $qs_cek_d->fetch();

		$s_bobot = $rs_cek_d['s_bobot'];
		
		if($s_bobot == 100){
			$status_code  = 200;
			$message = "";
			$type_message = "success";
			// parameter lain
		}else{
			$status_code  = 500;
			$message = 'Total Bobot Persen harus 100%, bobot persen sekarang adalah '.$s_bobot.'%';
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