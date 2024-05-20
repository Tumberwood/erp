<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			if($values['is_revisi'] == 1){
				$id_dbmxxth_asal = $values['dbmxxth']['id_dbmxxth_asal'];
				// duplicate detail
				$qi_dbmittd = $editor->db()
					->raw()
					->bind(':id_dbmxxth_asal', $id_dbmxxth_asal)
					->exec('
						INSERT INTO
							dbmittd (
								id_dbmxxth,
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
						FROM dbmittd
						WHERE
							id_dbmxxth = :id_dbmxxth_asal
					');

				$qi_dbmwptd = $editor->db()
					->raw()
					->bind(':id_dbmxxth_asal', $id_dbmxxth_asal)
					->exec('
						INSERT INTO
							dbmwptd (
								id_dbmxxth,
								id_rwpxxmh,
								cycletime
							)
						SELECT
							'.$id.',
							id_rwpxxmh,
							cycletime
						FROM dbmwptd
						WHERE
							id_dbmxxth = :id_dbmxxth_asal
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