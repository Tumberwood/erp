<?php

	use 
		SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			$id_wdoxxth = $values['wdnxxth']['id_wdoxxth'];
			
			$qs_item_d = $editor->db()
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
			
			$qs_item_d = $editor->db()
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

				$qs_item_d = $editor->db()
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
				
				$qs_item_d = $editor->db()
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