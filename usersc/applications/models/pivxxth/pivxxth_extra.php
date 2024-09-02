<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
			$id_prcxxth = $values['pivxxth']['id_prcxxth'];
			
			$qs_pivittd = $editor->db()
				->raw()
				->bind(':id_prcxxth', $id_prcxxth)
				->bind(':id', $id)
				->exec('INSERT INTO pivittd (
							id_pivxxth,
							id_prcittd,
							id_iimxxmh,
							id_iumxxmh_unit,
							id_iumxxmh_terkecil,
							id_iumxxmh_default,
							jumlah_unit,
							jumlah_konversi,
							jumlah_terkecil,
							jumlah_default,
							harga_unit,
							subtotal,
							diskon_jenis,
							diskon_persen,
							diskon_value,
							diskon_final,
							dpp
						)
						SELECT
							:id,
							a.id,
							a.id_iimxxmh,
							a.id_iumxxmh_unit,
							a.id_iumxxmh_terkecil,
							a.id_iumxxmh_default,
							a.jumlah_unit_os,
							a.jumlah_konversi,
							a.jumlah_terkecil_os,
							a.jumlah_default_os,
							a.harga_unit,
							a.subtotal,
							a.diskon_jenis,
							a.diskon_persen,
							a.diskon_value,
							a.diskon_final,
							a.dpp
						FROM prcittd a
						WHERE a.id_prcxxth = :id_prcxxth
				'
				);

				$qu_os_before = $editor->db()
				->raw()
				->bind(':id_prcxxth', $id_prcxxth)
				->exec('UPDATE prcittd a
						SET
							jumlah_unit_next = jumlah_unit_next + jumlah_unit_os,
							jumlah_unit_os = 0,
							jumlah_terkecil_next = jumlah_terkecil_next + jumlah_terkecil_os,
							jumlah_terkecil_os = 0
						WHERE a.id_prcxxth = :id_prcxxth AND jumlah_terkecil_os > 0
				'
			);

			$qs_prcxxth = $editor->db()
				->query('select', 'prcxxth' )
				->get([
					'dpp_final',
					'id_iitxxmh',
					'is_pajak',
					'pajak_jenis',
					'pajak_in_ex',
					'pajak_persen',
					'pajak_final',
					'grand_total'
				] )
				->where('id', $id_prcxxth )
				->exec();
			$rs_prcxxth = $qs_prcxxth->fetch();

			$qu_pivxxth = $editor->db()
				->query('update', 'pivxxth')
				->set('dpp_final',$rs_prcxxth['dpp_final'])
				->set('id_iitxxmh',$rs_prcxxth['id_iitxxmh'])
				->set('is_pajak',$rs_prcxxth['is_pajak'])
				->set('pajak_jenis',$rs_prcxxth['pajak_jenis'])
				->set('pajak_in_ex',$rs_prcxxth['pajak_in_ex'])
				->set('pajak_persen',$rs_prcxxth['pajak_persen'])
				->set('pajak_final',$rs_prcxxth['pajak_final'])
				->set('grand_total',$rs_prcxxth['grand_total'])
				->where('id',$id)
				->exec();
		
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
			$id_prcxxth_baru = $values['pivxxth']['id_prcxxth'];

			$qs_lama = $editor->db()
				->query('select', 'pivxxth' )
				->get(['id_prcxxth'] )
				->where('id', $id )
				->exec();
			$rs_lama = $qs_lama->fetch();

			$id_prcxxth_lama = $rs_lama['id_prcxxth'];

			//cek apakah sama dengan prc yang lama setelah edit sekarang ini, jika tidak sama
			if ($id_prcxxth_baru != $id_prcxxth_lama) {
				$qs_pld = $editor->db()
				->query('select', 'pivittd' )
					->get([
						'id_prcittd',
						'jumlah_terkecil',
						'jumlah_unit'
					] )
					->where('id_pivxxth', $id )
					->exec();
				$rs_pld = $qs_pld->fetchAll();

				if (!empty($rs_pld)) {
					foreach ($rs_pld as $key => $item_d) {
						$id_prcittd = $item_d['id_prcittd'];
						$jumlah_terkecil = $item_d['jumlah_terkecil'];
						$jumlah_unit = $item_d['jumlah_unit'];
		
						//kembalikan jumlah outstanding nya sesuai kalkulasi dengan detail
						$qu_prc = $editor->db()
							->raw()
							->bind(':id_prcittd', $id_prcittd)
							->bind(':jumlah_terkecil', $jumlah_terkecil)
							->bind(':jumlah_unit', $jumlah_unit)
							->exec('UPDATE prcittd
									SET
										jumlah_terkecil_os = jumlah_terkecil_os + :jumlah_terkecil,
										jumlah_terkecil_next = jumlah_terkecil_next - :jumlah_terkecil,
										jumlah_unit_os = jumlah_unit_os + :jumlah_unit,
										jumlah_unit_next = jumlah_unit_next - :jumlah_unit
									WHERE id = :id_prcittd'
						);
		
						
					}
				}
				
				//hapus item lama
				$qd_item_old = $editor->db()
					->query('delete', 'pivittd')
					->where('id_pivxxth',$id)
				->exec();

				//insert item baru sesuai prc sekarang
				$qs_pivittd = $editor->db()
					->raw()
					->bind(':id_prcxxth', $id_prcxxth_baru)
					->bind(':id', $id)
					->exec('INSERT INTO pivittd (
								id_pivxxth,
								id_prcittd,
								id_iimxxmh,
								id_iumxxmh_unit,
								id_iumxxmh_terkecil,
								id_iumxxmh_default,
								jumlah_unit,
								jumlah_konversi,
								jumlah_terkecil,
								jumlah_default,
								harga_unit,
								subtotal,
								diskon_jenis,
								diskon_persen,
								diskon_value,
								diskon_final,
								dpp
							)
							SELECT
								:id,
								a.id,
								a.id_iimxxmh,
								a.id_iumxxmh_unit,
								a.id_iumxxmh_terkecil,
								a.id_iumxxmh_default,
								a.jumlah_unit_os,
								a.jumlah_konversi,
								a.jumlah_terkecil_os,
								a.jumlah_default_os,
								a.harga_unit,
								a.subtotal,
								a.diskon_jenis,
								a.diskon_persen,
								a.diskon_value,
								a.diskon_final,
								a.dpp
							FROM prcittd a
							WHERE a.id_prcxxth = :id_prcxxth
					'
					);

					$qu_os_before = $editor->db()
					->raw()
					->bind(':id_prcxxth', $id_prcxxth_baru)
					->exec('UPDATE prcittd a
							SET
								jumlah_unit_next = jumlah_unit_next + jumlah_unit_os,
								jumlah_unit_os = 0,
								jumlah_terkecil_next = jumlah_terkecil_next + jumlah_terkecil_os,
								jumlah_terkecil_os = 0
							WHERE a.id_prcxxth = :id_prcxxth AND jumlah_terkecil_os > 0
					'
				);
				
				$qs_prcxxth = $editor->db()
					->query('select', 'prcxxth' )
					->get([
						'dpp_final',
						'id_iitxxmh',
						'is_pajak',
						'pajak_jenis',
						'pajak_in_ex',
						'pajak_persen',
						'pajak_final',
						'grand_total'
					] )
					->where('id', $id_prcxxth )
					->exec();
				$rs_prcxxth = $qs_prcxxth->fetch();

				$qu_pivxxth = $editor->db()
					->query('update', 'pivxxth')
					->set('dpp_final',$rs_prcxxth['dpp_final'])
					->set('id_iitxxmh',$rs_prcxxth['id_iitxxmh'])
					->set('is_pajak',$rs_prcxxth['is_pajak'])
					->set('pajak_jenis',$rs_prcxxth['pajak_jenis'])
					->set('pajak_in_ex',$rs_prcxxth['pajak_in_ex'])
					->set('pajak_persen',$rs_prcxxth['pajak_persen'])
					->set('pajak_final',$rs_prcxxth['pajak_final'])
					->set('grand_total',$rs_prcxxth['grand_total'])
					->where('id',$id)
					->exec();
		
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