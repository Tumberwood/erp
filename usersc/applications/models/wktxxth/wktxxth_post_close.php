<?php
	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
	include( "../../../../usersc/helpers/datatables_fn_debug.php" );
    require '../../../../usersc/vendor/autoload.php';

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

	$id_transaksi = $_POST['id_transaksi'];

		try{
			$db->transaction();

			$qs_finalisasi = $db
				->raw()
				->bind(':id_transaksi', $id_transaksi)
				->exec('SELECT
							SUM(a.jumlah_unit) s_jumlah_unit
						FROM wktrstd a
						WHERE a.id_wktxxth = :id_transaksi
				'
				);
			$rs_finalisasi = $qs_finalisasi->fetch();
			$s_jumlah_unit  = $rs_finalisasi['s_jumlah_unit'];
		
			//ambil nilai terkecil dari datail
			$qs_terkecil_d = $db
				->raw()
				->bind(':id_transaksi', $id_transaksi)
				->exec('SELECT
							MIN(a.jumlah_unit) min_jumlah_unit
						FROM wktlptd a
						WHERE a.id_wktxxth = :id_transaksi
				'
				);
			$rs_terkecil_d = $qs_terkecil_d->fetch();
			$min_jumlah_unit  = $rs_terkecil_d['min_jumlah_unit'];

			$sisa = $min_jumlah_unit - $s_jumlah_unit;
			if ($sisa > 0) {
				//Insert Booking plus detail saat close
				$qi_iiv_close = $db
				->raw()
				->bind(':id_transaksi', $id_transaksi)
				->bind(':sisa', $sisa)
				->exec('INSERT INTO iivxxrd (
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
							a.id_wktxxth AS id_transaksi_h,
							a.id AS id_transaksi_d,
							f.id_wloctmh,
							a.kode,
							a.wlpxxmh_kode,
							a.id_iwhxxmh,
							b.id_wloxxmh_out,
							b.id_grlxxmh_customer id_relasi_m,
							a.id_iimxxmh,
							a.id_iumxxmh_unit,
							a.id_iumxxmh_terkecil,
							a.id_iumxxmh_default,
							CONCAT("wktxxth_", a.id_wktxxth) AS keterangan,
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
							219,
							g.movement_type,
							curdate(),
							0,
							iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
							iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
							iumxxmh_default.kode AS iumxxmh_default_kode,
							iumxxmh_default.nama AS iumxxmh_default_nama,
							
							:sisa * k.jumlah_unit jumlah_unit_iiv,
							a.jumlah_konversi,
							(:sisa * a.jumlah_konversi) * k.jumlah_unit jumlah_terkecil_iiv,
							(:sisa * a.jumlah_konversi / j.jumlah_konversi) * k.jumlah_unit jumlah_default_iiv,
							
							a.expired_date,
							a.batch_number
	
						FROM wktlptd a
						LEFT JOIN wktxxth b ON b.id = a.id_wktxxth
						LEFT JOIN grlxxmh c ON c.id = b.id_grlxxmh_customer
						LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
						LEFT JOIN iwhxxmh e ON e.id = a.id_iwhxxmh
						LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = a.id_iumxxmh_unit
						LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
						LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
						LEFT JOIN wloxxmh f ON f.id = b.id_wloxxmh_out
						LEFT JOIN imtxxmh g ON g.kode = 219
						LEFT JOIN gbrxxmh h ON h.id = e.id_gbrxxmh
						LEFT JOIN iimummd j ON j.id_iimxxmh = a.id_iimxxmh AND j.is_default = 1
						LEFT JOIN wktittd k ON k.id = a.id_wktittd
						WHERE b.id = :id_transaksi
						;				
						'
				);
			}

			//ini kalau semua
			// $qi_iiv_close = $db
			// ->raw()
			// ->bind(':id_transaksi', $id_transaksi)
			// ->exec('INSERT INTO iivxxrd (
			// 			id_gcpxxmh,
			// 			id_gbrxxmh,
			// 			id_transaksi_h,
			// 			id_transaksi_d,
			// 			id_wloctmh,
			// 			kode,
			// 			wlpxxmh_kode,
			// 			id_iwhxxmh,
			// 			id_wloxxmh,
			// 			id_relasi_m,
			// 			id_iimxxmh,
			// 			id_iumxxmh_unit,
			// 			id_iumxxmh_terkecil,
			// 			id_iumxxmh_default,
			// 			keterangan,
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
			// 			imtxxmh_kode,
			// 			imtxxmh_movement_type,
			// 			tanggal,
			// 			is_fisik,
			// 			iumxxmh_terkecil_kode,
			// 			iumxxmh_terkecil_nama,
			// 			iumxxmh_default_kode,
			// 			iumxxmh_default_nama,
			// 			jumlah_unit,
			// 			jumlah_konversi,
			// 			jumlah_terkecil,
			// 			jumlah_default,
			// 			expired_date,
			// 			batch_number
			// 		)
			// 		SELECT DISTINCT
			// 			h.id_gcpxxmh,
			// 			e.id_gbrxxmh,
			// 			a.id_wktxxth AS id_transaksi_h,
			// 			a.id AS id_transaksi_d,
			// 			f.id_wloctmh,
			// 			a.kode,
			// 			a.wlpxxmh_kode,
			// 			a.id_iwhxxmh,
			// 			b.id_wloxxmh_out,
			// 			b.id_grlxxmh_customer id_relasi_m,
			// 			a.id_iimxxmh,
			// 			a.id_iumxxmh_unit,
			// 			a.id_iumxxmh_terkecil,
			// 			a.id_iumxxmh_default,
			// 			CONCAT("wktxxth_", a.id_wktxxth) AS keterangan,
			// 			e.kode AS iwhxxmh_kode,
			// 			e.nama AS iwhxxmh_nama,
			// 			f.kode AS wloxxmh_kode,
			// 			f.nama AS wloxxmh_nama,
			// 			c.kode AS relasi_m_kode,
			// 			c.nama AS relasi_m_nama,
			// 			d.kode AS iimxxmh_kode,
			// 			d.nama AS iimxxmh_nama,
			// 			iumxxmh_unit.kode AS iumxxmh_unit_kode,
			// 			iumxxmh_unit.nama AS iumxxmh_unit_nama,
			// 			219,
			// 			g.movement_type,
			// 			curdate(),
			// 			0,
			// 			iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
			// 			iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
			// 			iumxxmh_default.kode AS iumxxmh_default_kode,
			// 			iumxxmh_default.nama AS iumxxmh_default_nama,
						
			// 			a.jumlah_unit jumlah_unit_iiv,
			// 			a.jumlah_konversi,
			// 			a.jumlah_terkecil jumlah_terkecil_iiv,
			// 			a.jumlah_default jumlah_default_iiv,
						
			// 			a.expired_date,
			// 			a.batch_number

			// 		FROM wktlptd a
			// 		LEFT JOIN wktxxth b ON b.id = a.id_wktxxth
			// 		LEFT JOIN grlxxmh c ON c.id = b.id_grlxxmh_customer
			// 		LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
			// 		LEFT JOIN iwhxxmh e ON e.id = a.id_iwhxxmh
			// 		LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = a.id_iumxxmh_unit
			// 		LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
			// 		LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
			// 		LEFT JOIN wloxxmh f ON f.id = b.id_wloxxmh_out
			// 		LEFT JOIN imtxxmh g ON g.kode = 219
			// 		LEFT JOIN gbrxxmh h ON h.id = e.id_gbrxxmh
			// 		LEFT JOIN iimummd j ON j.id_iimxxmh = a.id_iimxxmh AND j.is_default = 1
			// 		LEFT JOIN wktittd k ON k.id = a.id_wktittd
			// 		WHERE b.id = :id_transaksi
			// 		;				
			// 		'
			// );

			$db->commit();
			$data = array(
				'id_transaksi'=>$id_transaksi
			);
		}catch(PDOException $e){
			// rollback on error
			$db->rollback();
		}
?>