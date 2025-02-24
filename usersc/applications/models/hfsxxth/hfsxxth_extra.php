<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			$id_hfkxxth = $values['hfsxxth']['id_hfkxxth'];

			$qi_hfskptd = $editor->db()
				->raw()
				->bind(':id_hfkxxth', $id_hfkxxth)
				->bind(':id_hfsxxth', $id)
				->exec('INSERT INTO hfskptd (
							id_hfsxxth,
							id_hfogrmh,
							id_hfmxxmh,
							id_hfkobtd,
							id_hfoxxmh,
							id_hfoprmh,
							id_iumxxmh,
							polarisasi,
							target_atas,
							target_bawah,
							bobot_persen,
							cara_hitung
						)
						SELECT
							:id_hfsxxth,
							a.id_hfogrmh,
							a.id_hfmxxmh,
							a.id,
							a.id_hfoxxmh,
							a.id_hfoprmh,
							a.id_iumxxmh,
							a.polarisasi,
							a.target_atas,
							a.target_bawah,
							a.bobot_persen,
							a.cara_hitung
						FROM hfkobtd a
						WHERE a.id_hfkxxth = :id_hfkxxth AND a.transaction_state <> -9
			');
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