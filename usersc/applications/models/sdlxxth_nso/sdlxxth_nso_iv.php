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

	try{
		$db->transaction();
		
		// ganti movement type sesuai jenis transaksi
		$id    = $_POST['id_transaksi_h'];
		$state = $_POST['state'];

		// BEGIN ambil data confirmed_at dari table activity_log_ml
		$qs_activity_log_ml = $db
			->query('select', 'activity_log_ml' )
			->get([
				'activity_log_ml.created_on as confirmed_at'
			] )
			->where('activity_log_ml.id_transaksi', $id )
			->where('activity_log_ml.kode', 'CONFIRM' )
			->where('activity_log_ml.nama', 'sdlxxth_nso' )
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
					jumlah_default,
					harga_unit
				)
				SELECT
					sdlxxth_nso.id as id_transaksi_h,
					sdlittd_nso.id as id_transaksi_d,
					sdlxxth_nso.id_gcpxxmh as id_gcpxxmh,
					sdlxxth_nso.id_gbrxxmh as id_gbrxxmh,
					sdlxxth_nso.id_iwhxxmh as id_iwhxxmh,
					sdlxxth_nso.id_grlxxmh_customer as id_relasi_m,
					sdlittd_nso.id_iimxxmh,
					sdlittd_nso.id_iumxxmh_unit,
					sdlittd_nso.id_iumxxmh_terkecil,
					sdlittd_nso.id_iumxxmh_default,
					sdlxxth_nso.kode,
					sdlxxth_nso.keterangan,
					"'.$confirmed_at.'",
					sdlxxth_nso.created_by,
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
					sdlxxth_nso.imtxxmh_kode as imtxxmh_kode,
					imtxxmh.movement_type,
					sdlxxth_nso.tanggal,
					1 as is_fisik,
					-sdlittd_nso.jumlah_unit as jumlah_unit,
					sdlittd_nso.jumlah_konversi as jumlah_konversi,
					-sdlittd_nso.jumlah_terkecil as jumlah_terkecil,
					-sdlittd_nso.jumlah_default as jumlah_default,
					sdlittd_nso.harga_unit as harga_unit
				FROM sdlxxth_nso
				LEFT JOIN gcpxxmh ON gcpxxmh.id = sdlxxth_nso.id_gcpxxmh
				LEFT JOIN gbrxxmh ON gbrxxmh.id = sdlxxth_nso.id_gbrxxmh
				LEFT JOIN iwhxxmh ON iwhxxmh.id = sdlxxth_nso.id_iwhxxmh
				LEFT JOIN grlxxmh ON grlxxmh.id = sdlxxth_nso.id_grlxxmh_customer
				LEFT JOIN sdlittd_nso ON sdlittd_nso.id_sdlxxth_nso = sdlxxth_nso.id
				LEFT JOIN iimxxmh ON iimxxmh.id = sdlittd_nso.id_iimxxmh
				LEFT JOIN iumxxmh AS iumxxmh_unit ON iumxxmh_unit.id = sdlittd_nso.id_iumxxmh_unit
				LEFT JOIN iumxxmh AS iumxxmh_terkecil ON iumxxmh_terkecil.id = sdlittd_nso.id_iumxxmh_terkecil
				LEFT JOIN iumxxmh AS iumxxmh_default ON iumxxmh_default.id = sdlittd_nso.id_iumxxmh_default
				LEFT JOIN imtxxmh as imtxxmh ON imtxxmh.kode = sdlxxth_nso.imtxxmh_kode AND imtxxmh.module = "SIG"
				WHERE sdlxxth_nso.id = :id
			');

		// check apakah query ada resultnya
		if(!empty($qi_iivxxrd_npo)){
			$db->commit();
			$status_code  = '200';
			$message      = 'Sales Delivery Berhasil Dilakukan';
			$type_message = 'success';
			// parameter lain
		}else{
			$db->rollback();
			$status_code  = '500';
			$message      = 'Sales Delivery Gagal Dilakukan';
			$type_message = 'error';
			// parameter lain
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = '500';
		$message      = 'Sales Delivery Gagal Dilakukan! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Sales Delivery Gagal Dilakukan!, ' . $e->getMessage();
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