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

	// (ROW_NUMBER() OVER (ORDER BY a.id) * (ROW_NUMBER() OVER (ORDER BY a.id) - 1)) / 2 AS result

	
	$qs_id_iitxxmh = $db
		->query('select', 'pivxxth' )
		->get([
			'pivxxth.id_iitxxmh as id_iitxxmh'
		] )
		->where('pivxxth.id', $id )
		->exec();
	$rs_id_iitxxmh = $qs_id_iitxxmh->fetch();

	//Update tanggal_jatuh_tempo
	$qu_tanggal_jatuh_tempo = $db
		->raw()
		->bind(':id', $id)
		->exec('UPDATE pivxxth a
				LEFT JOIN fpytmmh b ON b.id = a.id_fpytmmh
				LEFT JOIN ggsfnsh c ON c.id = 1
				SET 
					a.selisih_bayar = a.grand_total,
					a.tanggal_jatuh_tempo = DATE_ADD(a.tanggal, INTERVAL b.jatuh_tempo DAY)
				WHERE a.id = :id
	');

	//jika bukan jasa
	if($rs_id_iitxxmh['id_iitxxmh'] == 1){
		try{
			
			if($state == 1){
	
				//get iivxxrd untuk mendapatkan hpp terakhir
				$qs_iivxxrd = $db
					->raw()
					->bind(':id', $id)
					->exec('SELECT
								c.id,
								c.id_iumxxmh_unit,
								c.jumlah_unit,
								c.id_iumxxmh_terkecil,
								c.jumlah_terkecil,
								c.harga_unit,
								c.hpp,
								s_biaya,
								s_jumlah_terkecil,
								ROUND(s_biaya / s_jumlah_terkecil) biaya_per_satuan,
								c.hpp + ROUND(s_biaya / s_jumlah_terkecil) hpp_after
							FROM pivxxth a
							LEFT JOIN prcxxth b ON b.id = a.id_prcxxth
							LEFT JOIN iivxxrd c ON c.kode = b.kode
							LEFT JOIN (
								SELECT 
									t.id_pivxxth,
									SUM(t.nominal) s_biaya
								FROM pivaktd t
								WHERE t.id_pivxxth = :id
							) d ON d.id_pivxxth = a.id
							LEFT JOIN (
								SELECT
									id_pivxxth,
									SUM(pivittd.jumlah_terkecil) s_jumlah_terkecil
								FROM pivittd
								WHERE id_pivxxth = :id
							) e ON e.id_pivxxth = a.id
							WHERE a.id = :id;
							;
					');
				$rs_iivxxrd = $qs_iivxxrd->fetchAll();
	
				foreach ($rs_iivxxrd as $key => $iivxxrd) {
					if ($iivxxrd['id'] > 0) {
						$id_iivxxrd = $iivxxrd['id'];
						$hpp_after = $iivxxrd['hpp_after'];
	
						$qu_iivxxrd = $db
							->query('update', 'iivxxrd')
							->set('hpp',$hpp_after)
							->where('id',$id_iivxxrd)
							->exec();
					}
				}
			} // end if($state == 1)
	
			if(!empty($rs_iivxxrd)){
				$status_code  = 200;
				$message = "HPP Inventory Berhasil Diupdate";
				$type_message = "success";
				// parameter lain
			}else{
				$status_code  = 500;
				$message = "HPP Inventory Gagal Diupdate";
				$type_message = 'error';
				// parameter lain
			}
		}catch(PDOException $e){
			$status_code  = 500;
			$message      = 'Message Gagal! ' . $e->getMessage();
			$type_message = 'error';
		}
		
	} else {
		// selain persediaan, tidak perlu inventory. Message di blank kan
		$status_code  = '200';
		$message      = '';
		$type_message = 'success';
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