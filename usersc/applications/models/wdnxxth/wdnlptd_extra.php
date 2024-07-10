<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row )  use ($nama_table, $nama_table_before) {
			include('wdnxxth_fn_konversi_terkecil.php');
			include('wdnlptd_kalkulasi_items.php');
			
			//insert booking
			$qi_booking = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('INSERT INTO iivxxrd (
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
							a.id_wdnxxth AS id_transaksi_h,
							a.id AS id_transaksi_d,
							wlo.id_wloctmh,
							"" AS kode,
							a.wlpxxmh_kode,
							wlo.id_iwhxxmh,
							wlo.id AS id_wloxxmh,
							c.id_grlxxmh_customer AS id_relasi_m,
							a.id_iimxxmh,
							a.id_iumxxmh_unit,
							a.id_iumxxmh_terkecil,
							a.id_iumxxmh_default,
							CONCAT("id_wdnxxth=", a.id_wdnxxth) AS keterangan,
							wlo.kode AS wloxxmh_kode,
							wlo.nama AS wloxxmh_nama,
							iwh.kode AS iwhxxmh_kode,
							iwh.nama AS iwhxxmh_nama,
							cs.kode AS relasi_m_kode,
							cs.nama AS relasi_m_nama,
							item.kode AS iimxxmh_kode,
							item.nama AS iimxxmh_nama,
							unit.kode AS iumxxmh_unit_kode,
							unit.nama AS iumxxmh_unit_nama,
							217,
							imt.movement_type,
							CURDATE(),
							0 AS is_fisik,
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
						FROM wdnlptd a
						LEFT JOIN wdplptd b ON b.id = a.id_wdplptd
						LEFT JOIN wdnxxth c ON c.id = a.id_wdnxxth
						LEFT JOIN wloxxmh wlo ON wlo.id = b.id_wloxxmh_tujuan
						LEFT JOIN iwhxxmh iwh ON iwh.id = wlo.id_iwhxxmh
						LEFT JOIN grlxxmh cs ON cs.id = c.id_grlxxmh_customer
						LEFT JOIN iimxxmh item ON item.id = a.id_iimxxmh
						LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
						LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
						LEFT JOIN iumxxmh unit ON unit.id = a.id_iumxxmh_unit
						LEFT JOIN imtxxmh imt ON imt.kode = 217
						WHERE a.id = :id;
				'
			);
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row )  use ($nama_table, $nama_table_before) {
			include('wdnxxth_fn_konversi_terkecil.php');
			include('wdnlptd_kalkulasi_items.php');
			$id_wdnxxth = $values['wdnlptd']['id_wdnxxth'];

			$qd_booking_old = $editor->db()
				->query('delete', 'iivxxrd')
				->where('keterangan','id_wdnxxth='.$id_wdnxxth)
				->where('is_fisik',0)
				->where('id_transaksi_d',$id)
				->exec();
			
			//insert booking
			$qi_booking = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('INSERT INTO iivxxrd (
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
							a.id_wdnxxth AS id_transaksi_h,
							a.id AS id_transaksi_d,
							wlo.id_wloctmh,
							"" AS kode,
							a.wlpxxmh_kode,
							wlo.id_iwhxxmh,
							wlo.id AS id_wloxxmh,
							c.id_grlxxmh_customer AS id_relasi_m,
							a.id_iimxxmh,
							a.id_iumxxmh_unit,
							a.id_iumxxmh_terkecil,
							a.id_iumxxmh_default,
							CONCAT("id_wdnxxth=", a.id_wdnxxth) AS keterangan,
							wlo.kode AS wloxxmh_kode,
							wlo.nama AS wloxxmh_nama,
							iwh.kode AS iwhxxmh_kode,
							iwh.nama AS iwhxxmh_nama,
							cs.kode AS relasi_m_kode,
							cs.nama AS relasi_m_nama,
							item.kode AS iimxxmh_kode,
							item.nama AS iimxxmh_nama,
							unit.kode AS iumxxmh_unit_kode,
							unit.nama AS iumxxmh_unit_nama,
							217,
							imt.movement_type,
							CURDATE(),
							0 AS is_fisik,
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
						FROM wdnlptd a
						LEFT JOIN wdplptd b ON b.id = a.id_wdplptd
						LEFT JOIN wdnxxth c ON c.id = a.id_wdnxxth
						LEFT JOIN wloxxmh wlo ON wlo.id = b.id_wloxxmh_tujuan
						LEFT JOIN iwhxxmh iwh ON iwh.id = wlo.id_iwhxxmh
						LEFT JOIN grlxxmh cs ON cs.id = c.id_grlxxmh_customer
						LEFT JOIN iimxxmh item ON item.id = a.id_iimxxmh
						LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
						LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
						LEFT JOIN iumxxmh unit ON unit.id = a.id_iumxxmh_unit
						LEFT JOIN imtxxmh imt ON imt.kode = 217
						WHERE a.id = :id;
				'
			);
		})
		->on('preRemove',function( $editor, $id, $values ) {
			$qs_this = $editor->db()
				->query('select', 'wdnlptd' )
				->get([
					'jumlah_terkecil',
				] )
				->where('id', $id )
				->exec();
			$rs_this = $qs_this->fetch();
			$id_wdplptd = $values['wdnlptd']['id_wdplptd'];

			$jumlah_terkecil = $rs_this['jumlah_terkecil'];

			$qu_wdo = $editor->db()
				->raw()
				->bind(':id_wdplptd', $id_wdplptd)
				->bind(':jumlah_terkecil', $jumlah_terkecil)
				->exec('UPDATE wdplptd
						SET
							jumlah_terkecil_os = jumlah_terkecil_os + :jumlah_terkecil,
							jumlah_terkecil_next = jumlah_terkecil_next - :jumlah_terkecil
						WHERE id = :id_wdplptd'
			);
			
			$id_wdnxxth = $values['wdnlptd']['id_wdnxxth'];

			$qd_booking_old = $editor->db()
				->query('delete', 'iivxxrd')
				->where('keterangan','id_wdnxxth='.$id_wdnxxth)
				->where('is_fisik',0)
				->where('id_transaksi_d',$id)
				->exec();

		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
			include('wdnlptd_kalkulasi_items.php');
		});
?>