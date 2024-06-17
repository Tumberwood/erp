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

	$json['hakakses'] = $hakakses;
	$s_id_users = $hakakses['s_id_users'];

	try{
		$db->transaction();

		// ganti movement type sesuai jenis transaksi
		//Putaway
		$insertValue    = $_POST['insertValue']; //concat id_iimxxmh, batch, ED, LPN, location
		$statusAuditValue    = $_POST['statusAuditValue']; //concat id_iimxxmh, batch, ED, LPN, location
		// echo $statusAuditValue;
		// echo $insertValue;

		//Lokasi Tujuan diminuskan
		$qi_iivxxrd = $db
			->raw()
			->bind(':statusAuditValue', $statusAuditValue)
			->bind(':insertValue', $insertValue)
			->bind(':s_id_users', $s_id_users)
			->exec('INSERT INTO iivxxrd_audit (
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
						batch_number,
						tanggal_dibuat,
						status_audit
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
						a.kode,
						a.keterangan,
						confirmed_at,
						:s_id_users,
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
						SUM(a.jumlah_unit) jumlah_unit,
						jumlah_konversi,
						SUM(a.jumlah_terkecil) jumlah_terkecil,
						SUM(a.jumlah_default) jumlah_default,
						a.wlpxxmh_kode,
						expired_date,
						batch_number,
						curdate(),
						:statusAuditValue
					FROM iivxxrd a
					LEFT JOIN wlpxxmh b ON b.kode = a.wlpxxmh_kode
					WHERE a.is_fisik = 1
					GROUP BY 
						id_gbrxxmh, 
						id_iwhxxmh,
						id_iimxxmh,
						id_wloxxmh,
						wlpxxmh_kode
					HAVING jumlah_terkecil > 0 
						AND CONCAT(a.id_iimxxmh,a.batch_number,a.expired_date,a.wlpxxmh_kode,a.id_wloxxmh) = :insertValue
			'
		);


		if(!empty($qi_iivxxrd)){
			$db->commit();
			$status_code  = 200;
			$message      = 'Audit Inventory Berhasil Ditambahkan';
			$type_message = 'success';
		}else{
			$db->rollback();
			$status_code  = 500;
			$message      = 'Audit Inventory Gagal Ditambahkan!';
			$type_message = 'error';
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'Audit Inventory Gagal Ditambahkan! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Audit Inventory Gagal Ditambahkan!, ' . $e->getMessage();
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