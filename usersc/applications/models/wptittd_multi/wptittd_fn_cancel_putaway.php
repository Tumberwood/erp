<?php	
	/**
	 * Digunakan untuk insert CANCEL Putaway ke iivxxrd
	 */
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../../usersc/helpers/hakakses_s_fn.php" );
	include_once( "../../../helpers/SolusiIndonesiaUtilities.php" );
	// include_once( "../../../helpers/hakakses_s_fn.php" );

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

	try{
		$db->transaction();

		$id_putaway_header = $_POST['id_putaway_header'];

		$qs_wptittd = $db
            ->raw()
            ->bind(':id_putaway_header', $id_putaway_header)
            ->exec('SELECT
						a.id
					FROM wptittd a
					WHERE a.id_wptxxth = :id_putaway_header AND a.transaction_state = 0
			');
	
		$rs_wptittd = $qs_wptittd->fetchAll();
		foreach ($rs_wptittd as $key => $wptittd) {
			$id_wptittd = $wptittd['id'];
			$keterangan = 'putaway_multi_id_wptittd_'.$id_wptittd;

            $qi_iivxxrd = $db
			->query('delete', 'iivxxrd')
			->where('keterangan',$keterangan)
			->exec();
			
			$qu_wptittd = $db
				->query('update', 'wptittd')
				->set('transaction_state',9)
				->where('id',$id_wptittd)
				->exec();
		}

		$qu_wptxxth = $db
			->query('update', 'wptxxth')
			->set('transaction_state',9)
			->where('id',$id_putaway_header)
			->exec();

		$finish_at = new Carbon();
		General::logChange( $db , 'wptxxth', $s_id_users, $s_username, 'CANCEL', $id_putaway_header, "CLOSE PUTAWAY ID ".$id_putaway_header, $finish_at , $finish_at );

		if (!empty($qu_wptxxth)) {
			if(!empty($qu_wptxxth)){
				$db->commit();
				$status_code  = 200;
				$message      = 'CANCEL Putaway Berhasil';
				$type_message = 'success';
			}else{
				$db->rollback();
				$status_code  = 500;
				$message      = 'Cancel Putaway Gagal!';
				$type_message = 'error';
			}
		} else {
			$status_code  = 200;
			$message      = 'Tanpa CANCEL Putaway, karena belum detail yang di CANCEL belum lengkap!';
			$type_message = 'success';
		}
		
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'CANCEL Putaway Gagal! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'CANCEL Putaway Gagal!, ' . $e->getMessage();
		$type_message = 'error';
	}
	// build response
	$data = array(
		'status_code'    => $status_code,
		'message'        => $message,
		'type_message'   => $type_message,
		'id_putaway_header'   => $id_putaway_header,
	);

	// tampilkan results
    include( "../../../../usersc/helpers/fn_ajax_results.php" );
?>