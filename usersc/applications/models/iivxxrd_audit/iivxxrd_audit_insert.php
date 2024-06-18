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

		// ganti movement type sesuai jenis transaksi
		//Putaway
		$start_at = $_POST['start_at'];
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
						transaction_state,
						id_gcpxxmh,
						id_gbrxxmh,
						id_iwhxxmh,
						id_wloctmh,
						id_wloxxmh,
						id_iimxxmh,
						id_iumxxmh_unit,
						id_iumxxmh_terkecil,
						id_iumxxmh_default,
						keterangan,
						created_by,
						gcpxxmh_kode,
						gcpxxmh_nama,
						gbrxxmh_kode,
						gbrxxmh_nama,
						iwhxxmh_kode,
						iwhxxmh_nama,
						wloxxmh_kode,
						wloxxmh_nama,
						iimxxmh_kode,
						iimxxmh_nama,
						iumxxmh_unit_kode,
						iumxxmh_unit_nama,
						iumxxmh_terkecil_kode,
						iumxxmh_terkecil_nama,
						iumxxmh_default_kode,
						iumxxmh_default_nama,
						jumlah_unit,
						jumlah_konversi,
						jumlah_terkecil,
						jumlah_default,
						wlpxxmh_kode,
						expired_date,
						batch_number,
						status_audit
					)
					SELECT
						1,
						id_gcpxxmh,
						id_gbrxxmh,
						id_iwhxxmh,
						id_wloctmh,
						id_wloxxmh,
						id_iimxxmh,
						id_iumxxmh_unit,
						id_iumxxmh_terkecil,
						id_iumxxmh_default,
						a.keterangan,
						:s_id_users,
						gcpxxmh_kode,
						gcpxxmh_nama,
						gbrxxmh_kode,
						gbrxxmh_nama,
						iwhxxmh_kode,
						iwhxxmh_nama,
						wloxxmh_kode,
						wloxxmh_nama,
						iimxxmh_kode,
						iimxxmh_nama,
						iumxxmh_unit_kode,
						iumxxmh_unit_nama,
						iumxxmh_terkecil_kode,
						iumxxmh_terkecil_nama,
						iumxxmh_default_kode,
						iumxxmh_default_nama,
						SUM(a.jumlah_unit) jumlah_unit,
						jumlah_konversi,
						SUM(a.jumlah_terkecil) jumlah_terkecil,
						SUM(a.jumlah_default) jumlah_default,
						a.wlpxxmh_kode,
						expired_date,
						batch_number,
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
		$id_audit = $qi_iivxxrd->insertId();


		if(!empty($qi_iivxxrd)){
			$db->commit();
			$status_code  = 200;
			$message      = 'Audit Inventory Berhasil Ditambahkan';
			$type_message = 'success';

			$finish_at = date("Y-m-d H:i:s");
			General::logChange( $db , 'iivxxrd_audit', $s_id_users, $s_username, 'CREATE', $id_audit, $insertValue, $start_at , $finish_at );
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