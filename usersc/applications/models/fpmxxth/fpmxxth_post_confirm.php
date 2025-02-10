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
	$state = $_POST['state'];

	$qs_pp = $db
		->raw()
		->bind(':id', $id)
		->exec('SELECT
					a.amount,
					a.rencana_bayar rencana_bayar_pp,
					b.rencana_bayar rencana_bayar_dph,
					c.terbayar,
					c.selisih_bayar,
					if(c.grand_total = a.rencana_bayar, a.rencana_bayar, (c.terbayar - b.rencana_bayar) + a.rencana_bayar) AS terbayar_now,
					if(c.grand_total = a.rencana_bayar, 0, (c.selisih_bayar + b.rencana_bayar) - a.rencana_bayar) AS selisih_bayar_now,
					a.id_pivxxth,
					a.id id_fpmivtd,
					a.id_fprivtd,
					if(c.grand_total = a.rencana_bayar, 1, 0) is_langsung_lunas
				FROM fpmivtd a
				LEFT JOIN fprivtd b ON b.id = a.id_fprivtd
				LEFT JOIN pivxxth c ON c.id = a.id_pivxxth
				WHERE a.id_fpmxxth = :id
	');
	
	$rs_pp = $qs_pp->fetchAll();

	try{
			
		if($state == 1){
			foreach ($rs_pp as $key => $pp) {
				$terbayar_now = $pp['terbayar_now'];
				$selisih_bayar_now = $pp['selisih_bayar_now'];
				$id_pivxxth = $pp['id_pivxxth'];
				$is_langsung_lunas = $pp['is_langsung_lunas'];
				$id_fpmivtd = $pp['id_fpmivtd'];
				$id_fprivtd = $pp['id_fprivtd'];

				$qu_pivxxth = $db
					->query('update', 'pivxxth')
					->set('terbayar',$terbayar_now)
					->set('selisih_bayar',$selisih_bayar_now)
					->where('id',$id_pivxxth)
					->exec();

				if ($is_langsung_lunas == 1) {
					//Jika langsung lunas, maka delete PP lain yang punya PIV lain. Agar jumlahnya valid
					$qd_fpmivtd = $db
					->query('delete', 'fpmivtd')
					->where('id_pivxxth',$id_pivxxth)
					->where('id',$id_fpmivtd, '<>')
					->exec();
					
					//Jika langsung lunas, maka delete DPH lain yang punya PIV lain. Agar jumlahnya valid
					$qd_fprivtd = $db
						->query('delete', 'fprivtd')
						->where('id_pivxxth',$id_pivxxth)
						->where('id',$id_fprivtd, '<>')
						->exec();
				}
			}
		} // end if($state == 1)

		if(!empty($qu_pivxxth)){
			$status_code  = 200;
			$message = "Purchase Payment Berhasil Diupdate";
			$type_message = "success";
			// parameter lain
		}else{
			$status_code  = 500;
			$message = "Purchase Payment Gagal Diupdate";
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