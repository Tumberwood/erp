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
		$imtxxmh_kode = 201;

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
			->where('activity_log_ml.nama', 'scsxxth' )
			->exec();
		$rs_activity_log_ml = $qs_activity_log_ml->fetch();
		$confirmed_at = $rs_activity_log_ml['confirmed_at'];
		// END ambil data confirmed_at dari table activity_log_ml

		//Minus
		$qi_iivxxrd = $db
			->raw()
			->bind(':id', $id)
			->exec('
				INSERT INTO iivxxrd (
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
					scsxxth.id as id_transaksi_h,
					scsittd.id as id_transaksi_d,
					scsxxth.id_gcpxxmh as id_gcpxxmh,
					scsxxth.id_gbrxxmh as id_gbrxxmh,
					scsxxth.id_iwhxxmh as id_iwhxxmh,
					scsxxth.id_grlxxmh_customer as id_relasi_m,
					scsittd.id_iimxxmh,
					scsittd.id_iumxxmh_unit,
					scsittd.id_iumxxmh_terkecil,
					scsittd.id_iumxxmh_default,
					scsxxth.kode,
					scsxxth.keterangan,
					"'.$confirmed_at.'",
					scsxxth.created_by,
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
					scsxxth.tanggal,
					1 as is_fisik,
					-scsittd.jumlah_unit as jumlah_unit,
					scsittd.jumlah_konversi as jumlah_konversi,
					-scsittd.jumlah_terkecil as jumlah_terkecil,
					-scsittd.jumlah_default as jumlah_default
				FROM scsxxth
				LEFT JOIN gcpxxmh ON gcpxxmh.id = scsxxth.id_gcpxxmh
				LEFT JOIN gbrxxmh ON gbrxxmh.id = scsxxth.id_gbrxxmh
				LEFT JOIN iwhxxmh ON iwhxxmh.id = scsxxth.id_iwhxxmh
				LEFT JOIN grlxxmh ON grlxxmh.id = scsxxth.id_grlxxmh_customer
				LEFT JOIN scsittd ON scsittd.id_scsxxth = scsxxth.id
				LEFT JOIN iimxxmh ON iimxxmh.id = scsittd.id_iimxxmh
				LEFT JOIN iumxxmh AS iumxxmh_unit ON iumxxmh_unit.id = scsittd.id_iumxxmh_unit
				LEFT JOIN iumxxmh AS iumxxmh_terkecil ON iumxxmh_terkecil.id = scsittd.id_iumxxmh_terkecil
				LEFT JOIN iumxxmh AS iumxxmh_default ON iumxxmh_default.id = scsittd.id_iumxxmh_default
				LEFT JOIN imtxxmh as imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.' AND imtxxmh.module = "ERP"
				WHERE scsxxth.id = :id
		');

		//Plus di WH Customer Konsinyasi
		$qi_iivxxrd = $db
			->raw()
			->bind(':id', $id)
			->exec('
				INSERT INTO iivxxrd (
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
					scsxxth.id as id_transaksi_h,
					scsittd.id as id_transaksi_d,
					scsxxth.id_gcpxxmh as id_gcpxxmh,
					iwhxxmh.id_gbrxxmh as id_gbrxxmh,
					iwhxxmh.id as id_iwhxxmh,
					scsxxth.id_grlxxmh_customer as id_relasi_m,
					scsittd.id_iimxxmh,
					scsittd.id_iumxxmh_unit,
					scsittd.id_iumxxmh_terkecil,
					scsittd.id_iumxxmh_default,
					scsxxth.kode,
					scsxxth.keterangan,
					"'.$confirmed_at.'",
					scsxxth.created_by,
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
					scsxxth.tanggal,
					1 as is_fisik,
					scsittd.jumlah_unit as jumlah_unit,
					scsittd.jumlah_konversi as jumlah_konversi,
					scsittd.jumlah_terkecil as jumlah_terkecil,
					scsittd.jumlah_default as jumlah_default
				FROM scsxxth
				LEFT JOIN gcpxxmh ON gcpxxmh.id = scsxxth.id_gcpxxmh
				LEFT JOIN gbrxxmh ON gbrxxmh.id = scsxxth.id_gbrxxmh
				LEFT JOIN grlxxmh ON grlxxmh.id = scsxxth.id_grlxxmh_customer
				LEFT JOIN iwhxxmh ON iwhxxmh.id_grlxxmh = grlxxmh.id
				LEFT JOIN scsittd ON scsittd.id_scsxxth = scsxxth.id
				LEFT JOIN iimxxmh ON iimxxmh.id = scsittd.id_iimxxmh
				LEFT JOIN iumxxmh AS iumxxmh_unit ON iumxxmh_unit.id = scsittd.id_iumxxmh_unit
				LEFT JOIN iumxxmh AS iumxxmh_terkecil ON iumxxmh_terkecil.id = scsittd.id_iumxxmh_terkecil
				LEFT JOIN iumxxmh AS iumxxmh_default ON iumxxmh_default.id = scsittd.id_iumxxmh_default
				LEFT JOIN imtxxmh as imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.' AND imtxxmh.module = "ERP"
				WHERE scsxxth.id = :id
			');

		// check apakah query ada resultnya
		if(!empty($qi_iivxxrd)){
			$db->commit();
			$status_code  = '200';
			$message      = 'Sales Consignee Berhasil Dilakukan';
			$type_message = 'success';
			// parameter lain
		}else{
			$db->rollback();
			$status_code  = '500';
			$message      = 'Sales Consignee Gagal Dilakukan';
			$type_message = 'error';
			// parameter lain
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = '500';
		$message      = 'Sales Consignee Gagal Dilakukan! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Sales Consignee Gagal Dilakukan!, ' . $e->getMessage();
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