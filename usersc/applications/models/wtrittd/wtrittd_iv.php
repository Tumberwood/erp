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
		$imtxxmh_kode = 313;

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
			->where('activity_log_ml.nama', 'wtrittd' )
			->exec();
		$rs_activity_log_ml = $qs_activity_log_ml->fetch();
		$confirmed_at       = $rs_activity_log_ml['confirmed_at'];
		$confirmed_date     = new Carbon($rs_activity_log_ml['confirmed_at']);
		// END ambil data confirmed_at dari table activity_log_ml
		
		$qs_tri = $db
            ->raw()
            ->bind(':id', $id)
            ->exec('SELECT
						a.is_gabung_lpn,
						a.is_lpn_baru,
						a.is_ikut_baru,
						a.wlpxxmh_kode,
						a.kode,
						a.id_wloxxmh_asal,
						a.id_wloxxmh_tujuan,
						a.wlpxxmh_kode_tujuan
					FROM wtrittd a
					WHERE a.id = :id
			'
			);
	
		$rs_tri = $qs_tri->fetch();
		
		$is_gabung_lpn = $rs_tri['is_gabung_lpn'];
		$is_lpn_baru = $rs_tri['is_lpn_baru'];
		$is_ikut_baru = $rs_tri['is_ikut_baru'];
		$wlpxxmh_kode = $rs_tri['wlpxxmh_kode'];
		$kode_transaksi = $rs_tri['kode'];
		$wlpxxmh_kode_tujuan = $rs_tri['wlpxxmh_kode_tujuan'];
		$id_wloxxmh_asal = $rs_tri['id_wloxxmh_asal'];
		$id_wloxxmh_tujuan = $rs_tri['id_wloxxmh_tujuan'];
		
		//Booking Balik untuk riwayat
		//Location diminuskan
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
				SELECT DISTINCT
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
					0 as is_fisik,
					-a.jumlah_unit as jumlah_unit,
					a.jumlah_konversi as jumlah_konversi,
					-a.jumlah_terkecil as jumlah_terkecil,
					-a.jumlah_default as jumlah_default,
					a.wlpxxmh_kode,
					re.expired_date,
					re.batch_number
				FROM wtrittd a
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
				LEFT JOIN imtxxmh imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.' AND imtxxmh.transaction_state = 1
				WHERE a.id = :id
		');

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
				SELECT DISTINCT
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
					0 as is_fisik,
					a.jumlah_unit as jumlah_unit,
					a.jumlah_konversi as jumlah_konversi,
					a.jumlah_terkecil as jumlah_terkecil,
					a.jumlah_default as jumlah_default,
					a.wlpxxmh_kode,
					re.expired_date,
					re.batch_number
				FROM wtrittd a
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
				LEFT JOIN imtxxmh imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.' AND imtxxmh.transaction_state = 1
				WHERE a.id = :id
		');

		//Jika transfer ke LPN Baru
		if ($is_lpn_baru == 1) {
			
			//Location diminuskan
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
					SELECT DISTINCT
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
					FROM wtrittd a
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
					LEFT JOIN imtxxmh imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.' AND imtxxmh.transaction_state = 1
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
					SELECT DISTINCT
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
						a.wlpxxmh_kode_tujuan,
						re.expired_date,
						re.batch_number
					FROM wtrittd a
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
					LEFT JOIN imtxxmh imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.' AND imtxxmh.transaction_state = 1
					WHERE a.id = :id
			');
		} else {
			if ($is_gabung_lpn == 1) {
				//jika ikut Expired dan Batch LPN baru maka
				if ($is_ikut_baru == 1) {
					//Location diminuskan
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
							SELECT DISTINCT
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
							FROM wtrittd a
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
							LEFT JOIN imtxxmh imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.' AND imtxxmh.transaction_state = 1
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
							SELECT DISTINCT
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
								a.wlpxxmh_kode_tujuan,
								re.expired_date,
								re.batch_number
							FROM wtrittd a
							LEFT JOIN gcpxxmh ON gcpxxmh.id = a.id_gcpxxmh
							LEFT JOIN gbrxxmh ON gbrxxmh.id = a.id_gbrxxmh
							LEFT JOIN iwhxxmh ON iwhxxmh.id = a.id_iwhxxmh
							LEFT JOIN wloxxmh ON wloxxmh.id = a.id_wloxxmh_tujuan
							LEFT JOIN wreittd re ON re.wlpxxmh_kode = a.wlpxxmh_kode_tujuan
							LEFT JOIN grlxxmh relasi ON relasi.id = re.id_grlxxmh_supplier
							LEFT JOIN iimxxmh ON iimxxmh.id = a.id_iimxxmh
							LEFT JOIN iumxxmh as iumxxmh_unit ON iumxxmh_unit.id = a.id_iumxxmh_unit
							LEFT JOIN iumxxmh as iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
							LEFT JOIN iumxxmh as iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
							LEFT JOIN imtxxmh imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.' AND imtxxmh.transaction_state = 1
							WHERE a.id = :id
					');
				} else {
					
					//cari batch number dan expired date LPN asal dan tujuan
					$qs_cari_batch = $db
						->raw()
						->bind(':wlpxxmh_kode', $wlpxxmh_kode)
						->bind(':wlpxxmh_kode_tujuan', $wlpxxmh_kode_tujuan)
						->bind(':id_wloxxmh_tujuan', $id_wloxxmh_tujuan)
						->exec('SELECT
									a.id,
									a.batch_number AS batch_tujuan, -- batch number tujuan
									a.expired_date AS ed_tujuan,
									batch_asal,
									ed_asal
								FROM iivxxrd a
								-- ini yang Batch dan ED tujuan diubah ke Batch & ED asal
								LEFT JOIN (
									SELECT
										a.wlpxxmh_kode,
										a.batch_number batch_asal,
										a.expired_date ed_asal
									FROM iivxxrd a
									WHERE a.wlpxxmh_kode = :wlpxxmh_kode AND a.is_fisik = 1 AND a.jumlah_terkecil > 0
									LIMIT 1
								) asal ON asal.wlpxxmh_kode = :wlpxxmh_kode
								
								WHERE a.wlpxxmh_kode = :wlpxxmh_kode_tujuan AND a.id_wloxxmh = :id_wloxxmh_tujuan AND a.is_fisik = 1 AND a.jumlah_terkecil > 0
								ORDER BY a.id DESC
								LIMIT 1
						'
						);
					$rs_cari_batch = $qs_cari_batch->fetch();
	
					$ed_asal = $rs_cari_batch['ed_asal'];
					$batch_asal = $rs_cari_batch['batch_asal'];
	
					$ed_tujuan = $rs_cari_batch['ed_tujuan'];
					$batch_tujuan = $rs_cari_batch['batch_tujuan'];
	
					if ($ed_asal == $ed_tujuan && $batch_asal == $batch_tujuan) {
						//Jika sama, maka LPN tujuan tidak perlu insert ulang untuk mengubah batch dan ed sesuai LPN asal
					} else {
						//insert iiv minus dan plus untuk mengubah batch number LPN tujuan sesuai dengan LPN asal
						
						//Lokasi Tujuan diminuskan
						$qi_iivxxrd = $db
							->raw()
							->bind(':kode_transaksi', $kode_transaksi)
							->bind(':wlpxxmh_kode', $wlpxxmh_kode)
							->bind(':wlpxxmh_kode_tujuan', $wlpxxmh_kode_tujuan)
							->bind(':id_wloxxmh_tujuan', $id_wloxxmh_tujuan)
							->exec('INSERT INTO iivxxrd (
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
										:kode_transaksi,
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
										-jumlah_unit,
										jumlah_konversi,
										-jumlah_terkecil,
										-jumlah_default,
										a.wlpxxmh_kode,
										expired_date,
										batch_number
									FROM iivxxrd a
									-- ini yang Batch dan ED tujuan diubah ke Batch & ED asal
									LEFT JOIN (
										SELECT
											a.wlpxxmh_kode,
											a.batch_number batch_asal,
											a.expired_date ed_asal
										FROM iivxxrd a
										WHERE a.wlpxxmh_kode = :wlpxxmh_kode AND a.is_fisik = 1 AND a.jumlah_terkecil > 0
										ORDER BY a.id DESC 
										LIMIT 1
									) asal ON asal.wlpxxmh_kode = :wlpxxmh_kode
									
									WHERE a.wlpxxmh_kode = :wlpxxmh_kode_tujuan AND a.id_wloxxmh = :id_wloxxmh_tujuan AND a.is_fisik = 1 AND a.jumlah_terkecil > 0
							'
						);
				
						//Location ditambahkan barangnya lalu ubah ED dan Batch sesuai dengan LPN asal
						
						$qi_iivxxrd = $db
							->raw()
							->bind(':kode_transaksi', $kode_transaksi)
							->bind(':wlpxxmh_kode', $wlpxxmh_kode)
							->bind(':wlpxxmh_kode_tujuan', $wlpxxmh_kode_tujuan)
							->bind(':id_wloxxmh_asal', $id_wloxxmh_asal)
							->bind(':id_wloxxmh_tujuan', $id_wloxxmh_tujuan)
							->exec('INSERT INTO iivxxrd (
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
										id_transaksi_h,
										id_transaksi_d,
										id_gcpxxmh,
										id_gbrxxmh,
										id_iwhxxmh,
										id_wloctmh,
										:id_wloxxmh_asal,
										id_relasi_m,
										id_iimxxmh,
										id_iumxxmh_unit,
										id_iumxxmh_terkecil,
										id_iumxxmh_default,
										:kode_transaksi,
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
										:wlpxxmh_kode,
										ed_asal,
										batch_asal
									FROM iivxxrd a
									-- ini yang Batch dan ED tujuan diubah ke Batch & ED asal
									LEFT JOIN (
										SELECT
											a.wlpxxmh_kode,
											a.batch_number batch_asal,
											a.expired_date ed_asal
										FROM iivxxrd a
										WHERE a.wlpxxmh_kode = :wlpxxmh_kode AND a.is_fisik = 1 AND a.jumlah_terkecil > 0
										ORDER BY a.id DESC 
										LIMIT 1
									) asal ON asal.wlpxxmh_kode = :wlpxxmh_kode
									
									WHERE a.wlpxxmh_kode = :wlpxxmh_kode_tujuan AND a.id_wloxxmh = :id_wloxxmh_tujuan AND a.is_fisik = 1 AND a.jumlah_terkecil > 0
							'
						);
					}
	
					//Location diminuskan
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
							SELECT DISTINCT
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
							FROM wtrittd a
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
							LEFT JOIN imtxxmh imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.' AND imtxxmh.transaction_state = 1
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
							SELECT DISTINCT
								a.id as id_transaksi_h,
								a.id as id_transaksi_d,
								a.id_gcpxxmh as id_gcpxxmh,
								a.id_gbrxxmh as id_gbrxxmh,
								a.id_iwhxxmh as id_iwhxxmh,
								wloxxmh.id_wloctmh as id_wloctmh,
								-- a.id_wloxxmh_tujuan as id_wloxxmh,
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
							FROM wtrittd a
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
							LEFT JOIN imtxxmh imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.' AND imtxxmh.transaction_state = 1
							WHERE a.id = :id
					');
				}
			} else {
				//Location diminuskan
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
						SELECT DISTINCT
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
						FROM wtrittd a
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
						LEFT JOIN imtxxmh imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.' AND imtxxmh.transaction_state = 1
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
						SELECT DISTINCT
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
						FROM wtrittd a
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
						LEFT JOIN imtxxmh imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.' AND imtxxmh.transaction_state = 1
						WHERE a.id = :id
				');
			}
		}

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