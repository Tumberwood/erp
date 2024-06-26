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
		$uniqueToken    = $_POST['uniqueToken'];
		$timestamp    = $_POST['timestamp'];

		$qi_lpn_d = $db
			->raw()
			->bind(':uniqueToken', $uniqueToken)
			->bind(':id_transaksi_h', $id_transaksi_h)
			->exec('INSERT INTO wpllptd (
						id_wplxxth,
						id_iimxxmh,
						id_iumxxmh_terkecil,
						id_iumxxmh_default,
						jumlah_terkecil,
						jumlah_default,
						wlpxxmh_kode,
						batch_number,
						expired_date
					)
					SELECT
						:id_transaksi_h,
						a.id_iimxxmh,
						b.id_iumxxmh_terkecil,
						b.id_iumxxmh_default,
						if(a.jumlah_terkecil > SUM(b.jumlah_terkecil), SUM(b.jumlah_terkecil), a.jumlah_terkecil) jumlah_terkecil_lpn,
						if(a.jumlah_default > SUM(b.jumlah_default), SUM(b.jumlah_default), a.jumlah_default) jumlah_default_lpn,
						wlpxxmh_kode,
						max(batch_number) batch_number,
						max(expired_date) as expired_date
					FROM wplittd a
					LEFT JOIN iivxxrd b ON b.id_iimxxmh = a.id_iimxxmh
					LEFT JOIN wplxxth c ON c.id = a.id_wplxxth
					LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
					WHERE c.id = :id_transaksi_h AND b.keterangan <> :uniqueToken
						AND (
								(c.is_crossdocking = 1 AND b.id_wloctmh IN (1, 3))
								OR
								(c.is_crossdocking <> 1 AND b.id_wloctmh = 3)
							)
					GROUP BY 
						a.id_iimxxmh,
						wlpxxmh_kode
					HAVING SUM(b.jumlah_terkecil) > 0
			'
		);

		$qi_iivxxrd = $db
			->raw()
			->bind(':uniqueToken', $uniqueToken)
			->bind(':id_transaksi_h', $id_transaksi_h)
			->exec('
				INSERT INTO iivxxrd (
					id_transaksi_h,
					id_wloctmh,
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
					batch_number,
					expired_date
				)
				SELECT
					:id_transaksi_h,
					b.id_wloctmh,
					wlpxxmh_kode,
					b.id_iwhxxmh,
					b.id_wloxxmh,
					f.id,
					a.id_iimxxmh,
					a.id_iumxxmh_unit,
					b.id_iumxxmh_terkecil,
					b.id_iumxxmh_default,
					:uniqueToken,
					iwhxxmh_kode,
					iwhxxmh_nama,
					b.wloxxmh_kode,
					b.wloxxmh_nama,
					f.kode relasi_m_kode,
					f.nama relasi_m_nama,
					b.iimxxmh_kode,
					b.iimxxmh_nama,
					g.kode iumxxmh_unit_kode,
					g.nama iumxxmh_unit_nama,
					curdate(),
					0, -- is_fisik
					b.iumxxmh_terkecil_kode,
					b.iumxxmh_terkecil_nama,
					b.iumxxmh_default_kode,
					b.iumxxmh_default_nama,
					-if(a.jumlah_default > SUM(b.jumlah_default), SUM(b.jumlah_default), a.jumlah_default) jumlah_unit,
					a.jumlah_konversi,
					-if(a.jumlah_terkecil > SUM(b.jumlah_terkecil), SUM(b.jumlah_terkecil), a.jumlah_terkecil) jumlah_terkecil_lpn,
					-if(a.jumlah_default > SUM(b.jumlah_default), SUM(b.jumlah_default), a.jumlah_default) jumlah_default_lpn,
					max(batch_number) batch_number,
					max(expired_date) as expired_date
				FROM wplittd a
				LEFT JOIN iivxxrd b ON b.id_iimxxmh = a.id_iimxxmh
				LEFT JOIN wplxxth c ON c.id = a.id_wplxxth
				LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
				LEFT JOIN wdoxxth e ON e.id = c.id_wdoxxth
				LEFT JOIN grlxxmh f ON f.id = e.id_grlxxmh_customer
				LEFT JOIN iumxxmh g ON g.id = a.id_iumxxmh_unit
				WHERE c.id = :id_transaksi_h AND b.keterangan <> :uniqueToken
				AND (
						(c.is_crossdocking = 1 AND b.id_wloctmh IN (1, 3))
						OR
						(c.is_crossdocking <> 1 AND b.id_wloctmh = 3)
					)
				GROUP BY 
					a.id_iimxxmh,
					wlpxxmh_kode
				HAVING SUM(b.jumlah_terkecil) > 0
		');
		
		if(!empty($qi_lpn_d)){
			$qu_wpxxth = $db
				->raw()
				->bind(':id_transaksi_h', $id_transaksi_h)
				->bind(':timestamp', $timestamp)
				->exec('UPDATE wplxxth a
						LEFT JOIN (
							SELECT 
								id_wplxxth,
								SUM(jumlah_terkecil) AS subtotal_jumlah_terkecil,
								SUM(jumlah_default) AS subtotal_jumlah_default
							FROM 
								wpllptd
							GROUP BY 
								id_wplxxth
						) AS b ON b.id_wplxxth = a.id
						SET 
							generated_on = :timestamp,
							a.is_generate_lpn = 1,
							a.subtotal_jumlah_terkecil = COALESCE(b.subtotal_jumlah_terkecil, 0),
							a.subtotal_jumlah_default = COALESCE(b.subtotal_jumlah_default, 0)
						WHERE a.id = :id_transaksi_h
						;
				
				'
			);
			
			$db->commit();
			$status_code  = 200;
			$message      = 'Detail LPN Berhasil Ditambahkan';
			$type_message = 'success';
			
		}else{
			$db->rollback();
			$status_code  = 500;
			$message      = 'Detail LPN Gagal Ditambahkan!';
			$type_message = 'error';
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'Detail LPN Gagal Ditambahkan! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Detail LPN Gagal Ditambahkan!, ' . $e->getMessage();
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