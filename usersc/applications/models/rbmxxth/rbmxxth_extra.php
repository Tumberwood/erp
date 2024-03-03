<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			if($values['is_revisi'] == 1){
				$id_rbmxxth_asal = $values['rbmxxth']['id_rbmxxth_asal'];
				// duplicate detail
				$qi_rbmittd = $editor->db()
					->raw()
					->bind(':id_rbmxxth_asal', $id_rbmxxth_asal)
					->exec('
						INSERT INTO
							rbmittd (
								id_rbmxxth,
								id_iimxxmh,
								id_iumxxmh_unit,
								id_iumxxmh_terkecil,
								id_iumxxmh_default,
								jumlah_unit,
								jumlah_unit_os,
								jumlah_terkecil,
								jumlah_terkecil_os,
								jumlah_default,
								jumlah_konversi
							)
						SELECT
							'.$id.',
							id_iimxxmh,
							id_iumxxmh_unit,
							id_iumxxmh_terkecil,
							id_iumxxmh_default,
							jumlah_unit,
							jumlah_unit_os,
							jumlah_terkecil,
							jumlah_terkecil_os,
							jumlah_default,
							jumlah_konversi
						FROM rbmittd
						WHERE
							id_rbmxxth = :id_rbmxxth_asal
					');

				$qi_rbmwptd = $editor->db()
					->raw()
					->bind(':id_rbmxxth_asal', $id_rbmxxth_asal)
					->exec('
						INSERT INTO
							rbmwptd (
								id_rbmxxth,
								id_rwpxxmh,
								cycletime
							)
						SELECT
							'.$id.',
							id_rwpxxmh,
							cycletime
						FROM rbmwptd
						WHERE
							id_rbmxxth = :id_rbmxxth_asal
					');
					
			}
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
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