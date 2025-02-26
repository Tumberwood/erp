<?php

	use 
		SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			General::konversiUom( $editor->db(), 'sdlittd', $id );
			$id_sodittd = $values['sdlittd']['id_sodittd'];
			$id_scsittd = $values['sdlittd']['id_scsittd'];

			//jika konsinyasi, maka perhitungan dengan id_scsittd
			if ($id_scsittd > 0) {
				General::kalkulasiJumlahTransaksiBefore2( $editor->db(), $id, $values, 'Create', 'sdlittd', 'scsittd' );
			} else {
				if ($id_sodittd > 0) {
					General::kalkulasiJumlahTransaksiBefore2( $editor->db(), $id, $values, 'Create', 'sdlittd', 'sodittd' );
				}
			}
		})
		->on('preEdit',function( $editor, $id, $values ) {
			$id_sodittd = $values['sdlittd']['id_sodittd'];
			$id_scsittd = $values['sdlittd']['id_scsittd'];

			if ($id_scsittd > 0) {
				General::kalkulasiJumlahTransaksiBefore2( $editor->db(), $id, $values, 'Edit', 'sdlittd', 'scsittd' );
			} else {
				if ($id_sodittd > 0) {
					General::kalkulasiJumlahTransaksiBefore2( $editor->db(), $id, $values, 'Edit', 'sdlittd', 'sodittd' );
				}
			}
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			General::konversiUom( $editor->db(), 'sdlittd', $id );
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>