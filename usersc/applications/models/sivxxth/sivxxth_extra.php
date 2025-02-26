<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
			$id_sdlxxth = $values['sivxxth']['id_sdlxxth'];
			
			$qs_sivittd = $editor->db()
				->raw()
				->bind(':id_sdlxxth', $id_sdlxxth)
				->bind(':id', $id)
				->exec('INSERT INTO sivittd (
							id_sivxxth,
							id_sdlittd,
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
						FROM sdlittd a
						WHERE a.id_sdlxxth = :id_sdlxxth
				'
				);

				$qu_os_before = $editor->db()
				->raw()
				->bind(':id_sdlxxth', $id_sdlxxth)
				->exec('UPDATE sdlittd a
						SET
							jumlah_unit_next = jumlah_unit_next + jumlah_unit_os,
							jumlah_unit_os = 0,
							jumlah_terkecil_next = jumlah_terkecil_next + jumlah_terkecil_os,
							jumlah_terkecil_os = 0
						WHERE a.id_sdlxxth = :id_sdlxxth AND jumlah_terkecil_os > 0
				'
			);

			$qs_sdlxxth = $editor->db()
				->query('select', 'sdlxxth' )
				->get([
					'sdlxxth.subtotal as subtotal',
					'sdlxxth.diskon_jenis as diskon_jenis',
					'sdlxxth.diskon_value as diskon_value',
					'sdlxxth.diskon_persen as diskon_persen',
					'sdlxxth.diskon_final as diskon_final',
					'sdlxxth.dpp as dpp',
					'sdlxxth.dpp_final as dpp_final',
					'sodxxth.id_iitxxmh as id_iitxxmh',
					'sdlxxth.is_pajak as is_pajak',
					'sdlxxth.pajak_jenis as pajak_jenis',
					'sdlxxth.pajak_in_ex as pajak_in_ex',
					'sdlxxth.pajak_persen as pajak_persen',
					'sdlxxth.pajak_final as pajak_final',
					'sdlxxth.grand_total as grand_total'
				] )
				->join('sodxxth','sodxxth.id = sdlxxth.id_sodxxth','LEFT' )
				->where('sdlxxth.id', $id_sdlxxth )
				->exec();
			$rs_sdlxxth = $qs_sdlxxth->fetch();

			$qu_sivxxth = $editor->db()
				->query('update', 'sivxxth')
				->set('subtotal',$rs_sdlxxth['subtotal'])
				->set('diskon_jenis',$rs_sdlxxth['diskon_jenis'])
				->set('diskon_value',$rs_sdlxxth['diskon_value'])
				->set('diskon_persen',$rs_sdlxxth['diskon_persen'])
				->set('diskon_final',$rs_sdlxxth['diskon_final'])
				->set('dpp',$rs_sdlxxth['dpp'])
				->set('dpp_final',$rs_sdlxxth['dpp_final'])
				->set('id_iitxxmh',$rs_sdlxxth['id_iitxxmh'])
				->set('is_pajak',$rs_sdlxxth['is_pajak'])
				->set('pajak_jenis',$rs_sdlxxth['pajak_jenis'])
				->set('pajak_in_ex',$rs_sdlxxth['pajak_in_ex'])
				->set('pajak_persen',$rs_sdlxxth['pajak_persen'])
				->set('pajak_final',$rs_sdlxxth['pajak_final'])
				->set('grand_total',$rs_sdlxxth['grand_total'])
				->where('id',$id)
				->exec();
		
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
			$id_sdlxxth_baru = $values['sivxxth']['id_sdlxxth'];

			$qs_lama = $editor->db()
				->query('select', 'sivxxth' )
				->get(['id_sdlxxth'] )
				->where('id', $id )
				->exec();
			$rs_lama = $qs_lama->fetch();

			$id_sdlxxth_lama = $rs_lama['id_sdlxxth'];

			//cek apakah sama dengan sdl yang lama setelah edit sekarang ini, jika tidak sama
			if ($id_sdlxxth_baru != $id_sdlxxth_lama) {
				$qs_pld = $editor->db()
				->query('select', 'sivittd' )
					->get([
						'id_sdlittd',
						'jumlah_terkecil',
						'jumlah_unit'
					] )
					->where('id_sivxxth', $id )
					->exec();
				$rs_pld = $qs_pld->fetchAll();

				if (!empty($rs_pld)) {
					foreach ($rs_pld as $key => $item_d) {
						$id_sdlittd = $item_d['id_sdlittd'];
						$jumlah_terkecil = $item_d['jumlah_terkecil'];
						$jumlah_unit = $item_d['jumlah_unit'];
		
						//kembalikan jumlah outstanding nya sesuai kalkulasi dengan detail
						$qu_sdl = $editor->db()
							->raw()
							->bind(':id_sdlittd', $id_sdlittd)
							->bind(':jumlah_terkecil', $jumlah_terkecil)
							->bind(':jumlah_unit', $jumlah_unit)
							->exec('UPDATE sdlittd
									SET
										jumlah_terkecil_os = jumlah_terkecil_os + :jumlah_terkecil,
										jumlah_terkecil_next = jumlah_terkecil_next - :jumlah_terkecil,
										jumlah_unit_os = jumlah_unit_os + :jumlah_unit,
										jumlah_unit_next = jumlah_unit_next - :jumlah_unit
									WHERE id = :id_sdlittd'
						);
		
						
					}
				}
				
				//hapus item lama
				$qd_item_old = $editor->db()
					->query('delete', 'sivittd')
					->where('id_sivxxth',$id)
				->exec();

				//insert item baru sesuai sdl sekarang
				$qs_sivittd = $editor->db()
					->raw()
					->bind(':id_sdlxxth', $id_sdlxxth_baru)
					->bind(':id', $id)
					->exec('INSERT INTO sivittd (
								id_sivxxth,
								id_sdlittd,
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
							FROM sdlittd a
							WHERE a.id_sdlxxth = :id_sdlxxth
					'
					);

					$qu_os_before = $editor->db()
					->raw()
					->bind(':id_sdlxxth', $id_sdlxxth_baru)
					->exec('UPDATE sdlittd a
							SET
								jumlah_unit_next = jumlah_unit_next + jumlah_unit_os,
								jumlah_unit_os = 0,
								jumlah_terkecil_next = jumlah_terkecil_next + jumlah_terkecil_os,
								jumlah_terkecil_os = 0
							WHERE a.id_sdlxxth = :id_sdlxxth AND jumlah_terkecil_os > 0
					'
				);
				
				$qs_sdlxxth = $editor->db()
					->query('select', 'sdlxxth' )
					->get([
						'subtotal',
						'diskon_jenis',
						'diskon_value',
						'diskon_persen',
						'diskon_final',
						'dpp',
						'dpp_final',
						'id_iitxxmh',
						'is_pajak',
						'pajak_jenis',
						'pajak_in_ex',
						'pajak_persen',
						'pajak_final',
						'grand_total'
					] )
					->where('id', $id_sdlxxth )
					->exec();
				$rs_sdlxxth = $qs_sdlxxth->fetch();

				$qu_sivxxth = $editor->db()
					->query('update', 'sivxxth')
					->set('subtotal',$rs_sdlxxth['subtotal'])
					->set('diskon_jenis',$rs_sdlxxth['diskon_jenis'])
					->set('diskon_value',$rs_sdlxxth['diskon_value'])
					->set('diskon_persen',$rs_sdlxxth['diskon_persen'])
					->set('diskon_final',$rs_sdlxxth['diskon_final'])
					->set('dpp',$rs_sdlxxth['dpp'])
					->set('dpp_final',$rs_sdlxxth['dpp_final'])
					->set('id_iitxxmh',$rs_sdlxxth['id_iitxxmh'])
					->set('is_pajak',$rs_sdlxxth['is_pajak'])
					->set('pajak_jenis',$rs_sdlxxth['pajak_jenis'])
					->set('pajak_in_ex',$rs_sdlxxth['pajak_in_ex'])
					->set('pajak_persen',$rs_sdlxxth['pajak_persen'])
					->set('pajak_final',$rs_sdlxxth['pajak_final'])
					->set('grand_total',$rs_sdlxxth['grand_total'])
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