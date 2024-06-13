<?php
	use 
	SolusiIndonesia\Utilities\General;

	$editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			General::konversiUom( $editor->db(), 'itiittd', $id );
			General::kalkulasiJumlahTransaksiBefore( $editor->db(), $id, $values, 'Create', 'itiittd', 'itoittd' );
		})
		->on('preEdit',function( $editor, $id, $values ) {
			General::kalkulasiJumlahTransaksiBefore( $editor->db(), $id, $values, 'Edit', 'itiittd', 'itoittd' );
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			General::konversiUom( $editor->db(), 'itiittd', $id );
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});


//     $editor
// 		->on('preCreate',function( $editor, $values ) {
// 			// script diletakkan disini
// 		})
// 		->on('postCreate',function( $editor, $id, $values, $row ) {
// 			// script diletakkan disini
			
// 			$jumlah_unit = $values['itiittd']['jumlah_unit'];
// 			$id_itixxth = $values['itiittd']['id_itixxth'];
// 			$id_iimxxmh = $values['itiittd']['id_iimxxmh'];
// 			$id_iumxxmh = $values['itiittd']['id_iumxxmh'];
			
// 			//select unit rab dan id_proyek
// 			$s_rab = $editor->db()
// 			->raw()
// 			->bind(':id_itixxth', $id_itixxth)
// 			->bind(':id_iimxxmh', $id_iimxxmh)
// 			->exec(' SELECT
// 						a.id_itoxxth AS id_itoxxth,
// 						b.jumlah_terkecil AS jumlah_terkecil,
// 						b.jumlah_terkecil_next AS jumlah_terkecil_next,
// 						b.id AS id_rab,
// 						c.jumlah_terkecil AS jumlah_input
					
// 					FROM itixxth AS a
// 					LEFT JOIN itoittd AS b ON b.id_itoxxth = a.id_itoxxth
// 					LEFT JOIN (
// 						SELECT 
// 							ROUND(a.jumlah_konversi * '.$jumlah_unit.', 2) AS jumlah_terkecil,
// 							c.nama AS satuan
// 						FROM iimummd AS a
// 						LEFT JOIN iumxxmh AS c ON c.id = '.$id_iumxxmh.'
// 						WHERE a.id_iimxxmh = '.$id_iimxxmh.' AND a.id_iumxxmh = ' .$id_iumxxmh.'
// 					) AS c on c.jumlah_terkecil > 0

// 					WHERE a.id = :id_itixxth AND b.id_iimxxmh = :id_iimxxmh
// 					'
// 					);
// 			$sel_rab = $s_rab->fetch();
		
// 			//Hitung terkecil next
// 			$jumlah_terkecil_next = $sel_rab['jumlah_terkecil_next'] + $sel_rab['jumlah_input'];
// 			//Hitung terkecil OS
// 			$jumlah_terkecil_os = $sel_rab['jumlah_terkecil'] - $jumlah_terkecil_next;
		
// 			//edit rab unit next dan os
// 			$edit_rab = $editor->db()
// 				->query('update', 'itoittd')
// 				->set('jumlah_terkecil_next',$jumlah_terkecil_next)//Baru ditambahkan yang terkecil
// 				->set('jumlah_terkecil_os',$jumlah_terkecil_os)
// 				->where('id', $sel_rab['id_rab'] )
// 				->exec();
// 		})
// 		->on('preEdit',function( $editor, $id, $values ) {
// 			// script diletakkan disini
			
// 			$jumlah_unit = $values['itiittd']['jumlah_unit'];
// 			$id_itixxth = $values['itiittd']['id_itixxth'];
// 			$id_iimxxmh = $values['itiittd']['id_iimxxmh'];
// 			$id_iumxxmh = $values['itiittd']['id_iumxxmh'];
			
// 			//select unit rab dan id_proyek
// 			$s_rab = $editor->db()
// 			->raw()
// 			->bind(':id_itixxth', $id_itixxth)
// 			->bind(':id_iimxxmh', $id_iimxxmh)
// 			->exec(' SELECT
// 						a.id_itoxxth AS id_itoxxth,
// 						b.jumlah_terkecil AS jumlah_terkecil,
// 						b.jumlah_terkecil_next AS jumlah_terkecil_next,
// 						b.id AS id_rab,
// 						c.jumlah_terkecil AS jumlah_input
					
// 					FROM itixxth AS a
// 					LEFT JOIN itoittd AS b ON b.id_itoxxth = a.id_itoxxth
// 					LEFT JOIN (
// 						SELECT 
// 							ROUND(a.jumlah_konversi * '.$jumlah_unit.', 2) AS jumlah_terkecil,
// 							c.nama AS satuan
// 						FROM iimummd AS a
// 						LEFT JOIN iumxxmh AS c ON c.id = '.$id_iumxxmh.'
// 						WHERE a.id_iimxxmh = '.$id_iimxxmh.' AND a.id_iumxxmh = ' .$id_iumxxmh.'
// 					) AS c on c.jumlah_terkecil > 0

