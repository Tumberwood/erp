<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			//insert minus Kitting Set
			$qi_iivxxrd_head = $editor->db()
				->raw()
				->bind(':id', $id)
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
							b.id AS id_transaksi_h,
							b.id AS id_transaksi_d,
							f.id_wloctmh,
							b.kode,
							b.wlpxxmh_kode_kitting,
							f.id_iwhxxmh,
							b.id_wloxxmh_out,
							b.id_grlxxmh_customer id_relasi_m,
							b.id_iimxxmh,
							b.id_iumxxmh_unit,
							b.id_iumxxmh_terkecil,
							b.id_iumxxmh_default,
							CONCAT("booking dekit wkdxxth_", b.id) AS keterangan,
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
							220,
							g.movement_type,
							curdate(),
							0,
							iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
							iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
							iumxxmh_default.kode AS iumxxmh_default_kode,
							iumxxmh_default.nama AS iumxxmh_default_nama,
							-b.jumlah_unit,
							b.jumlah_konversi,
							-b.jumlah_terkecil,
							-b.jumlah_default,
							iv.expired_date,
							iv.batch_number

						FROM wkdxxth b
						LEFT JOIN grlxxmh c ON c.id = b.id_grlxxmh_customer
						LEFT JOIN iimxxmh d ON d.id = b.id_iimxxmh
						LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = b.id_iumxxmh_unit
						LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = b.id_iumxxmh_terkecil
						LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = b.id_iumxxmh_default
						LEFT JOIN wloxxmh f ON f.id = b.id_wloxxmh_out
						LEFT JOIN iwhxxmh e ON e.id = f.id_iwhxxmh
						LEFT JOIN imtxxmh g ON g.kode = 220
						LEFT JOIN gbrxxmh h ON h.id = e.id_gbrxxmh
						LEFT JOIN iivxxrd iv ON iv.wlpxxmh_kode = b.wlpxxmh_kode_kitting AND iv.id_wloxxmh = b.id_wloxxmh_out
						WHERE b.id = :id
			');
		})
		->on('preEdit',function( $editor, $id, $values ) {
		
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			$qd_iiv_booking = $editor->db()
				->query('delete', 'iivxxrd')
				->where('keterangan',"booking dekit wkdxxth_".$id)
				->exec();
				
			$qi_iivxxrd_head = $editor->db()
				->raw()
				->bind(':id', $id)
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
							b.id AS id_transaksi_h,
							b.id AS id_transaksi_d,
							f.id_wloctmh,
							b.kode,
							b.wlpxxmh_kode_kitting,
							f.id_iwhxxmh,
							b.id_wloxxmh_out,
							b.id_grlxxmh_customer id_relasi_m,
							b.id_iimxxmh,
							b.id_iumxxmh_unit,
							b.id_iumxxmh_terkecil,
							b.id_iumxxmh_default,
							CONCAT("booking dekit wkdxxth_", b.id) AS keterangan,
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
							220,
							g.movement_type,
							curdate(),
							0,
							iumxxmh_terkecil.kode AS iumxxmh_terkecil_kode,
							iumxxmh_terkecil.nama AS iumxxmh_terkecil_nama,
							iumxxmh_default.kode AS iumxxmh_default_kode,
							iumxxmh_default.nama AS iumxxmh_default_nama,
							-b.jumlah_unit,
							b.jumlah_konversi,
							-b.jumlah_terkecil,
							-b.jumlah_default,
							iv.expired_date,
							iv.batch_number

						FROM wkdxxth b
						LEFT JOIN grlxxmh c ON c.id = b.id_grlxxmh_customer
						LEFT JOIN iimxxmh d ON d.id = b.id_iimxxmh
						LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = b.id_iumxxmh_unit
						LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = b.id_iumxxmh_terkecil
						LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = b.id_iumxxmh_default
						LEFT JOIN wloxxmh f ON f.id = b.id_wloxxmh_out
						LEFT JOIN iwhxxmh e ON e.id = f.id_iwhxxmh
						LEFT JOIN imtxxmh g ON g.kode = 220
						LEFT JOIN gbrxxmh h ON h.id = e.id_gbrxxmh
						LEFT JOIN iivxxrd iv ON iv.wlpxxmh_kode = b.wlpxxmh_kode_kitting AND iv.id_wloxxmh = b.id_wloxxmh_out
						WHERE b.id = :id
			');
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>