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

		$qs_kode = $db
			->raw()
			->bind(':id_picking', $id_picking)
			->exec('SELECT
						b.id_wplxxth
					FROM wpcxxth b
					WHERE b.id = :id_picking
			'
		);
		$rs_kode = $qs_kode->fetch();
		$id_wplxxth = $rs_kode['id_wplxxth'];

		//hapus booking picking list per header PL
		$qd_booking_lpn_pickingList = $db
			->query('delete', 'iivxxrd')
			->where('keterangan','wplxxth_id_'.$id_wplxxth)
			->where('id_transaksi_h',$id_wplxxth)
			->exec();
		
		//delete iiv booking untuk wpcxxth yang pernah diconfirm sebelumnya
		//untuk menghindari insert ganda
		$qu_iivxxrd = $db
			->query('delete', 'iivxxrd')
			->where('id_transaksi_h',$id_picking)
			->where('keterangan',"wpcxxth_".$id_picking)
			->exec();

		//insert booking minus
		$qi_iivxxrd = $db
			->raw()
			->bind(':id_picking', $id_picking)
			->bind(':imtxxmh_kode', $imtxxmh_kode)
			->exec('
				INSERT INTO iivxxrd (
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
				SELECT
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
				WHERE b.id = :id_picking
		');

		//insert booking ke dispatch
		$qi_iivxxrd = $db
			->raw()
			->bind(':id_picking', $id_picking)
			->bind(':imtxxmh_kode', $imtxxmh_kode)
			->exec('
				INSERT INTO iivxxrd (
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
				SELECT
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
				WHERE b.id = :id_picking
		');

		if(!empty($qi_iivxxrd)){
			//insert semua detail picking ke activity_log confirm
			$qs_picking = $db
				->query('select', 'wpclptd' )
				->get([
					'id',
					'kode'
				] )
				->where('id_wpcxxth', $id_picking )
				->exec();
			$rs_picking = $qs_picking->fetchAll();

			foreach ($rs_picking as $key => $pick) {
				$id = $pick['id'];
				$kode_d = $pick['kode'];

				General::logChange( $db , 'wpclptd', $s_id_users, $s_username, 'CONFIRM', $id, $kode_d, $start_at , $confirm_at );
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