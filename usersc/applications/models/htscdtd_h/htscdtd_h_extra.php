<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {

			//SELECT TANGGAL TERPILIH / LIBUR
			$qs_section = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec(' SELECT
							id_hodxxmh
						FROM hodxxmh_htscdtd_h AS a
						WHERE a.id_htscdtd_h = :id;
						'
						);
			$rs_section = $qs_section->fetchAll();
			
			$tanggal_terpilih =  date('Y-m-d', strtotime($values['htscdtd_h']['tanggal_terpilih']));
			$tanggal_pengganti =  date('Y-m-d', strtotime($values['htscdtd_h']['tanggal_pengganti']));
			
			foreach ($rs_section as $key => $section) {
				$id_hodxxmh = $section['id_hodxxmh'];

				//INSERT PEGAWAI SESUAI SECTION TANGGAL PENGGANTI 27 Dec 2023
				$qs_pengganti = $editor->db()
					->raw()
					->bind(':tanggal', $tanggal_pengganti)
					->bind(':id_hodxxmh', $id_hodxxmh)
					->bind(':id', $id)
					->exec(' INSERT INTO htscdtd_peg
							(
								id_htscdtd_h,
								id_hemxxmh
							)  
							SELECT
								:id,
								a.id_hemxxmh
							FROM htssctd AS a
							LEFT JOIN hemjbmh as b on b.id_hemxxmh = a.id_hemxxmh
							LEFT JOIN hemxxmh as c on c.id = a.id_hemxxmh
							WHERE a.tanggal = :tanggal 
								AND TIME(a.tanggaljam_awal) <> "00:00:00" 
								AND a.transaction_state = 1
								AND b.id_hodxxmh = :id_hodxxmh
								-- AND c.is_tukar = 1
								;
							'
				);
			}
		})
		->on('preEdit',function( $editor, $id, $values ) {

		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			
			$tanggal_terpilih =  date('Y-m-d', strtotime($values['htscdtd_h']['tanggal_terpilih']));
			$tanggal_pengganti =  date('Y-m-d', strtotime($values['htscdtd_h']['tanggal_pengganti']));

			$qd_htscdtd_peg = $editor->db()
				->query('delete', 'htscdtd_peg')
				->where('id_htscdtd_h',$id)
				->exec();
			
			$qs_section = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec(' SELECT
							id_hodxxmh
						FROM hodxxmh_htscdtd_h AS a
						WHERE a.id_htscdtd_h = :id;
						'
						);
			$rs_section = $qs_section->fetchAll();
			foreach ($rs_section as $key => $section) {
				$id_hodxxmh = $section['id_hodxxmh'];

				//INSERT PEGAWAI SESUAI SECTION TANGGAL PENGGANTI 27 Dec 2023
				$qs_pengganti = $editor->db()
					->raw()
					->bind(':tanggal', $tanggal_pengganti)
					->bind(':id_hodxxmh', $id_hodxxmh)
					->bind(':id', $id)
					->exec(' INSERT INTO htscdtd_peg
							(
								id_htscdtd_h,
								id_hemxxmh
							)  
							SELECT
								:id,
								a.id_hemxxmh
							FROM htssctd AS a
							LEFT JOIN hemjbmh as b on b.id_hemxxmh = a.id_hemxxmh
							LEFT JOIN hemxxmh as c on c.id = a.id_hemxxmh
							WHERE a.tanggal = :tanggal 
								AND TIME(a.tanggaljam_awal) <> "00:00:00" 
								AND a.transaction_state = 1
								AND b.id_hodxxmh = :id_hodxxmh
								-- AND c.is_tukar = 1
								;
							'
				);
			}
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>