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

		$id_transaksi_h    = $_POST['id_transaksi_h'];
		$id_iwhxxmh    = $_POST['id_iwhxxmh_old'];

		$qs_isoxxth_wms = $db
			->query('select', 'isoxxth_wms' )
			->get(['tanggal'] )
			->where('id', $id_transaksi_h )
			->exec();
		$rs_isoxxth_wms = $qs_isoxxth_wms->fetch();
		$tanggal = $rs_isoxxth_wms['tanggal'];
		
		$qi_isoittd_wms = $db
			->raw()
			->bind(':id_transaksi_h', $id_transaksi_h)
			->bind(':id_iwhxxmh', $id_iwhxxmh)
			->bind(':tanggal', $tanggal)
			->exec('INSERT INTO isoittd_wms (
						id_isoxxth_wms,
						is_cut_off,
						id_gcpxxmh,
						id_gbrxxmh,
						id_iwhxxmh,
						id_wloxxmh,
						id_iimxxmh,
						id_iumxxmh_unit,
						id_iumxxmh_terkecil,
						id_iumxxmh_default,
						tanggal,
						jumlah_iiv_terkecil,
						jumlah_unit,
						jumlah_konversi,
						jumlah_terkecil,
						jumlah_default,
						wlpxxmh_kode,
						expired_date,
						batch_number
					)
					SELECT
						:id_transaksi_h,
						1,
						id_gcpxxmh,
						id_gbrxxmh,
						id_iwhxxmh,
						id_wloxxmh,
						id_iimxxmh,
						id_iumxxmh_terkecil, -- unit auto terkecil aja untuk yg cut off
						id_iumxxmh_terkecil,
						id_iumxxmh_default,
						:tanggal,
						(SUM(jumlah_terkecil * is_fisik)) - ifnull(jumlah_terkecil_booking,0) as jumlah_iiv_terkecil,
						(SUM(jumlah_terkecil * is_fisik)) - ifnull(jumlah_terkecil_booking,0) as jumlah_unit,
						jumlah_konversi,
						(SUM(jumlah_terkecil * is_fisik)) - ifnull(jumlah_terkecil_booking,0) as jumlah_terkecil_ava,
						(SUM(jumlah_default * is_fisik)) - ifnull(jumlah_default_booking,0) as jumlah_default_ava,
						a.wlpxxmh_kode,
						max(expired_date) expired_date_ymd,
						max(batch_number) batch_number
					FROM iivxxrd a
					LEFT JOIN (
						SELECT
							wloxxmh_nama,
							iimxxmh_kode,
							SUM(jumlah_default) * -1 as jumlah_default_booking,
							SUM(jumlah_terkecil) * -1 as jumlah_terkecil_booking,
							wlpxxmh_kode
						FROM iivxxrd
						WHERE tanggal <= CURDATE() AND is_fisik = 0
						GROUP BY
							id_iwhxxmh,
							id_iimxxmh,
							id_wloxxmh,
							wlpxxmh_kode
					) AS b ON b.wloxxmh_nama = a.wloxxmh_nama AND b.iimxxmh_kode = a.iimxxmh_kode AND b.wlpxxmh_kode = a.wlpxxmh_kode
					LEFT JOIN wlpxxmh c ON c.kode = a.wlpxxmh_kode
					WHERE a.is_fisik = 1
					AND a.id_iwhxxmh = :id_iwhxxmh
					AND CONCAT(a.id_iimxxmh, a.batch_number, a.expired_date, a.wlpxxmh_kode, a.id_wloxxmh) NOT IN (
						SELECT
							CONCAT(c.id_iimxxmh, c.batch_number, c.expired_date, c.wlpxxmh_kode, c.id_wloxxmh)
						FROM isoittd_wms c
						WHERE c.transaction_state = 0
					)
					GROUP BY
						id_gbrxxmh,
						id_iwhxxmh,
						id_iimxxmh,
						id_wloxxmh,
						wlpxxmh_kode
					HAVING ( SUM(jumlah_terkecil * is_fisik) ) > 0
					AND wlpxxmh_kode IS NOT NULL;
		');

		if($qi_isoittd_wms){

			$qu_isoxxth_wms = $db
				->query('update', 'isoxxth_wms')
				->set('is_cut_off', 1)
				->set('cut_off_at', date('Y-m-d H:i:s'))
				->where('id', $id_transaksi_h)
			->exec();
			
			$db->commit();
			$status_code  = 200;
			$message      = 'Cut OFF Berhasil di Generate';
			$type_message = 'success';
			
		}else{
			// $db->rollback();
			$db->commit();
			$status_code  = 500;
			$message      = 'Cut OFF Gagal di Generate!'. '<br>';
			$type_message = 'error';
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'Cut OFF Gagal di Generate! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Cut OFF Gagal di Generate!, ' . $e->getMessage();
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