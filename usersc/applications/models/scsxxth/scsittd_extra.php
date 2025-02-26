<?php

	use 
		SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			General::konversiUom( $editor->db(), 'scsittd', $id );
			$id_sodittd = $values['scsittd']['id_sodittd'];

			if ($id_sodittd > 0) {
				General::kalkulasiJumlahTransaksiBefore( $editor->db(), $id, $values, 'Create', 'scsittd', 'sodittd' );
			}
		})
		->on('preEdit',function( $editor, $id, $values ) {
			$id_sodittd = $values['scsittd']['id_sodittd'];

			if ($id_sodittd > 0) {
				General::kalkulasiJumlahTransaksiBefore( $editor->db(), $id, $values, 'Edit', 'scsittd', 'sodittd' );
			}
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			General::konversiUom( $editor->db(), 'scsittd', $id );
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>