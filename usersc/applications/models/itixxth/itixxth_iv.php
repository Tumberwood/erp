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
		$imtxxmh_kode = 303;
		
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
			->where('activity_log_ml.nama', 'itixxth' )
			->exec();
		$rs_activity_log_ml = $qs_activity_log_ml->fetch();
		$confirmed_at = $rs_activity_log_ml['confirmed_at'];
		// END ambil data confirmed_at dari table activity_log_ml

		// Dari gudang transit (-)
		$qi_asal = $db
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
					itixxth.id as id_transaksi_h,
					itiittd.id as id_transaksi_d,
					itixxth.id_gcpxxmh as id_gcpxxmh,
					itixxth.id_gbrxxmh as id_gbrxxmh,
					iwhxxmh_transit.id as id_iwhxxmh,
					itixxth.id_iwhxxmh_tujuan as id_relasi_m,
					itiittd.id_iimxxmh,
					itiittd.id_iumxxmh_unit,
					itiittd.id_iumxxmh_terkecil,
					itiittd.id_iumxxmh_default,
					itixxth.kode,
					itixxth.keterangan,
					"'.$confirmed_at.'",
					itixxth.created_by,
					gcpxxmh.kode,
					gcpxxmh.nama,
					gbrxxmh.kode,
					gbrxxmh.nama,
					iwhxxmh_transit.kode,
					iwhxxmh_transit.nama,
					iwhxxmh_tujuan.kode,
					iwhxxmh_tujuan.nama,
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
					itixxth.tanggal,
					1 as is_fisik,
					-itiittd.jumlah_unit as jumlah_unit,
					itiittd.jumlah_konversi as jumlah_konversi,
					-itiittd.jumlah_terkecil as jumlah_terkecil,
					-itiittd.jumlah_default as jumlah_default
				FROM itixxth
				LEFT JOIN gcpxxmh ON gcpxxmh.id = itixxth.id_gcpxxmh
				LEFT JOIN gbrxxmh ON gbrxxmh.id = itixxth.id_gbrxxmh
                LEFT JOIN iwhxxmh AS iwhxxmh_asal ON iwhxxmh_asal.id = itixxth.id_iwhxxmh_asal
				LEFT JOIN iwhxxmh AS iwhxxmh_tujuan ON iwhxxmh_tujuan.id = itixxth.id_iwhxxmh_tujuan
				LEFT JOIN iwhxxmh AS iwhxxmh_transit ON iwhxxmh_transit.kode = CONCAT("WHTR ", iwhxxmh_asal.kode, " - ", iwhxxmh_tujuan.kode) OR iwhxxmh_transit.kode = CONCAT("WHTR ", iwhxxmh_tujuan.kode, " - ", iwhxxmh_asal.kode)

				LEFT JOIN itiittd ON itiittd.id_itixxth = itixxth.id
				LEFT JOIN iimxxmh ON iimxxmh.id = itiittd.id_iimxxmh
				LEFT JOIN iumxxmh AS iumxxmh_unit ON iumxxmh_unit.id = itiittd.id_iumxxmh_unit
				LEFT JOIN iumxxmh AS iumxxmh_terkecil ON iumxxmh_terkecil.id = itiittd.id_iumxxmh_terkecil
				LEFT JOIN iumxxmh AS iumxxmh_default ON iumxxmh_default.id = itiittd.id_iumxxmh_default
				LEFT JOIN imtxxmh as imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.'
				WHERE itixxth.id = :id
			');

		// DIKIRIM atau Masuk ke Gudang Tujuan (+)
		$qi_tujuan = $db
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
					itixxth.id as id_transaksi_h,
					itiittd.id as id_transaksi_d,
					itixxth.id_gcpxxmh as id_gcpxxmh,
					itixxth.id_gbrxxmh as id_gbrxxmh,
					iwhxxmh_tujuan.id as id_iwhxxmh,
					iwhxxmh_asal.id as id_relasi_m,
					itiittd.id_iimxxmh,
					itiittd.id_iumxxmh_unit,
					itiittd.id_iumxxmh_terkecil,
					itiittd.id_iumxxmh_default,
					itixxth.kode,
					itixxth.keterangan,
					"'.$confirmed_at.'",
					itixxth.created_by,
					gcpxxmh.kode,
					gcpxxmh.nama,
					gbrxxmh.kode,
					gbrxxmh.nama,
					iwhxxmh_tujuan.kode,
					iwhxxmh_tujuan.nama,
					iwhxxmh_asal.kode,
					iwhxxmh_asal.nama,
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
					itixxth.tanggal,
					1 as is_fisik,
					itiittd.jumlah_unit as jumlah_unit,
					itiittd.jumlah_konversi as jumlah_konversi,
					itiittd.jumlah_terkecil as jumlah_terkecil,
					itiittd.jumlah_default as jumlah_default
				FROM itixxth
				LEFT JOIN gcpxxmh ON gcpxxmh.id = itixxth.id_gcpxxmh
				LEFT JOIN gbrxxmh ON gbrxxmh.id = itixxth.id_gbrxxmh
				LEFT JOIN iwhxxmh AS iwhxxmh_asal ON iwhxxmh_asal.id = itixxth.id_iwhxxmh_asal
				LEFT JOIN iwhxxmh AS iwhxxmh_tujuan ON iwhxxmh_tujuan.id = itixxth.id_iwhxxmh_tujuan
				LEFT JOIN itiittd ON itiittd.id_itixxth = itixxth.id
				LEFT JOIN iimxxmh ON iimxxmh.id = itiittd.id_iimxxmh
				LEFT JOIN iumxxmh AS iumxxmh_unit ON iumxxmh_unit.id = itiittd.id_iumxxmh_unit
				LEFT JOIN iumxxmh AS iumxxmh_terkecil ON iumxxmh_terkecil.id = itiittd.id_iumxxmh_terkecil
				LEFT JOIN iumxxmh AS iumxxmh_default ON iumxxmh_default.id = itiittd.id_iumxxmh_default
				LEFT JOIN imtxxmh as imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.'
				WHERE itixxth.id = :id
			');

		if(!empty($qi_asal) && !empty($qi_tujuan)){
			$db->commit();
			$status_code  = 200;
			$message      = 'Inventory Transfer Berhasil Dilakukan';
			$type_message = 'success';
		}else{
			$db->rollback();
			$status_code  = 500;
			$message      = 'Inventory Transfer Gagal Dilakukan!';
			$type_message = 'error';
		}


	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'Inventory Transfer Gagal Dilakukan! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Inventory Transfer Gagal Dilakukan!, ' . $e->getMessage();
		$type_message = 'error';
	}

	$data = array(
		'status_code'    => $status_code,
		'message'        => $message,
		'type_message'   => $type_message,
	);

	// tampilkan results
    include( "../../../../usersc/helpers/fn_ajax_results.php" );
?>