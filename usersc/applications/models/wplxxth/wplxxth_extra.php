<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			//insert tabel detail item
			$qs_relasi = $editor->db()
				->query('select', 'wdoxxth_wplxxth' )
				->get(['id_wdoxxth'] )
				->where('id_wplxxth', $id )
				->exec();
			$rs_relasi = $qs_relasi->fetchAll();
			// Extract IDs from the result set
			$ids_wdo = array_column($rs_relasi, 'id_wdoxxth');
	
			// Format as comma-separated list
			$ids_wdoxxth = implode(',', $ids_wdo);
	
			// Wrap in parentheses
			$ids_wdoxxth = $ids_wdoxxth ? "($ids_wdoxxth)" : '';

			$qs_item_d = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('INSERT INTO wplittd (
							id_wplxxth,
							id_grlxxmh_customer,
							wdoxxth_kode,
							id_wdoittd,
							id_iimxxmh,
							id_iumxxmh_unit,
							id_iumxxmh_terkecil,
							id_iumxxmh_default,
							jumlah_unit,
							jumlah_unit_next,
							jumlah_unit_os,
							jumlah_terkecil,
							jumlah_terkecil_next,
							jumlah_terkecil_os,
							jumlah_default,
							jumlah_konversi
						)
						SELECT
							:id,
							b.id_grlxxmh_customer,
							b.kode,
							a.id,
							a.id_iimxxmh,
							a.id_iumxxmh_unit,
							a.id_iumxxmh_terkecil,
							a.id_iumxxmh_default,
							a.jumlah_unit_os,
							0,
							jumlah_unit_os,
							jumlah_terkecil_os,
							0,
							jumlah_terkecil_os,
							jumlah_terkecil_os / (f.jumlah_konversi) AS jumlah_default,
							a.jumlah_konversi
						FROM wdoittd a
						LEFT JOIN wdoxxth b on b.id = a.id_wdoxxth
						LEFT JOIN iimummd f ON f.id_iimxxmh = a.id_iimxxmh AND f.is_default = 1 -- UoM Default
						WHERE a.id_wdoxxth IN '.$ids_wdoxxth.' AND jumlah_terkecil_os > 0
				'
			);

			$qu_os_defore = $editor->db()
				->raw()
				->exec('UPDATE wdoittd a
						SET
							jumlah_unit_next = jumlah_unit_next + jumlah_unit_os,
							jumlah_unit_os = 0,
							jumlah_terkecil_next = jumlah_terkecil_next + jumlah_terkecil_os,
							jumlah_terkecil_os = 0
						WHERE a.id_wdoxxth IN '.$ids_wdoxxth.' AND jumlah_terkecil_os > 0
				'
			);
		})
		->on('preEdit',function( $editor, $id, $values ) {
			$qs_relasi = $editor->db()
				->query('select', 'wdoxxth_wplxxth' )
				->get(['id_wdoxxth'] )
				->where('id_wplxxth', $id )
				->exec();
			$rs_relasi = $qs_relasi->fetchAll();
			$ids_wdo = array_column($rs_relasi, 'id_wdoxxth');
	
			$ids_wdoxxth_old = implode(',', $ids_wdo);
			$ids_wdoxxth_old = $ids_wdoxxth_old ? "($ids_wdoxxth_old)" : '';
			// print_r(' /ids_wdoxxth_old = '.$ids_wdoxxth_old);
			
			$id_wdoxxth_input = $values['wdoxxth'];
			$id_wdoxxth_new = array_column($id_wdoxxth_input, 'id');
			$id_wdoxxth_new = '(' . implode(',', $id_wdoxxth_new) . ')';
			// print_r(' /id_wdoxxth_new = '.$id_wdoxxth_new);

			if ($ids_wdoxxth_old != $id_wdoxxth_new) {
				$qs_pld = $editor->db()
				->query('select', 'wplittd' )
					->get([
						'id_wdoittd',
						'jumlah_terkecil',
						'jumlah_unit'
					] )
					->where('id_wplxxth', $id )
					->exec();
				$rs_pld = $qs_pld->fetchAll();

				if (!empty($rs_pld)) {
					foreach ($rs_pld as $key => $item_d) {
						$id_wdoittd = $item_d['id_wdoittd'];
						$jumlah_terkecil = $item_d['jumlah_terkecil'];
						$jumlah_unit = $item_d['jumlah_unit'];
		
						$qu_wdo = $editor->db()
							->raw()
							->bind(':id_wdoittd', $id_wdoittd)
							->bind(':jumlah_terkecil', $jumlah_terkecil)
							->bind(':jumlah_unit', $jumlah_unit)
							->exec('UPDATE wdoittd
									SET
										jumlah_terkecil_os = jumlah_terkecil_os + :jumlah_terkecil,
										jumlah_terkecil_next = jumlah_terkecil_next - :jumlah_terkecil,
										jumlah_unit_os = jumlah_unit_os + :jumlah_unit,
										jumlah_unit_next = jumlah_unit_next - :jumlah_unit
									WHERE id = :id_wdoittd'
						);
		
						
					}
				}
				//kalau DO diganti, maka hapus dulu detail itemnya
				$qd_item_old = $editor->db()
					->query('delete', 'wplittd')
					->where('id_wplxxth',$id)
					->exec();

				//insert tabel detail item
				$qs_item_d = $editor->db()
					->raw()
					->bind(':id', $id)
					->exec('INSERT INTO wplittd (
								id_wplxxth,
								id_grlxxmh_customer,
								wdoxxth_kode,
								id_wdoittd,
								id_iimxxmh,
								id_iumxxmh_unit,
								id_iumxxmh_terkecil,
								id_iumxxmh_default,
								jumlah_unit,
								jumlah_unit_next,
								jumlah_unit_os,
								jumlah_terkecil,
								jumlah_terkecil_next,
								jumlah_terkecil_os,
								jumlah_default,
								jumlah_konversi
							)
							SELECT
								:id,
								b.id_grlxxmh_customer,
								b.kode,
								a.id,
								a.id_iimxxmh,
								a.id_iumxxmh_unit,
								a.id_iumxxmh_terkecil,
								a.id_iumxxmh_default,
								a.jumlah_unit_os,
								0,
								jumlah_unit_os,
								jumlah_terkecil_os,
								0,
								jumlah_terkecil_os,
								jumlah_terkecil_os / (f.jumlah_konversi) AS jumlah_default,
								a.jumlah_konversi
							FROM wdoittd a
							LEFT JOIN wdoxxth b on b.id = a.id_wdoxxth
							LEFT JOIN iimummd f ON f.id_iimxxmh = a.id_iimxxmh AND f.is_default = 1 -- UoM Default
							WHERE a.id_wdoxxth IN '.$id_wdoxxth_new.' AND jumlah_terkecil_os > 0
					'
				);

				$qu_os_defore = $editor->db()
					->raw()
					->exec('UPDATE wdoittd a
							SET
								jumlah_unit_next = jumlah_unit_next + jumlah_unit_os,
								jumlah_unit_os = 0,
								jumlah_terkecil_next = jumlah_terkecil_next + jumlah_terkecil_os,
								jumlah_terkecil_os = 0
							WHERE a.id_wdoxxth IN '.$id_wdoxxth_new.' AND jumlah_terkecil_os > 0
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