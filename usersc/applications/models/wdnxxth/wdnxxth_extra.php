<?php

	use 
		SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			$id_wdoxxth = $values['wdnxxth']['id_wdoxxth'];
			
			//insert detail LPN DN
			$qi_item_lpn_d = $editor->db()
				->raw()
				->bind(':id', $id)
				->bind(':id_wdoxxth', $id_wdoxxth)
				->exec('INSERT INTO wdnlptd (
							id_wdnxxth,
							id_wdoittd,
							kode,
							id_wdplptd,
							id_iimxxmh,
							id_iumxxmh_unit,
							id_iumxxmh_terkecil,
							id_iumxxmh_default,
							jumlah_unit,
							jumlah_terkecil,
							jumlah_terkecil_next,
							jumlah_terkecil_os,
							jumlah_default,
							jumlah_konversi,
							batch_number,
							expired_date,
							wlpxxmh_kode
						)
						SELECT
							:id,
							a.id AS id_wdoittd,
							a.kode,
							b.id AS id_wdplptd,
							a.id_iimxxmh,
							a.id_iumxxmh_unit,
							b.id_iumxxmh_terkecil,
							b.id_iumxxmh_default,
							b.jumlah_terkecil_os / u.jumlah_konversi AS jumlah_unit,
							b.jumlah_terkecil_os AS jumlah_terkecil,
							0,
							b.jumlah_terkecil_os,
							b.jumlah_terkecil_os / d.jumlah_konversi AS jumlah_default,
							d.jumlah_konversi,
							b.batch_number,
							b.expired_date,
							b.wlpxxmh_kode
						FROM wdplptd b
						LEFT JOIN wdoittd a ON a.id = b.id_wdoittd
						LEFT JOIN iimummd d ON d.id_iimxxmh = a.id_iimxxmh AND d.is_default = 1 -- UoM Default
						LEFT JOIN iimummd u ON u.id_iimxxmh = a.id_iimxxmh AND u.id_iumxxmh = a.id_iumxxmh_unit
						WHERE a.id_wdoxxth = :id_wdoxxth AND b.id_wdpxxth <> 0
						HAVING jumlah_terkecil > 0
				'
			);
			
			//insert detaiil item DN
			$qi_item_d = $editor->db()
				->raw()
				->bind(':id', $id)
				->bind(':id_wdoxxth', $id_wdoxxth)
				->exec('INSERT INTO wdnittd (
							id_wdnxxth,
							id_iwhxxmh,
							id_wloxxmh,
							id_wdoittd,
							id_iimxxmh,
							id_iumxxmh_unit,
							id_iumxxmh_terkecil,
							id_iumxxmh_default,
							jumlah_unit,
							jumlah_terkecil,
							jumlah_default,
							jumlah_konversi
						)
						SELECT
							:id,
							b.id_iwhxxmh,
							b.id_wloxxmh_tujuan,
							a.id AS id_wdoittd,
							a.id_iimxxmh,
							a.id_iumxxmh_unit,
							a.id_iumxxmh_terkecil,
							a.id_iumxxmh_default,
							SUM(ifnull(b.jumlah_terkecil_os,0) / u.jumlah_konversi) AS jumlah_unit,
							SUM(ifnull(b.jumlah_terkecil_os,0)) AS jumlah_terkecil,
							SUM(ifnull(b.jumlah_terkecil_os,0) / d.jumlah_konversi) AS jumlah_default,
							d.jumlah_konversi
						FROM wdoittd a
						LEFT JOIN wdplptd b ON b.id_wdoittd = a.id
						LEFT JOIN iimummd d ON d.id_iimxxmh = a.id_iimxxmh AND d.is_default = 1 -- UoM Default
						LEFT JOIN iimummd u ON u.id_iimxxmh = a.id_iimxxmh AND u.id_iumxxmh = a.id_iumxxmh_unit
						WHERE a.id_wdoxxth = :id_wdoxxth AND b.id_wdpxxth <> 0
						GROUP BY a.id_iimxxmh
						HAVING jumlah_terkecil > 0;
				'
			);

			$qs_dispatch = $editor->db()
				->raw()
				->bind(':id', $id)
				->bind(':id_wdoxxth', $id_wdoxxth)
				->exec('SELECT
							:id AS id_wdnxxth,
							a.id AS id_wdoittd,
							b.id AS id_wdplptd,
							a.id_iimxxmh,
							a.id_iumxxmh_unit,
							b.id_iumxxmh_terkecil,
							b.id_iumxxmh_default,
							b.jumlah_terkecil_os / u.jumlah_konversi AS jumlah_unit,
							b.jumlah_terkecil_os AS jumlah_terkecil,
							0 jumlah_terkecil_next,
							b.jumlah_terkecil_os,
							b.jumlah_terkecil_os / d.jumlah_konversi AS jumlah_default,
							d.jumlah_konversi,
							b.batch_number,
							b.expired_date,
							b.wlpxxmh_kode
						FROM wdplptd b
						LEFT JOIN wdoittd a ON a.id = b.id_wdoittd
						LEFT JOIN iimummd d ON d.id_iimxxmh = a.id_iimxxmh AND d.is_default = 1 -- UoM Default
						LEFT JOIN iimummd u ON u.id_iimxxmh = a.id_iimxxmh AND u.id_iumxxmh = a.id_iumxxmh_unit
						WHERE a.id_wdoxxth = :id_wdoxxth AND b.id_wdpxxth <> 0
						HAVING jumlah_terkecil > 0
				'
			);
			$rs_dispatch = $qs_dispatch->fetchAll();

			foreach ($rs_dispatch as $key => $dispatch) {
				$id_wdplptd = $dispatch['id_wdplptd'];

				$qu_os_defore = $editor->db()
					->raw()
					->bind(':id_wdplptd', $id_wdplptd)
					->exec('UPDATE wdplptd a
							SET
								jumlah_terkecil_next = jumlah_terkecil_next + jumlah_terkecil_os,
								jumlah_terkecil_os = 0
							WHERE a.id = :id_wdplptd
					'
				);
			}
			
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
							iwh.kode AS iwhxxmh_kode,
							iwh.nama AS iwhxxmh_nama,
							wlo.kode AS wloxxmh_kode,
							wlo.nama AS wloxxmh_nama,
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
						WHERE a.id_wdnxxth = :id;
				'
			);

		})
		->on('preEdit',function( $editor, $id, $values ) {
			// cek apakah DO nya diedit
			$qs_old = $editor->db()
				->query('select', 'wdnxxth' )
				->get(['id_wdoxxth'] )
				->where('id', $id )
				->exec();
			$rs_old = $qs_old->fetch();

			$id_wdoxxth_old = $rs_old['id_wdoxxth'];
			$id_wdoxxth_new = $values['wdnxxth']['id_wdoxxth'];

			if ($id_wdoxxth_old != $id_wdoxxth_new) {
				$qs_pld = $editor->db()
				->query('select', 'wdnlptd' )
					->get([
						'id_wdplptd',
						'jumlah_terkecil',
					] )
					->where('id_wdnxxth', $id )
					->exec();
				$rs_pld = $qs_pld->fetchAll();

				if (!empty($rs_pld)) {
					foreach ($rs_pld as $key => $item_d) {
						$id_wdplptd = $item_d['id_wdplptd'];
						$jumlah_terkecil = $item_d['jumlah_terkecil'];
		
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
		
						
					}
				}
				//kalau DO diganti, maka hapus dulu detail itemnya
				$qd_dispatch_old = $editor->db()
					->query('delete', 'wdnlptd')
					->where('id_wdnxxth',$id)
					->exec();

				$qd_item_old = $editor->db()
					->query('delete', 'wdnittd')
					->where('id_wdnxxth',$id)
					->exec();

				$qd_booking_old = $editor->db()
					->query('delete', 'iivxxrd')
					->where('keterangan','id_wdnxxth='.$id)
					->where('is_fisik',0)
					->exec();

				//insert detail LPN DN
				$qi_item_lpn_d = $editor->db()
					->raw()
					->bind(':id', $id)
					->bind(':id_wdoxxth', $id_wdoxxth_new)
					->exec('INSERT INTO wdnlptd (
								id_wdnxxth,
								id_wdoittd,
								kode,
								id_wdplptd,
								id_iimxxmh,
								id_iumxxmh_unit,
								id_iumxxmh_terkecil,
								id_iumxxmh_default,
								jumlah_unit,
								jumlah_terkecil,
								jumlah_terkecil_next,
								jumlah_terkecil_os,
								jumlah_default,
								jumlah_konversi,
								batch_number,
								expired_date,
								wlpxxmh_kode
							)
							SELECT
								:id,
								a.id AS id_wdoittd,
								a.kode,
								b.id AS id_wdplptd,
								a.id_iimxxmh,
								a.id_iumxxmh_unit,
								b.id_iumxxmh_terkecil,
								b.id_iumxxmh_default,
								b.jumlah_terkecil_os / u.jumlah_konversi AS jumlah_unit,
								b.jumlah_terkecil_os AS jumlah_terkecil,
								0,
								b.jumlah_terkecil_os,
								b.jumlah_terkecil_os / d.jumlah_konversi AS jumlah_default,
								d.jumlah_konversi,
								b.batch_number,
								b.expired_date,
								b.wlpxxmh_kode
							FROM wdplptd b
							LEFT JOIN wdoittd a ON a.id = b.id_wdoittd
							LEFT JOIN iimummd d ON d.id_iimxxmh = a.id_iimxxmh AND d.is_default = 1 -- UoM Default
							LEFT JOIN iimummd u ON u.id_iimxxmh = a.id_iimxxmh AND u.id_iumxxmh = a.id_iumxxmh_unit
							WHERE a.id_wdoxxth = :id_wdoxxth AND b.id_wdpxxth <> 0
							HAVING jumlah_terkecil > 0
					'
				);
				
				//insert detaiil item DN
				$qi_item_d = $editor->db()
					->raw()
					->bind(':id', $id)
					->bind(':id_wdoxxth', $id_wdoxxth_new)
					->exec('INSERT INTO wdnittd (
								id_wdnxxth,
								id_iwhxxmh,
								id_wloxxmh,
								id_wdoittd,
								id_iimxxmh,
								id_iumxxmh_unit,
								id_iumxxmh_terkecil,
								id_iumxxmh_default,
								jumlah_unit,
								jumlah_terkecil,
								jumlah_default,
								jumlah_konversi
							)
							SELECT
								:id,
								b.id_iwhxxmh,
								b.id_wloxxmh_tujuan,
								a.id AS id_wdoittd,
								a.id_iimxxmh,
								a.id_iumxxmh_unit,
								a.id_iumxxmh_terkecil,
								a.id_iumxxmh_default,
								SUM(ifnull(b.jumlah_terkecil_os,0) / u.jumlah_konversi) AS jumlah_unit,
								SUM(ifnull(b.jumlah_terkecil_os,0)) AS jumlah_terkecil,
								SUM(ifnull(b.jumlah_terkecil_os,0) / d.jumlah_konversi) AS jumlah_default,
								d.jumlah_konversi
							FROM wdoittd a
							LEFT JOIN wdplptd b ON b.id_wdoittd = a.id
							LEFT JOIN iimummd d ON d.id_iimxxmh = a.id_iimxxmh AND d.is_default = 1 -- UoM Default
							LEFT JOIN iimummd u ON u.id_iimxxmh = a.id_iimxxmh AND u.id_iumxxmh = a.id_iumxxmh_unit
							WHERE a.id_wdoxxth = :id_wdoxxth AND b.id_wdpxxth <> 0
							GROUP BY a.id_iimxxmh
							HAVING jumlah_terkecil > 0;
					'
				);
	
				$qs_dispatch = $editor->db()
					->raw()
					->bind(':id', $id)
					->bind(':id_wdoxxth', $id_wdoxxth_new)
					->exec('SELECT
								:id AS id_wdnxxth,
								a.id AS id_wdoittd,
								b.id AS id_wdplptd,
								a.id_iimxxmh,
								a.id_iumxxmh_unit,
								b.id_iumxxmh_terkecil,
								b.id_iumxxmh_default,
								b.jumlah_terkecil_os / u.jumlah_konversi AS jumlah_unit,
								b.jumlah_terkecil_os AS jumlah_terkecil,
								0 jumlah_terkecil_next,
								b.jumlah_terkecil_os,
								b.jumlah_terkecil_os / d.jumlah_konversi AS jumlah_default,
								d.jumlah_konversi,
								b.batch_number,
								b.expired_date,
								b.wlpxxmh_kode
							FROM wdplptd b
							LEFT JOIN wdoittd a ON a.id = b.id_wdoittd
							LEFT JOIN iimummd d ON d.id_iimxxmh = a.id_iimxxmh AND d.is_default = 1 -- UoM Default
							LEFT JOIN iimummd u ON u.id_iimxxmh = a.id_iimxxmh AND u.id_iumxxmh = a.id_iumxxmh_unit
							WHERE a.id_wdoxxth = :id_wdoxxth AND b.id_wdpxxth <> 0
							HAVING jumlah_terkecil > 0
					'
				);
				$rs_dispatch = $qs_dispatch->fetchAll();
	
				foreach ($rs_dispatch as $key => $dispatch) {
					$id_wdplptd = $dispatch['id_wdplptd'];
	
					$qu_os_defore = $editor->db()
						->raw()
						->bind(':id_wdplptd', $id_wdplptd)
						->exec('UPDATE wdplptd a
								SET
									jumlah_terkecil_next = jumlah_terkecil_next + jumlah_terkecil_os,
									jumlah_terkecil_os = 0
								WHERE a.id = :id_wdplptd
						'
					);
				}

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
								iwh.kode AS iwhxxmh_kode,
								iwh.nama AS iwhxxmh_nama,
								wlo.kode AS wloxxmh_kode,
								wlo.nama AS wloxxmh_nama,
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
							WHERE a.id_wdnxxth = :id;
					'
				);
			}
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>