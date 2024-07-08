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

		$id_picking    = $_POST['id_picking'];
		$start_at    = $_POST['start_at'];
		$confirm_at    = $_POST['confirm_at'];
		$imtxxmh_kode = 213;

		$qs_pick_h = $db
			->raw()
			->bind(':id_picking', $id_picking)
			->exec('SELECT
						b.kode,
						b.id_wplxxth,
						b.id_wloxxmh_out,
						b.id_wjtxxmh,
						b.id_grlxxmh_customer
					FROM wpcxxth b
					WHERE b.id = :id_picking
			'
		);
		$rs_pick_h = $qs_pick_h->fetch();

		$kode_awal = $rs_pick_h['kode'];
		$id_wplxxth = $rs_pick_h['id_wplxxth'];
		$id_wloxxmh_out = $rs_pick_h['id_wloxxmh_out'];
		$id_wjtxxmh = $rs_pick_h['id_wjtxxmh'];
		$id_grlxxmh_customer = $rs_pick_h['id_grlxxmh_customer'];

		//hapus booking picking list per header PL
		// $qd_booking_lpn_pickingList = $db
		// 	->query('delete', 'iivxxrd')
		// 	->where('keterangan','wplxxth_id_'.$id_wplxxth)
		// 	->where('id_transaksi_h',$id_wplxxth)
		// 	->exec();

		//select booking PL
		// $qs_booking_pl = $db
		// 	->raw()
		// 	->bind(':id_wplxxth', $id_wplxxth)
		// 	->exec('SELECT
		// 				a.id_transaksi_d,
		// 				SUM(a.jumlah_terkecil) s_terkecil,
		// 				SUM(a.jumlah_unit) s_unit
		// 			FROM iivxxrd a
		// 			WHERE a.keterangan = CONCAT("wplxxth_id_", :id_wplxxth)
		// 			GROUP BY a.wlpxxmh_kode
		// 			HAVING s_terkecil < 0
		// 	'
		// );
		// $rs_booking_pl = $qs_booking_pl->fetchAll();
		// if (!empty($rs_booking_pl)) {
		// 	foreach ($rs_booking_pl as $key => $booking_pl) {
		// 		$s_terkecil = $booking_pl['s_terkecil'];
		// 		$id_transaksi_d = $booking_pl['id_transaksi_d'];
		// 		//jika sum booking PL masih minus, maka insert booking balik nya (+)
		// 		if ($s_terkecil < 0) {
					
		// 			//insert booking balik (+) terhadapt booking PL
		// 			$qi_iivxxrd = $db
		// 				->raw()
		// 				->bind(':id_transaksi_d', $id_transaksi_d)
		// 				->bind(':id_wplxxth', $id_wplxxth)
		// 				->bind(':imtxxmh_kode', $imtxxmh_kode)
		// 				->exec('
		// 					INSERT INTO iivxxrd (
		// 						id_gcpxxmh,
		// 						id_gbrxxmh,
		// 						id_transaksi_h,
		// 						id_transaksi_d,
		// 						id_wloctmh,
		// 						kode,
		// 						wlpxxmh_kode,
		// 						id_iwhxxmh,
		// 						id_wloxxmh,
		// 						id_relasi_m,
		// 						id_iimxxmh,
		// 						id_iumxxmh_unit,
		// 						id_iumxxmh_terkecil,
		// 						id_iumxxmh_default,
		// 						keterangan,
		// 						iwhxxmh_kode,
		// 						iwhxxmh_nama,
		// 						wloxxmh_kode,
		// 						wloxxmh_nama,
		// 						relasi_m_kode,
		// 						relasi_m_nama,
		// 						iimxxmh_kode,
		// 						iimxxmh_nama,
		// 						iumxxmh_unit_kode,
		// 						iumxxmh_unit_nama,
		// 						imtxxmh_kode,
		// 						imtxxmh_movement_type,
		// 						tanggal,
		// 						is_fisik,
		// 						iumxxmh_terkecil_kode,
		// 						iumxxmh_terkecil_nama,
		// 						iumxxmh_default_kode,
		// 						iumxxmh_default_nama,
		// 						jumlah_unit,
		// 						jumlah_konversi,
		// 						jumlah_terkecil,
		// 						jumlah_default,
		// 						expired_date,
		// 						batch_number
		// 					)
		// 					SELECT DISTINCT
		// 						id_gcpxxmh,
		// 						id_gbrxxmh,
		// 						id_transaksi_h,
		// 						id_transaksi_d,
		// 						id_wloctmh,
		// 						a.kode,
		// 						wlpxxmh_kode,
		// 						id_iwhxxmh,
		// 						id_wloxxmh,
		// 						id_relasi_m,
		// 						id_iimxxmh,
		// 						id_iumxxmh_unit,
		// 						id_iumxxmh_terkecil,
		// 						id_iumxxmh_default,
		// 						a.keterangan,
		// 						iwhxxmh_kode,
		// 						iwhxxmh_nama,
		// 						wloxxmh_kode,
		// 						wloxxmh_nama,
		// 						relasi_m_kode,
		// 						relasi_m_nama,
		// 						iimxxmh_kode,
		// 						iimxxmh_nama,
		// 						iumxxmh_unit_kode,
		// 						iumxxmh_unit_nama,
		// 						imtxxmh_kode,
		// 						imtxxmh_movement_type,
		// 						tanggal,
		// 						is_fisik,
		// 						iumxxmh_terkecil_kode,
		// 						iumxxmh_terkecil_nama,
		// 						iumxxmh_default_kode,
		// 						iumxxmh_default_nama,
		// 						SUM(a.jumlah_unit * -1) s_unit,
		// 						jumlah_konversi,
		// 						SUM(a.jumlah_terkecil * -1) s_terkecil,
		// 						SUM(a.jumlah_default * -1) s_default,
		// 						expired_date,
		// 						batch_number
		// 					FROM iivxxrd a
		// 					LEFT JOIN imtxxmh g ON g.kode = :imtxxmh_kode
		// 					WHERE a.keterangan = CONCAT("wplxxth_id_", :id_wplxxth) AND id_transaksi_d = :id_transaksi_d
		// 					GROUP BY a.wlpxxmh_kode
		// 			');
		// 		}
		// 	}
		// }
		
		//delete iiv booking per item tadi
		$qu_iivxxrd = $db
			->query('delete', 'iivxxrd')
			->where('id_transaksi_h',$id_picking)
			->where('keterangan',"wpcxxth_".$id_picking)
			->exec();

		//insert WPC baru setiap confirm
		$qi_wpcxxth_baru = $db
			->query('insert', 'wpcxxth')
			->set('transaction_state',1)
			->set('id_wplxxth',$id_wplxxth)
			->set('id_wpcxxth',$id_picking)
			->set('id_wloxxmh_out',$id_wloxxmh_out)
			->set('id_wjtxxmh',$id_wjtxxmh)
			->set('id_grlxxmh_customer',$id_grlxxmh_customer)
			->exec();
		$id_wpcxxth_baru = $qi_wpcxxth_baru->insertId();
		
		$qs_kode_h = $db
			->raw()
			->bind(':kode_awal', $kode_awal)
			->bind(':id_picking', $id_picking)
			->exec('SELECT
						CONCAT(:kode_awal, "/C", COUNT(b.id) ) AS kode_h,
						b.id_wplxxth
					FROM wpcxxth b
					WHERE b.id_wpcxxth = :id_picking
			'
		);
		$rs_kode_h = $qs_kode_h->fetch();
		$kode_h = $rs_kode_h['kode_h'];

		//update kode Pc baru dengant tambahan /C1, C2 ...
		$qu_kode_h = $db
			->query('update', 'wpcxxth')
			->set('kode',$kode_h)
			->where('id',$id_wpcxxth_baru)
			->exec();

		//select picking d
		$qs_pick_d = $db
			->raw()
			->bind(':id_picking', $id_picking)
			->exec('SELECT
						ROW_NUMBER() OVER(ORDER BY a.id) AS s_id,
						LPAD(ROW_NUMBER() OVER(ORDER BY a.id), 4, 0) AS kode_d,
						a.id
					FROM wpclptd a
					LEFT JOIN wpcxxth b ON b.id = a.id_wpcxxth
					WHERE a.id_wpcxxth = :id_picking;
		
			'
		);
		$rs_pick_d = $qs_pick_d->fetchAll();
		
		//update kode picking d
		foreach ($rs_pick_d as $key => $pick_d) {
			$kode_d = $kode_h . "/" . $pick_d['kode_d'];
			$id_d = $pick_d['id'];

			$qu_wpclptd = $db
				->query('update', 'wpclptd')
				->set('id_wpcxxth',$id_wpcxxth_baru)
				->set('kode',$kode_d)
				->where('id',$id_d)
				->exec();
		}
			

		//insert booking minus
		$qi_iivxxrd = $db
			->raw()
			->bind(':id_wpcxxth_baru', $id_wpcxxth_baru)
			->bind(':imtxxmh_kode', $imtxxmh_kode)
			->exec('
				INSERT INTO iivxxrd (
					id_gcpxxmh,
					id_gbrxxmh,
					id_transaksi_h,
					id_transaksi_d,
					id_wloctmh,
					kode,
					wlpxxmh_kode,
					id_iwhxxmh,
					id_wloxxmh,
					id_relasi_m,
					id_iimxxmh,
					id_iumxxmh_unit,
					id_iumxxmh_terkecil,
					id_iumxxmh_default,
					keterangan,
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
					imtxxmh_kode,
					imtxxmh_movement_type,
					tanggal,
					is_fisik,
					iumxxmh_terkecil_kode,
					iumxxmh_terkecil_nama,
					iumxxmh_default_kode,
					iumxxmh_default_nama,
					jumlah_unit,
					jumlah_konversi,
					jumlah_terkecil,
					jumlah_default,
					expired_date,
					batch_number
				)
				SELECT DISTINCT
					h.id_gcpxxmh,
					e.id_gbrxxmh,
					a.id_wpcxxth AS id_transaksi_h,
					a.id AS id_transaksi_d,
					f.id_wloctmh,
					a.kode,
					a.wlpxxmh_kode,
					a.id_iwhxxmh,
					a.id_wloxxmh_asal,
					b.id_grlxxmh_customer id_relasi_m,
					a.id_iimxxmh,
					a.id_iumxxmh_unit,
					a.id_iumxxmh_terkecil,
					a.id_iumxxmh_default,
					CONCAT("wpcxxth_", a.id_wpcxxth) AS keterangan,
					e.kode AS iwhxxmh_kode,
					e.nama AS iwhxxmh_nama,
					f.kode AS wloxxmh_kode,
					f.nama AS wloxxmh_nama,
					c.kode AS relasi_m_kode,
					c.nama AS relasi_m_nama,
					d.kode AS iimxxmh_kode,
					d.nama AS iimxxmh_nama,
					iumxxmh_unit.kode AS iumxxmh_unit_kode,
					iumxxmh_unit.nama AS iumxxmh_unit_nama,
					:imtxxmh_kode,
					g.movement_type,
					curdate(),
					1,
					iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
					iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
					iumxxmh_default.kode AS iumxxmh_default_kode,
					iumxxmh_default.nama AS iumxxmh_default_nama,
					-a.jumlah_unit,
					a.jumlah_konversi,
					-a.jumlah_terkecil,
					-a.jumlah_default,
					a.expired_date,
					a.batch_number

				FROM wpclptd a
				LEFT JOIN wpcxxth b ON b.id = a.id_wpcxxth
				LEFT JOIN grlxxmh c ON c.id = b.id_grlxxmh_customer
				LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
				LEFT JOIN iwhxxmh e ON e.id = a.id_iwhxxmh
				LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = a.id_iumxxmh_unit
				LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
				LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
				LEFT JOIN wloxxmh f ON f.id = a.id_wloxxmh_asal
				LEFT JOIN imtxxmh g ON g.kode = :imtxxmh_kode
				LEFT JOIN gbrxxmh h ON h.id = e.id_gbrxxmh
				WHERE b.id = :id_wpcxxth_baru
		');

		//insert booking ke dispatch
		$qi_iivxxrd = $db
			->raw()
			->bind(':id_wpcxxth_baru', $id_wpcxxth_baru)
			->bind(':imtxxmh_kode', $imtxxmh_kode)
			->exec('
				INSERT INTO iivxxrd (
					id_gcpxxmh,
					id_gbrxxmh,
					id_transaksi_h,
					id_transaksi_d,
					id_wloctmh,
					kode,
					wlpxxmh_kode,
					id_iwhxxmh,
					id_wloxxmh,
					id_relasi_m,
					id_iimxxmh,
					id_iumxxmh_unit,
					id_iumxxmh_terkecil,
					id_iumxxmh_default,
					keterangan,
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
					imtxxmh_kode,
					imtxxmh_movement_type,
					tanggal,
					is_fisik,
					iumxxmh_terkecil_kode,
					iumxxmh_terkecil_nama,
					iumxxmh_default_kode,
					iumxxmh_default_nama,
					jumlah_unit,
					jumlah_konversi,
					jumlah_terkecil,
					jumlah_default,
					expired_date,
					batch_number
				)
				SELECT DISTINCT
					h.id_gcpxxmh,
					e.id_gbrxxmh,
					a.id_wpcxxth AS id_transaksi_h,
					a.id AS id_transaksi_d,
					f.id_wloctmh,
					a.kode,
					a.wlpxxmh_kode,
					a.id_iwhxxmh,
					a.id_wloxxmh_tujuan,
					b.id_grlxxmh_customer id_relasi_m,
					a.id_iimxxmh,
					a.id_iumxxmh_unit,
					a.id_iumxxmh_terkecil,
					a.id_iumxxmh_default,
					CONCAT("wpcxxth_", a.id_wpcxxth) AS keterangan,
					e.kode AS iwhxxmh_kode,
					e.nama AS iwhxxmh_nama,
					f.kode AS wloxxmh_kode,
					f.nama AS wloxxmh_nama,
					c.kode AS relasi_m_kode,
					c.nama AS relasi_m_nama,
					d.kode AS iimxxmh_kode,
					d.nama AS iimxxmh_nama,
					iumxxmh_unit.kode AS iumxxmh_unit_kode,
					iumxxmh_unit.nama AS iumxxmh_unit_nama,
					:imtxxmh_kode,
					g.movement_type,
					curdate(),
					1,
					iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
					iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
					iumxxmh_default.kode AS iumxxmh_default_kode,
					iumxxmh_default.nama AS iumxxmh_default_nama,
					a.jumlah_unit,
					a.jumlah_konversi,
					a.jumlah_terkecil,
					a.jumlah_default,
					a.expired_date,
					a.batch_number

				FROM wpclptd a
				LEFT JOIN wpcxxth b ON b.id = a.id_wpcxxth
				LEFT JOIN grlxxmh c ON c.id = b.id_grlxxmh_customer
				LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
				LEFT JOIN iwhxxmh e ON e.id = a.id_iwhxxmh
				LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = a.id_iumxxmh_unit
				LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
				LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
				LEFT JOIN wloxxmh f ON f.id = a.id_wloxxmh_tujuan
				LEFT JOIN imtxxmh g ON g.kode = :imtxxmh_kode
				LEFT JOIN gbrxxmh h ON h.id = e.id_gbrxxmh
				WHERE b.id = :id_wpcxxth_baru
		');

		if(!empty($qi_iivxxrd)){
			//insert semua detail picking ke activity_log confirm
			// $qs_picking = $db
			// 	->query('select', 'wpclptd' )
			// 	->get([
			// 		'id',
			// 		'kode'
			// 	] )
			// 	->where('id_wpcxxth', $id_picking )
			// 	->exec();
			// $rs_picking = $qs_picking->fetchAll();

			// foreach ($rs_picking as $key => $pick) {
			// 	$id = $pick['id'];
			// 	$kode_d = $pick['kode'];

			// 	General::logChange( $db , 'wpclptd', $s_id_users, $s_username, 'CONFIRM', $id, $kode_d, $start_at , $confirm_at );
			// }

			//cek all full
			$qs_is_full = $db
				->raw()
				->bind(':id_picking', $id_picking)
				->exec('SELECT
							a.id_wpcxxth,
							a.id_wplxxth,
							SUM(a.jumlah_terkecil_os) s_sisa
						FROM wpllptd a
						WHERE a.id_wpcxxth = :id_picking
				'
			);
			$rs_is_full = $qs_is_full->fetch();
			$s_sisa = $rs_is_full['s_sisa'];
			$id_wpcxxth = $rs_is_full['id_wpcxxth'];
			$id_wplxxth = $rs_is_full['id_wplxxth'];

			if ($s_sisa == 0) {
				$qu_wplxxth = $db
					->query('update', 'wplxxth')
					->set('transaction_state',8)
					->where('id',$id_wplxxth)
					->exec();

				$qu_wpcxxth = $db
					->query('update', 'wpcxxth')
					->set('transaction_state',8)
					->where('id',$id_wpcxxth)
					->exec();
			}
			
			General::logChange( $db , 'wpcxxth', $s_id_users, $s_username, 'CONFIRM', $id_picking, 'Confirm Picking id='.$id_picking, $start_at , $confirm_at );
			
			$db->commit();
			$status_code  = 200;
			$message      = 'Confirm Picking LPN Berhasil';
			$type_message = 'success';
			
		}else{
			$db->rollback();
			$status_code  = 500;
			$message      = 'Confirm Picking LPN Gagal!';
			$type_message = 'error';
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'Confirm Picking LPN Gagal! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Confirm Picking LPN Gagal!, ' . $e->getMessage();
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