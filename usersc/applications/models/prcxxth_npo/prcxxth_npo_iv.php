<?php
	/**
	 * Digunakan untuk insert data ke table iivxxrd_npo
	 * Hanya dilakukan jika item type (iitxxmh) menggunakan inventory
	 */
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

	// ganti movement type sesuai jenis transaksi
	$imtxxmh_kode = 101;

	$id    = $_POST['id_transaksi_h'];
	$state = $_POST['state'];

	try{
		$db->transaction();
		
		// BEGIN ambil data confirmed_at dari table activity_log_ml
		$qs_activity_log_ml = $db
			->query('select', 'activity_log_ml' )
			->get([
				'activity_log_ml.created_on as confirmed_at'
			] )
			->where('activity_log_ml.id_transaksi', $id )
			->where('activity_log_ml.kode', 'CONFIRM' )
			->where('activity_log_ml.nama', 'prcxxth_npo' )
			->exec();
		$rs_activity_log_ml = $qs_activity_log_ml->fetch();
		$confirmed_at = $rs_activity_log_ml['confirmed_at'];
		// END ambil data confirmed_at dari table activity_log_ml
		
		$qi_iivxxrd_npo = $db
			->raw()
			->bind(':id', $id)
			->exec('
				INSERT INTO iivxxrd_npo (
					id_transaksi_h,
					id_transaksi_d,
					id_gcpxxmh,
					id_gbrxxmh,
					id_iwhxxmh,
					id_relasi_m,
					id_iimxxmh,
					id_iumxxmh_unit,
					id_iumxxmh_terkecil,
					id_iumxxmh_default,
					kode,
					keterangan,
					confirmed_at,
					created_by,
					gcpxxmh_kode,
					gcpxxmh_nama,
					gbrxxmh_kode,
					gbrxxmh_nama,
					iwhxxmh_kode,
					iwhxxmh_nama,
					relasi_m_kode,
					relasi_m_nama,
					iimxxmh_kode,
					iimxxmh_nama,
					iumxxmh_unit_kode,
					iumxxmh_unit_nama,
					iumxxmh_terkecil_kode,
					iumxxmh_terkecil_nama,
					iumxxmh_default_kode,
					iumxxmh_default_nama,
					imtxxmh_kode,
					imtxxmh_movement_type,
					tanggal,
					is_fisik,
					jumlah_unit,
					jumlah_konversi,
					jumlah_terkecil,
					jumlah_default
				)
				SELECT
					prcxxth_npo.id as id_transaksi_h,
					prcittd_npo.id as id_transaksi_d,
					prcxxth_npo.id_gcpxxmh as id_gcpxxmh,
					prcxxth_npo.id_gbrxxmh as id_gbrxxmh,
					prcxxth_npo.id_iwhxxmh as id_iwhxxmh,
					prcxxth_npo.id_grlxxmh_supplier as id_relasi_m,
					prcittd_npo.id_iimxxmh,
					prcittd_npo.id_iumxxmh_unit,
					prcittd_npo.id_iumxxmh_terkecil,
					prcittd_npo.id_iumxxmh_default,
					prcxxth_npo.kode,
					prcxxth_npo.keterangan,
					"'.$confirmed_at.'",
					prcxxth_npo.created_by,
					gcpxxmh.kode,
					gcpxxmh.nama,
					gbrxxmh.kode,
					gbrxxmh.nama,
					iwhxxmh.kode,
					iwhxxmh.nama,
					grlxxmh.kode,
					grlxxmh.nama,
					iimxxmh.kode,
					iimxxmh.nama,
					iumxxmh_unit.kode,
					iumxxmh_unit.nama,
					iumxxmh_terkecil.kode,
					iumxxmh_terkecil.nama,
					iumxxmh_default.kode,
					iumxxmh_default.nama,
					'.$imtxxmh_kode.' as imtxxmh_kode,
					imtxxmh.movement_type,
					prcxxth_npo.tanggal,
					1 as is_fisik,
					prcittd_npo.jumlah_unit as jumlah_unit,
					prcittd_npo.jumlah_konversi as jumlah_konversi,
					prcittd_npo.jumlah_terkecil as jumlah_terkecil,
					prcittd_npo.jumlah_default as jumlah_default
				FROM prcxxth_npo
				LEFT JOIN gcpxxmh ON gcpxxmh.id = prcxxth_npo.id_gcpxxmh
				LEFT JOIN gbrxxmh ON gbrxxmh.id = prcxxth_npo.id_gbrxxmh
				LEFT JOIN iwhxxmh ON iwhxxmh.id = prcxxth_npo.id_iwhxxmh
				LEFT JOIN grlxxmh ON grlxxmh.id = prcxxth_npo.id_grlxxmh_supplier
				LEFT JOIN prcittd_npo ON prcittd_npo.id_prcxxth_npo = prcxxth_npo.id
				LEFT JOIN iimxxmh ON iimxxmh.id = prcittd_npo.id_iimxxmh
				LEFT JOIN iumxxmh AS iumxxmh_unit ON iumxxmh_unit.id = prcittd_npo.id_iumxxmh_unit
				LEFT JOIN iumxxmh AS iumxxmh_terkecil ON iumxxmh_terkecil.id = prcittd_npo.id_iumxxmh_terkecil
				LEFT JOIN iumxxmh AS iumxxmh_default ON iumxxmh_default.id = prcittd_npo.id_iumxxmh_default
				LEFT JOIN imtxxmh as imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.' AND imtxxmh.module = "SIG"
				WHERE prcxxth_npo.id = :id
			');

		// check apakah query ada resultnya
		if(!empty($qi_iivxxrd_npo)){
			$db->commit();
			$status_code  = '200';
			$message      = 'Goods Receive Berhasil Dilakukan';
			$type_message = 'success';
			// parameter lain
		}else{
			$db->rollback();
			$status_code  = '500';
			$message      = 'Goods Receive Gagal Dilakukan';
			$type_message = 'error';
			// parameter lain
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = '500';
		$message      = 'Goods Receive Gagal Dilakukan! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Goods Receive Gagal Dilakukan!, ' . $e->getMessage();
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