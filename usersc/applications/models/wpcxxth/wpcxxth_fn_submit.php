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

		$id_lpn    = $_POST['id_lpn'];
		$id_picking    = $_POST['id_picking'];
		$id_iumxxmh_input    = $_POST['id_iumxxmh_input'];
		$jumlah_unit_input    = $_POST['jumlah_unit_input'];
		$start_at    = $_POST['start_at'];
		$finish_at    = $_POST['finish_at'];
		$nama_table = "wpclptd";
		$nama_table_before = "wpllptd";

		$qi_lpn_picking = $db
            ->raw()
            ->bind(':id_picking', $id_picking)
            ->bind(':id_lpn', $id_lpn)
            ->bind(':id_iumxxmh_input', $id_iumxxmh_input)
            ->bind(':jumlah_unit_input', $jumlah_unit_input)
            ->exec('INSERT INTO wpclptd (
						id_wpcxxth,
						id_wpllptd,
						id_iimxxmh,
						id_wloxxmh_asal,
						id_wloxxmh_tujuan,
						id_iwhxxmh,
						id_iumxxmh_unit,
						jumlah_unit,
						wlpxxmh_kode,
						wloxxmh_nama,
						batch_number,
						expired_date,
						id_wdoittd
					)
					SELECT
						c.id,
						a.id,
						a.id_iimxxmh,
						a.id_wloxxmh,
						c.id_wloxxmh_out,
						a.id_iwhxxmh,
						:id_iumxxmh_input,
						:jumlah_unit_input,
						a.wlpxxmh_kode,
						a.wloxxmh_nama,
						a.batch_number,
						a.expired_date,
						b.id_wdoittd
					FROM wpllptd a
					LEFT JOIN wplittd b ON b.id = a.id_wplittd
					LEFT JOIN wpcxxth c ON c.id = :id_picking
					WHERE a.id = :id_lpn
			'
		);
			
		if(!empty($qi_lpn_picking)){
			$id = $qi_lpn_picking->insertId();
			include('wpcxxth_fn_konversi_terkecil.php');

			$qs_kode = $db
				->raw()
				->bind(':id_picking', $id_picking)
				->exec('SELECT
							CONCAT(b.kode, "/", LPAD(COUNT(a.id), 4, "0") ) AS kode_d,
							b.id_wplxxth
						FROM wpclptd a
						LEFT JOIN wpcxxth b ON b.id = a.id_wpcxxth
						WHERE a.id_wpcxxth = :id_picking
				'
			);
			$rs_kode = $qs_kode->fetch();
			$kode_d = $rs_kode['kode_d'];
			$id_wplxxth = $rs_kode['id_wplxxth'];
			
			$qu_wpclptd = $db
				->query('update', 'wpclptd')
				->set('kode',$kode_d)
				->where('id',$id)
				->exec();

			$qu_wpxxth = $db
				->raw()
				->bind(':id_lpn', $id_lpn)
				->exec('UPDATE wpllptd a
						SET 
							a.status_picking = 
								case 
									when a.jumlah_terkecil_os = a.jumlah_terkecil then 1
									when a.jumlah_terkecil_os = 0 then 3
									when a.jumlah_terkecil_os > 0 then 2
									ELSE
										1
								END
						WHERE a.id = :id_lpn
						;
				
				'
			);

			//hapus booking picking list
			$qd_booking_lpn_pickingList = $db
				->query('delete', 'iivxxrd')
				->where('keterangan','wplxxth_id_'.$id_wplxxth)
				->where('id_transaksi_d',$id_lpn)
				->exec();

			//insert booking iiv is_fisik 0
			$qi_iivxxrd = $db
				->raw()
				->bind(':id', $id)
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
						a.wloxxmh_nama,
						c.kode AS relasi_m_kode,
						c.nama AS relasi_m_nama,
						d.kode AS iimxxmh_kode,
						d.nama AS iimxxmh_nama,
						iumxxmh_unit.kode AS iumxxmh_unit_kode,
						iumxxmh_unit.nama AS iumxxmh_unit_nama,
						"",
						"",
						curdate(),
						0,
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
					WHERE a.id = :id
			');

			General::logChange( $db , 'wpclptd', $s_id_users, $s_username, 'CREATE', $id, $kode_d, $start_at , $finish_at );
			
			$db->commit();
			$status_code  = 200;
			$message      = 'Picking LPN Berhasil Ditambahkan';
			$type_message = 'success';
			
		}else{
			$db->rollback();
			$status_code  = 500;
			$message      = 'Picking LPN Gagal Ditambahkan!';
			$type_message = 'error';
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'Picking LPN Gagal Ditambahkan! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Picking LPN Gagal Ditambahkan!, ' . $e->getMessage();
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