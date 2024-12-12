<?php
	use 
	SolusiIndonesia\Utilities\General;
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row )  use ($nama_table, $nama_table_before) {
			$qs_backdate = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('SELECT
							b.is_backdate,
							a.id_wktittd
						FROM wktlptd a
						LEFT JOIN wktxxth b on b.id = a.id_wktxxth
						WHERE a.id = :id
			');
			
			$rs_backdate = $qs_backdate->fetch();
			$is_backdate = $rs_backdate['is_backdate'];
			$id_wktittd = $rs_backdate['id_wktittd'];
			
			// if ($is_backdate == 1) {
				General::konversiUom($editor->db(), $nama_table, $id);

				//Booking Plus sesuai jumlah finalisasi, lawan Confirm Picking item Kitting
				$qi_iivxxrd_det = $editor->db()
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
								a.id_wktxxth AS id_transaksi_h,
								a.id AS id_transaksi_d,
								f.id_wloctmh,
								a.kode AS kode,
								a.wlpxxmh_kode,
								a.id_iwhxxmh,
								a.id_wloxxmh,
								b.id_grlxxmh_customer id_relasi_m,
								a.id_iimxxmh,
								a.id_iumxxmh_unit,
								a.id_iumxxmh_terkecil,
								a.id_iumxxmh_default,
								CONCAT("wktxxth_id_", a.id_wktxxth) AS keterangan,
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
								
								-a.jumlah_unit jumlah_unit_iiv,
								a.jumlah_konversi,
								-a.jumlah_terkecil jumlah_terkecil_iiv,
								-a.jumlah_default jumlah_default_iiv,
								
								a.expired_date,
								a.batch_number

							FROM wktlptd a
							LEFT JOIN wktittd b ON b.id = a.id_wktittd
							LEFT JOIN grlxxmh c ON c.id = b.id_grlxxmh_customer
							LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
							LEFT JOIN iwhxxmh e ON e.id = a.id_iwhxxmh
							LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = a.id_iumxxmh_unit
							LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
							LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
							LEFT JOIN wloxxmh f ON f.id = a.id_wloxxmh
							LEFT JOIN imtxxmh g ON g.kode = 219
							LEFT JOIN gbrxxmh h ON h.id = e.id_gbrxxmh
							LEFT JOIN iimummd j ON j.id_iimxxmh = a.id_iimxxmh AND j.is_default = 1
							WHERE a.id = :id
				');

				//Update subtotal detail items
				$qu_wktittd = $editor->db()
					->raw()
					->bind(':id_wktittd', $id_wktittd)
					->exec('UPDATE wktittd a
							LEFT JOIN (
								SELECT
									id_wktittd,
									SUM(a.jumlah_unit) subtotal_jumlah_unit,
									SUM(a.jumlah_terkecil) subtotal_jumlah_terkecil,
									SUM(a.jumlah_default) subtotal_jumlah_default
								FROM wktlptd a
								WHERE a.id_wktittd = :id_wktittd
							) z on z.id_wktittd = :id_wktittd
							SET 
								a.subtotal_jumlah_terkecil = z.subtotal_jumlah_terkecil,
								a.subtotal_jumlah_default = z.subtotal_jumlah_default,
								a.subtotal_jumlah_unit = z.subtotal_jumlah_unit
							WHERE a.id = :id_wktittd
							;
					
					'
				);
			// }
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row )  use ($nama_table, $nama_table_before) {
			$qs_backdate = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('SELECT
							b.is_backdate,
							b.id_wktxxth,
							a.id_wktittd
						FROM wktlptd a
						LEFT JOIN wktxxth b on b.id = a.id_wktxxth
						WHERE a.id = :id
			');
			
			$rs_backdate = $qs_backdate->fetch();
			$is_backdate = $rs_backdate['is_backdate'];
			$id_wktxxth = $rs_backdate['id_wktxxth'];
			$id_wktittd = $rs_backdate['id_wktittd'];
			
			if ($is_backdate == 1) {
				General::konversiUom($editor->db(), $nama_table, $id);

				$qd_iivxxrd = $editor->db()
					->query('delete', 'iivxxrd')
					->where('id_transaksi_d',$id)
					->where('keterangan','wktxxth_id_' .$id_wktxxth)
				->exec();

				//Booking Plus sesuai jumlah finalisasi, lawan Confirm Picking item Kitting
				$qi_iivxxrd_det = $editor->db()
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
								a.id_wktxxth AS id_transaksi_h,
								a.id AS id_transaksi_d,
								f.id_wloctmh,
								a.kode AS kode,
								a.wlpxxmh_kode,
								a.id_iwhxxmh,
								a.id_wloxxmh,
								b.id_grlxxmh_customer id_relasi_m,
								a.id_iimxxmh,
								a.id_iumxxmh_unit,
								a.id_iumxxmh_terkecil,
								a.id_iumxxmh_default,
								CONCAT("wktxxth_id_", a.id_wktxxth) AS keterangan,
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
								
								-a.jumlah_unit jumlah_unit_iiv,
								a.jumlah_konversi,
								-a.jumlah_terkecil jumlah_terkecil_iiv,
								-a.jumlah_default jumlah_default_iiv,
								
								a.expired_date,
								a.batch_number

							FROM wktlptd a
							LEFT JOIN wktittd b ON b.id = a.id_wktittd
							LEFT JOIN grlxxmh c ON c.id = b.id_grlxxmh_customer
							LEFT JOIN iimxxmh d ON d.id = a.id_iimxxmh
							LEFT JOIN iwhxxmh e ON e.id = a.id_iwhxxmh
							LEFT JOIN iumxxmh iumxxmh_unit ON iumxxmh_unit.id = a.id_iumxxmh_unit
							LEFT JOIN iumxxmh iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
							LEFT JOIN iumxxmh iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
							LEFT JOIN wloxxmh f ON f.id = a.id_wloxxmh
							LEFT JOIN imtxxmh g ON g.kode = 219
							LEFT JOIN gbrxxmh h ON h.id = e.id_gbrxxmh
							LEFT JOIN iimummd j ON j.id_iimxxmh = a.id_iimxxmh AND j.is_default = 1
							WHERE a.id = :id
				');

				//Update subtotal detail items
				$qu_wktittd = $editor->db()
					->raw()
					->bind(':id_wktittd', $id_wktittd)
					->exec('UPDATE wktittd a
							LEFT JOIN (
								SELECT
									id_wktittd,
									SUM(a.jumlah_unit) subtotal_jumlah_unit,
									SUM(a.jumlah_terkecil) subtotal_jumlah_terkecil,
									SUM(a.jumlah_default) subtotal_jumlah_default
								FROM wktlptd a
								WHERE a.id_wktittd = :id_wktittd
							) z on z.id_wktittd = :id_wktittd
							SET 
								a.subtotal_jumlah_terkecil = z.subtotal_jumlah_terkecil,
								a.subtotal_jumlah_default = z.subtotal_jumlah_default,
								a.subtotal_jumlah_unit = z.subtotal_jumlah_unit
							WHERE a.id = :id_wktittd
							;
					
					'
				);
			}
		})
		->on('preRemove',function( $editor, $id, $values ) {
			$qs_backdate = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('SELECT
							b.is_backdate,
							id_wktxxth,
							a.id_wktittd
						FROM wktlptd a
						LEFT JOIN wktxxth b on b.id = a.id_wktxxth
						WHERE a.id = :id
			');
			
			$rs_backdate = $qs_backdate->fetch();
			$id_wktxxth = $rs_backdate['id_wktxxth'];
			$id_wktittd = $rs_backdate['id_wktittd'];

			$qd_iivxxrd = $editor->db()
				->query('delete', 'iivxxrd')
				->where('id_transaksi_d',$id)
				->where('keterangan','wktxxth_id_' .$id_wktxxth)
				->exec();
			
			//Update subtotal detail items
			$qu_wktittd = $editor->db()
				->raw()
				->bind(':id_wktittd', $id_wktittd)
				->bind(':id', $id)
				->exec('UPDATE wktittd a
						LEFT JOIN (
							SELECT
								id_wktittd,
								SUM(a.jumlah_unit) subtotal_jumlah_unit,
								SUM(a.jumlah_terkecil) subtotal_jumlah_terkecil,
								SUM(a.jumlah_default) subtotal_jumlah_default
							FROM wktlptd a
							WHERE a.id_wktittd = :id_wktittd AND a.id <> :id
						) z on z.id_wktittd = :id_wktittd
						SET 
							a.subtotal_jumlah_terkecil = IFNULL(z.subtotal_jumlah_terkecil, 0),
							a.subtotal_jumlah_default = IFNULL(z.subtotal_jumlah_default, 0),
							a.subtotal_jumlah_unit = IFNULL(z.subtotal_jumlah_unit, 0)
						WHERE a.id = :id_wktittd
						;
				'
			);
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>