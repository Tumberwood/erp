<?php	
	/**
	 * Digunakan untuk insert DROP Item Putaway ke iivxxrd
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
		$id_wloxxmh_drop = $_POST['id_wloxxmh_drop'];

		$qs_wptittd = $db
            ->raw()
            ->bind(':id_putaway_header', $id_putaway_header)
            ->exec('SELECT
						a.id
					FROM wptittd a
					WHERE a.id_wptxxth = :id_putaway_header AND a.transaction_state = 0;
                '
            );

        $rs_wptittd = $qs_wptittd->fetchAll();

		// Extract IDs from the result set
		$ids = array_column($rs_wptittd, 'id');

		// Format as comma-separated list
		$ids_wptittd = implode(',', $ids);

		// Wrap in parentheses
		$ids_wptittd = $ids_wptittd ? "($ids_wptittd)" : '';

		//update confirm dan drop
		$qu_confirmD = $db
            ->raw()
            ->bind(':id_putaway_header', $id_putaway_header)
            ->bind(':id_wloxxmh_drop', $id_wloxxmh_drop)
            ->exec('UPDATE wptittd a
					SET 
						a.is_drop = 1,
						a.transaction_state = 1,
						a.id_wloxxmh_tujuan = :id_wloxxmh_drop
					WHERE a.id_wptxxth = :id_putaway_header AND a.transaction_state = 0;
                '
		);

		//generate kode
		foreach ($rs_wptittd as $key => $wpt) {
			$id_transaksi = $wpt['id'];

			//insert log CONFIRM
			$qi_log = $db
				->query('insert', 'activity_log_ml')
				->set('id_transaksi',$id_transaksi)
				->set('kode','CONFIRM')
				->set('nama', 'wptittd' )
				->set('keterangan', 'CONFIRM wptittd id = '.$id_transaksi )
				->set('created_by', $s_id_users )
				->set('username',$s_username)
				->set('start_on', date("Y-m-d H:i:s"))
				->set('finish_on', date("Y-m-d H:i:s"))
				->set('durasi_detik', 0)
			->exec();

			//SELECT GENERATE KODE
			$qs_genKode = $db
				->raw()
				->exec('WITH genKode as (
							SELECT
								LPAD(COUNT(activity_log_ml.id), 4, "0") AS c_id_new,
								CONCAT(
										SUBSTR(CURDATE(), 3, 2),
										SUBSTR(CURDATE(), 6, 2) 
									) AS tanggal,
									CURDATE(),
								c.prefix,
								c.`separator` AS strip
							FROM wptittd
							LEFT JOIN activity_log_ml ON
								activity_log_ml.id_transaksi = wptittd.id 
								AND  activity_log_ml.kode = "CONFIRM" 
								AND activity_log_ml.nama = "wptittd" 
							LEFT JOIN gdnxxsh c ON c.nama_tabel = "wptittd"
							WHERE activity_log_ml.kode = "CONFIRM" AND activity_log_ml.nama = "wptittd"
								AND YEAR(activity_log_ml.created_on) = YEAR(curdate()) AND MONTH(activity_log_ml.created_on) = MONTH(curdate()) 
						)
						SELECT
							CONCAT(prefix, strip, tanggal, strip, c_id_new) AS kode
						FROM genKode
					'
			);
			$rs_genKode = $qs_genKode->fetch();
			$new_kode = $rs_genKode['kode'];

			//UPDATE KODE
			$qu_kode = $db
				->raw()
				->bind(':new_kode', $new_kode)
				->bind(':id_transaksi', $id_transaksi)
				->exec('UPDATE wptittd a
						SET 
							a.kode = :new_kode
						WHERE a.id = :id_transaksi
					'
			);

			//DELETE BOOKING
			$qi_iivxxrd = $db
			->query('delete', 'iivxxrd')
			->where('keterangan','putaway_multi_id_wptittd_'.$id_transaksi)
			->exec();
		}

		//insert iivxxrd booking, booking balik, dan transfer
		
		//Booking, insert booking - dan + untuk hitory
		//Receiving diminuskan
		$qi_iivxxrd = $db
			->raw()
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
					wpaxxmh_kode,
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
					now(),
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
					311 as imtxxmh_kode,
					imtxxmh.movement_type,
                    curdate(),
					0 as is_fisik,
					-a.jumlah_unit as jumlah_unit,
					a.jumlah_konversi as jumlah_konversi,
					-a.jumlah_terkecil as jumlah_terkecil,
					-a.jumlah_default as jumlah_default,
					a.wlpxxmh_kode,
					a.wpaxxmh_kode,
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
				LEFT JOIN imtxxmh as imtxxmh ON imtxxmh.kode = 311
				WHERE a.id IN '.$ids_wptittd.'
		');

		$qi_iivxxrd = $db
			->raw()
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
					wpaxxmh_kode,
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
					now(),
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
					311 as imtxxmh_kode,
					imtxxmh.movement_type,
                    curdate(),
					0 as is_fisik,
					a.jumlah_unit as jumlah_unit,
					a.jumlah_konversi as jumlah_konversi,
					a.jumlah_terkecil as jumlah_terkecil,
					a.jumlah_default as jumlah_default,
					a.wlpxxmh_kode,
					a.wpaxxmh_kode,
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
				LEFT JOIN imtxxmh as imtxxmh ON imtxxmh.kode = 311
				WHERE a.id IN '.$ids_wptittd.'
		');
		////// END OF BOOKING

		//Receiving diminuskan
		$qi_iivxxrd = $db
			->raw()
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
					wpaxxmh_kode,
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
					now(),
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
					311 as imtxxmh_kode,
					imtxxmh.movement_type,
                    curdate(),
					1 as is_fisik,
					-a.jumlah_unit as jumlah_unit,
					a.jumlah_konversi as jumlah_konversi,
					-a.jumlah_terkecil as jumlah_terkecil,
					-a.jumlah_default as jumlah_default,
					a.wlpxxmh_kode,
					a.wpaxxmh_kode,
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
				LEFT JOIN imtxxmh as imtxxmh ON imtxxmh.kode = 311
				WHERE a.id IN '.$ids_wptittd.'
		');

		//Location ditambahkan barangnya
		$qi_iivxxrd = $db
			->raw()
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
					wpaxxmh_kode,
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
					now(),
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
					311 as imtxxmh_kode,
					imtxxmh.movement_type,
                    curdate(),
					1 as is_fisik,
					a.jumlah_unit as jumlah_unit,
					a.jumlah_konversi as jumlah_konversi,
					a.jumlah_terkecil as jumlah_terkecil,
					a.jumlah_default as jumlah_default,
					a.wlpxxmh_kode,
					a.wpaxxmh_kode,
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
				LEFT JOIN imtxxmh as imtxxmh ON imtxxmh.kode = 311
				WHERE a.id IN '.$ids_wptittd.'
		');

		if(!empty($qi_iivxxrd)){
			$db->commit();
			$status_code  = 200;
			$message      = 'DROP Item Putaway Berhasil Diupdate';
			$type_message = 'success';
		}else{
			$db->rollback();
			$status_code  = 500;
			$message      = 'DROP Item Putaway Gagal Diupdate!';
			$type_message = 'error';
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'DROP Item Putaway Gagal Diupdate! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'DROP Item Putaway Gagal Diupdate!, ' . $e->getMessage();
		$type_message = 'error';
	}
	// build response
	$data = array(
		'status_code'    => $status_code,
		'message'        => $message,
		'type_message'   => $type_message,
		'id_putaway_header'    => $id_putaway_header,
		'id_wloxxmh_drop'    => $id_wloxxmh_drop,
		'rs_wptittd'    => $rs_wptittd,
	);

	// tampilkan results
    include( "../../../../usersc/helpers/fn_ajax_results.php" );
?>