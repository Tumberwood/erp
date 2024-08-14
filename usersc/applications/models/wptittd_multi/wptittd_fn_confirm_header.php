<?php	
	/**
	 * Digunakan untuk insert CONFIRM Header Putaway ke iivxxrd
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

		$qs_header = $db
            ->raw()
            ->bind(':id_putaway_header', $id_putaway_header)
            ->bind(':s_id_users', $s_id_users)
            ->exec('SELECT
						COUNT(a.id) c_id
					FROM wptittd a 
					LEFT JOIN wptxxth b ON b.id = a.id_wptxxth
					WHERE a.created_by = :s_id_users AND a.is_multi_lpn = 1 AND b.transaction_state = 0 AND a.id_wptxxth = :id_putaway_header'
			);
	
		$rs_header = $qs_header->fetch();
		$c_totalDetail = $rs_header['c_id'];
		
		$qs_detail_confirm = $db
            ->raw()
            ->bind(':id_putaway_header', $id_putaway_header)
            ->bind(':s_id_users', $s_id_users)
            ->exec('SELECT
						COUNT(a.id) c_id,
						GROUP_CONCAT(a.kode SEPARATOR " - ") kode
					FROM wptittd a 
					LEFT JOIN wptxxth b ON b.id = a.id_wptxxth
					WHERE a.created_by = :s_id_users AND a.is_multi_lpn = 1 AND a.transaction_state = 1 AND a.id_wptxxth = :id_putaway_header'
			);
	
		$rs_detail_confirm = $qs_detail_confirm->fetch();
		$c_totalDetailConfirm = $rs_detail_confirm['c_id'];
		$kode = $rs_detail_confirm['kode'];

		// echo $c_totalDetail;
		// echo $c_totalDetailConfirm;

		if ($c_totalDetailConfirm == $c_totalDetail) {

			$qu_wptxxth = $db
				->query('update', 'wptxxth')
				->set('kode',$kode)
				->set('transaction_state',1)
				->where('id',$id_putaway_header)
				->exec();

			$finish_at = new Carbon();
			General::logChange( $db , 'wptxxth', $s_id_users, $s_username, 'CONFIRM', $id_putaway_header, "", $finish_at , $finish_at );
			
			if(!empty($qu_wptxxth)){
				$db->commit();
				$status_code  = 200;
				$message      = 'CONFIRM Header Putaway Berhasil';
				$type_message = 'success';
			}else{
				$db->rollback();
				$status_code  = 500;
				$message      = 'Inventory Gagal!';
				$type_message = 'error';
			}
		} else {
			$status_code  = 200;
			$message      = 'Tanpa Confirm Header Putaway, karena belum detail yang di confirm belum lengkap!';
			$type_message = 'success';
		}
		
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'CONFIRM Header Putaway Gagal! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'CONFIRM Header Putaway Gagal!, ' . $e->getMessage();
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