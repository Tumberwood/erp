<?php	
	/**
	 * Digunakan untuk insert inventory ke iivxxrd
	 */
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

	$json['hakakses'] = $hakakses;
	$s_id_users = $hakakses['s_id_users'];
	$s_username = $hakakses['s_username'];

	try{
		$db->transaction();

		$id_transaksi_h    = $_POST['id_transaksi_h'];
		$uniqueToken    = $_POST['uniqueToken'];
		$timestamp    = $_POST['timestamp'];

		$qs_ggswmsh = $db
			->query('select', 'ggswmsh' )
			->get(['is_replenishment'] )
			->where('id', 1 )
			->exec();
		$rs_ggswmsh = $qs_ggswmsh->fetch();
		$is_replenishment = $rs_ggswmsh['is_replenishment'];

		if ($is_replenishment == 1) {
			$qd_wtrittd = $db
				->query('delete', 'wtrittd')
				->where('keterangan',$uniqueToken)
				->exec();
		}
		
		$qd_lpn_d = $db
			->query('delete', 'wktlptd')
			->where('id_wktxxth',$id_transaksi_h)
			->exec();

		$qd_iivxxrd = $db
			->query('delete', 'iivxxrd')
			->where('id_transaksi_h',$id_transaksi_h)
			->where('keterangan',$uniqueToken)
			->exec();

		if(!empty($qd_lpn_d)){
			$qu_wpxxth = $db
				->raw()
				->bind(':id_transaksi_h', $id_transaksi_h)
				->bind(':timestamp', $timestamp)
				->exec('UPDATE wktxxth a
						SET 
							reset_on = :timestamp,
							a.is_generate_lpn = 0
						WHERE a.id = :id_transaksi_h
						;
				
				'
			);

			$qu_wpxxth = $db
				->raw()
				->bind(':id_transaksi_h', $id_transaksi_h)
				->exec('UPDATE wktittd a
						SET 
							subtotal_jumlah_terkecil = 0,
							subtotal_jumlah_unit = 0,
							subtotal_jumlah_default = 0
						WHERE a.id_wktxxth = :id_transaksi_h
						;
				
				'
			);
			
			$db->commit();
			$status_code  = 200;
			$message      = 'Job Picking Berhasil Direset';
			$type_message = 'success';
			
		}else{
			$db->rollback();
			$status_code  = 500;
			$message      = 'Job Picking Gagal Direset!';
			$type_message = 'error';
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'Job Picking Gagal Direset! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Job Picking Gagal Direset!, ' . $e->getMessage();
		$type_message = 'error';
	}
	// build response
	$data = array(
		'status_code'    => $status_code,
		'message'        => $message,
		'type_message'   => $type_message,
	);

	// tampilkan results
    include( "../../../../usersc/helpers/fn_ajax_results.php" );
?>