// 					WHERE a.id = :id_itixxth AND b.id_iimxxmh = :id_iimxxmh
// 					'
// 					);
// 			$sel_rab = $s_rab->fetch();
		
// 			$s_itiittd_old = $editor->db()
// 			->raw()
// 			->bind(':id', $id)
// 			->exec(' SELECT
// 						a.jumlah_terkecil AS jumlah_terkecil
					
// 					FROM itiittd AS a
// 					WHERE a.id = :id
// 					'
// 					);
// 			$sel_itiittd_old = $s_itiittd_old->fetch();

// 			//Nilai next itiittd dikurangi old value
// 			$jumlah_terkecil_next_old = $sel_rab['jumlah_terkecil_next'] - $sel_itiittd_old['jumlah_terkecil'];

// 			//Hitung terkecil next
// 			$jumlah_terkecil_next = $jumlah_terkecil_next_old + $sel_rab['jumlah_input'];
// 			//Hitung terkecil OS
// 			$jumlah_terkecil_os = $sel_rab['jumlah_terkecil'] - $jumlah_terkecil_next;
		
// 			//edit rab terkecil next dan os
// 			$edit_rab = $editor->db()
// 				->query('update', 'itoittd')
// 				->set('jumlah_terkecil_next',$jumlah_terkecil_next)
// 				->set('jumlah_terkecil_os',$jumlah_terkecil_os)
// 				->where('id', $sel_rab['id_rab'] )
// 				->exec();
// 		})
// 		->on('postEdit',function( $editor, $id, $values, $row ) {
// 			// script diletakkan disini
// 		})
// 		->on('preRemove',function( $editor, $id, $values ) {
// 			// script diletakkan disini
			
// 			$jumlah_unit = $values['itiittd']['jumlah_unit'];
// 			$id_itixxth = $values['itiittd']['id_itixxth'];
// 			$id_iimxxmh = $values['itiittd']['id_iimxxmh'];
// 			$id_iumxxmh = $values['itiittd']['id_iumxxmh'];
			
// 			//select unit rab dan id_proyek
// 			$s_rab = $editor->db()
// 			->raw()
// 			->bind(':id_itixxth', $id_itixxth)
// 			->bind(':id_iimxxmh', $id_iimxxmh)
// 			->exec(' SELECT
// 						a.id_itoxxth AS id_itoxxth,
// 						b.jumlah_terkecil AS jumlah_terkecil,
// 						b.jumlah_terkecil_next AS jumlah_terkecil_next,
// 						b.id AS id_rab,
// 						c.jumlah_terkecil AS jumlah_input
					
// 					FROM itixxth AS a
// 					LEFT JOIN itoittd AS b ON b.id_itoxxth = a.id_itoxxth
// 					LEFT JOIN (
// 						SELECT 
// 							ROUND(a.jumlah_konversi * '.$jumlah_unit.', 2) AS jumlah_terkecil,
// 							c.nama AS satuan
// 						FROM iimummd AS a
// 						LEFT JOIN iumxxmh AS c ON c.id = '.$id_iumxxmh.'
// 						WHERE a.id_iimxxmh = '.$id_iimxxmh.' AND a.id_iumxxmh = ' .$id_iumxxmh.'
// 					) AS c on c.jumlah_terkecil > 0

// 					WHERE a.id = :id_itixxth AND b.id_iimxxmh = :id_iimxxmh
// 					'
// 					);
// 			$sel_rab = $s_rab->fetch();
		
// 			$s_itiittd_old = $editor->db()
// 			->raw()
// 			->bind(':id', $id)
// 			->exec(' SELECT
// 						a.jumlah_terkecil AS jumlah_terkecil
					
// 					FROM itiittd AS a
// 					WHERE a.id = :id
// 					'
// 					);
// 			$sel_itiittd_old = $s_itiittd_old->fetch();

// 			//Nilai next itiittd dikurangi old value
// 			$jumlah_terkecil_next_old = $sel_rab['jumlah_terkecil_next'] - $sel_itiittd_old['jumlah_terkecil'];

// 			//Hitung terkecil next
// 			$jumlah_terkecil_next = $jumlah_terkecil_next_old;
// 			//Hitung terkecil OS
// 			$jumlah_terkecil_os = $sel_rab['jumlah_terkecil'] - $jumlah_terkecil_next;
		
// 			//edit rab terkecil next dan os
// 			$edit_rab = $editor->db()
// 				->query('update', 'itoittd')
// 				->set('jumlah_terkecil_next',$jumlah_terkecil_next)
// 				->set('jumlah_terkecil_os',$jumlah_terkecil_os)
// 				->where('id', $sel_rab['id_rab'] )
// 				->exec();
// 		})
// 		->on('postRemove',function( $editor, $id, $values ) {
// 			// script diletakkan disini
// 		});
?>