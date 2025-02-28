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
					a.id_sivxxth,
					a.id id_spmivtd,
					a.id_sprivtd,
					if(c.grand_total = a.rencana_bayar, 1, 0) is_langsung_lunas
				FROM spmivtd a
				LEFT JOIN sprivtd b ON b.id = a.id_sprivtd
				LEFT JOIN sivxxth c ON c.id = a.id_sivxxth
				WHERE a.id_spmxxth = :id
	');
	
	$rs_pp = $qs_pp->fetchAll();

	try{
			
		if($state == 1){
			foreach ($rs_pp as $key => $pp) {
				$terbayar_now = $pp['terbayar_now'];
				$selisih_bayar_now = $pp['selisih_bayar_now'];
				$id_sivxxth = $pp['id_sivxxth'];
				$is_langsung_lunas = $pp['is_langsung_lunas'];
				$id_spmivtd = $pp['id_spmivtd'];
				$id_sprivtd = $pp['id_sprivtd'];

				$qu_sivxxth = $db
					->query('update', 'sivxxth')
					->set('terbayar',$terbayar_now)
					->set('selisih_bayar',$selisih_bayar_now)
					->where('id',$id_sivxxth)
					->exec();

				if ($is_langsung_lunas == 1) {
					//Jika langsung lunas, maka delete PP lain yang punya siv lain. Agar jumlahnya valid
					$qd_spmivtd = $db
					->query('delete', 'spmivtd')
					->where('id_sivxxth',$id_sivxxth)
					->where('id',$id_spmivtd, '<>')
					->exec();
					
					//Jika langsung lunas, maka delete DPH lain yang punya siv lain. Agar jumlahnya valid
					$qd_sprivtd = $db
						->query('delete', 'sprivtd')
						->where('id_sivxxth',$id_sivxxth)
						->where('id',$id_sprivtd, '<>')
						->exec();
				}
			}
		} // end if($state == 1)

		if(!empty($qu_sivxxth)){
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