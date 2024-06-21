<?php	
	/**
	 * Digunakan untuk insert inventory ke iivxxrd
	 */
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../../usersc/helpers/hakakses_s_fn.php" );
	// include_once( "../../../helpers/hakakses_s_fn.php" );

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
		//Putaway
		$imtxxmh_kode = 311;

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
			->where('activity_log_ml.nama', 'wptittd' )
			->exec();
		$rs_activity_log_ml = $qs_activity_log_ml->fetch();
		$confirmed_at       = $rs_activity_log_ml['confirmed_at'];
		$confirmed_date     = new Carbon($rs_activity_log_ml['confirmed_at']);
		// END ambil data confirmed_at dari table activity_log_ml

		//Location ditambahkan barangnya tapi is_fisik = 0
		// $qi_iivxxrd = $db
		// 	->raw()
		// 	->bind(':id', $id)
		// 	->exec('
		// 		INSERT INTO iivxxrd (
		// 			id_transaksi_h,
		// 			id_transaksi_d,
		// 			id_gcpxxmh,
		// 			id_gbrxxmh,
		// 			id_iwhxxmh,
		// 			id_wloctmh,
		// 			id_wloxxmh,
		// 			id_relasi_m,
		// 			id_iimxxmh,
		// 			id_iumxxmh_unit,
		// 			id_iumxxmh_terkecil,
		// 			id_iumxxmh_default,
		// 			kode,
		// 			keterangan,
		// 			confirmed_at,
		// 			created_by,
		// 			gcpxxmh_kode,
		// 			gcpxxmh_nama,
		// 			gbrxxmh_kode,
		// 			gbrxxmh_nama,
		// 			iwhxxmh_kode,
		// 			iwhxxmh_nama,
		// 			wloxxmh_kode,
		// 			wloxxmh_nama,
		// 			relasi_m_kode,
		// 			relasi_m_nama,
		// 			iimxxmh_kode,
		// 			iimxxmh_nama,
		// 			iumxxmh_unit_kode,
		// 			iumxxmh_unit_nama,
		// 			iumxxmh_terkecil_kode,
		// 			iumxxmh_terkecil_nama,
		// 			iumxxmh_default_kode,
		// 			iumxxmh_default_nama,
		// 			imtxxmh_kode,
		// 			imtxxmh_movement_type,
		// 			tanggal,
		// 			is_fisik,
		// 			jumlah_unit,
		// 			jumlah_konversi,
		// 			jumlah_terkecil,
		// 			jumlah_default,
		// 			wlpxxmh_kode,
		// 			expired_date,
		// 			batch_number
		// 		)
		// 		SELECT
		// 			a.id as id_transaksi_h,
		// 			a.id as id_transaksi_d,
		// 			a.id_gcpxxmh as id_gcpxxmh,
		// 			a.id_gbrxxmh as id_gbrxxmh,
		// 			a.id_iwhxxmh as id_iwhxxmh,
		// 			wloxxmh.id_wloctmh as id_wloctmh,
		// 			a.id_wloxxmh_tujuan as id_wloxxmh,
		// 			a.id_wloxxmh_asal as id_relasi_m,
		// 			a.id_iimxxmh,
		// 			a.id_iumxxmh_unit,
		// 			a.id_iumxxmh_terkecil,
		// 			a.id_iumxxmh_default,
		// 			a.kode,
		// 			a.keterangan,
		// 			"'.$confirmed_at.'",
		// 			a.created_by,
		// 			gcpxxmh.kode,
		// 			gcpxxmh.nama,
		// 			gbrxxmh.kode,
		// 			gbrxxmh.nama,
		// 			iwhxxmh.kode,
		// 			iwhxxmh.nama,
		// 			wloxxmh.kode,
		// 			wloxxmh.nama nama_loc,
		// 			relasi.kode,
		// 			relasi.nama nama_relasi,
		// 			iimxxmh.kode,
		// 			iimxxmh.nama,
		// 			iumxxmh_unit.kode,
		// 			iumxxmh_unit.nama,
		// 			iumxxmh_terkecil.kode,
		// 			iumxxmh_terkecil.nama,
		// 			iumxxmh_default.kode,
		// 			iumxxmh_default.nama,
		// 			'.$imtxxmh_kode.' as imtxxmh_kode,
		// 			imtxxmh.movement_type,
        //             "'.$confirmed_date->format('Y-m-d').'",
		// 			0 as is_fisik,
		// 			a.jumlah_unit as jumlah_unit,
		// 			a.jumlah_konversi as jumlah_konversi,
		// 			a.jumlah_terkecil as jumlah_terkecil,
		// 			a.jumlah_default as jumlah_default,
		// 			a.wlpxxmh_kode,
		// 			re.expired_date,
		// 			re.batch_number
		// 		FROM wptittd a
		// 		LEFT JOIN gcpxxmh ON gcpxxmh.id = a.id_gcpxxmh
		// 		LEFT JOIN gbrxxmh ON gbrxxmh.id = a.id_gbrxxmh
		// 		LEFT JOIN iwhxxmh ON iwhxxmh.id = a.id_iwhxxmh
		// 		LEFT JOIN wloxxmh ON wloxxmh.id = a.id_wloxxmh_tujuan
		// 		LEFT JOIN wreittd re ON re.wlpxxmh_kode = a.wlpxxmh_kode
		// 		LEFT JOIN grlxxmh relasi ON relasi.id = re.id_grlxxmh_supplier
		// 		LEFT JOIN iimxxmh ON iimxxmh.id = a.id_iimxxmh
		// 		LEFT JOIN iumxxmh as iumxxmh_unit ON iumxxmh_unit.id = a.id_iumxxmh_unit
		// 		LEFT JOIN iumxxmh as iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
		// 		LEFT JOIN iumxxmh as iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
		// 		LEFT JOIN imtxxmh as imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.'
		// 		WHERE a.id = :id
		// ');

		//Receiving diminuskan
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
					id_wloctmh,
					id_wloxxmh,
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
					wloxxmh_kode,
					wloxxmh_nama,
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
					wlpxxmh_kode,
					expired_date,
					batch_number
				)
				SELECT
					a.id as id_transaksi_h,
					a.id as id_transaksi_d,
					a.id_gcpxxmh as id_gcpxxmh,
					a.id_gbrxxmh as id_gbrxxmh,
					a.id_iwhxxmh as id_iwhxxmh,
					wloxxmh.id_wloctmh as id_wloctmh,
					a.id_wloxxmh_asal as id_wloxxmh,
					relasi.id as id_relasi_m,
					a.id_iimxxmh,
					a.id_iumxxmh_unit,
					a.id_iumxxmh_terkecil,
					a.id_iumxxmh_default,
					a.kode,
					a.keterangan,
					"'.$confirmed_at.'",
					a.created_by,
					gcpxxmh.kode,
					gcpxxmh.nama,
					gbrxxmh.kode,
					gbrxxmh.nama,
					iwhxxmh.kode,
					iwhxxmh.nama,
					wloxxmh.kode,
					wloxxmh.nama as loc,
					relasi.kode,
					relasi.nama,
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
                    "'.$confirmed_date->format('Y-m-d').'",
					1 as is_fisik,
					-a.jumlah_unit as jumlah_unit,
					a.jumlah_konversi as jumlah_konversi,
					-a.jumlah_terkecil as jumlah_terkecil,
					-a.jumlah_default as jumlah_default,
					a.wlpxxmh_kode,
					re.expired_date,
					re.batch_number
				FROM wptittd a
				LEFT JOIN gcpxxmh ON gcpxxmh.id = a.id_gcpxxmh
				LEFT JOIN gbrxxmh ON gbrxxmh.id = a.id_gbrxxmh
				LEFT JOIN iwhxxmh ON iwhxxmh.id = a.id_iwhxxmh
				LEFT JOIN wloxxmh ON wloxxmh.id = a.id_wloxxmh_asal
				LEFT JOIN wreittd re ON re.wlpxxmh_kode = a.wlpxxmh_kode
				LEFT JOIN grlxxmh relasi ON relasi.id = re.id_grlxxmh_supplier
				LEFT JOIN iimxxmh ON iimxxmh.id = a.id_iimxxmh
				LEFT JOIN iumxxmh as iumxxmh_unit ON iumxxmh_unit.id = a.id_iumxxmh_unit
				LEFT JOIN iumxxmh as iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
				LEFT JOIN iumxxmh as iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
				LEFT JOIN imtxxmh as imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.'
				WHERE a.id = :id
		');

		//Location ditambahkan barangnya
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
					id_wloctmh,
					id_wloxxmh,
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
					wloxxmh_kode,
					wloxxmh_nama,
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
					wlpxxmh_kode,
					expired_date,
					batch_number
				)
				SELECT
					a.id as id_transaksi_h,
					a.id as id_transaksi_d,
					a.id_gcpxxmh as id_gcpxxmh,
					a.id_gbrxxmh as id_gbrxxmh,
					a.id_iwhxxmh as id_iwhxxmh,
					wloxxmh.id_wloctmh as id_wloctmh,
					a.id_wloxxmh_tujuan as id_wloxxmh,
					relasi.id as id_relasi_m,
					a.id_iimxxmh,
					a.id_iumxxmh_unit,
					a.id_iumxxmh_terkecil,
					a.id_iumxxmh_default,
					a.kode,
					a.keterangan,
					"'.$confirmed_at.'",
					a.created_by,
					gcpxxmh.kode,
					gcpxxmh.nama,
					gbrxxmh.kode,
					gbrxxmh.nama,
					iwhxxmh.kode,
					iwhxxmh.nama,
					wloxxmh.kode,
					wloxxmh.nama nama_loc,
					relasi.kode,
					relasi.nama nama_relasi,
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
                    "'.$confirmed_date->format('Y-m-d').'",
					1 as is_fisik,
					a.jumlah_unit as jumlah_unit,
					a.jumlah_konversi as jumlah_konversi,
					a.jumlah_terkecil as jumlah_terkecil,
					a.jumlah_default as jumlah_default,
					a.wlpxxmh_kode,
					re.expired_date,
					re.batch_number
				FROM wptittd a
				LEFT JOIN gcpxxmh ON gcpxxmh.id = a.id_gcpxxmh
				LEFT JOIN gbrxxmh ON gbrxxmh.id = a.id_gbrxxmh
				LEFT JOIN iwhxxmh ON iwhxxmh.id = a.id_iwhxxmh
				LEFT JOIN wloxxmh ON wloxxmh.id = a.id_wloxxmh_tujuan
				LEFT JOIN wreittd re ON re.wlpxxmh_kode = a.wlpxxmh_kode
				LEFT JOIN grlxxmh relasi ON relasi.id = re.id_grlxxmh_supplier
				LEFT JOIN iimxxmh ON iimxxmh.id = a.id_iimxxmh
				LEFT JOIN iumxxmh as iumxxmh_unit ON iumxxmh_unit.id = a.id_iumxxmh_unit
				LEFT JOIN iumxxmh as iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
				LEFT JOIN iumxxmh as iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
				LEFT JOIN imtxxmh as imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.'
				WHERE a.id = :id
		');

		if(!empty($qi_iivxxrd)){
			$db->commit();
			$status_code  = 200;
			$message      = 'Inventory Berhasil Ditambahkan';
			$type_message = 'success';
		}else{
			$db->rollback();
			$status_code  = 500;
			$message      = 'Inventory Gagal Ditambahkan!';
			$type_message = 'error';
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'Inventory Gagal Ditambahkan! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Inventory Gagal Ditambahkan!, ' . $e->getMessage();
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