<?php

	use 
		SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			General::konversiUom( $editor->db(), 'sodittd', $id );
			// General::kalkulasiJumlahTransaksiBefore( $editor->db(), $id, $values, 'Create', 'sodittd', 'sqtittd' );
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// General::kalkulasiJumlahTransaksiBefore( $editor->db(), $id, $values, 'Create', 'sodittd', 'sqtittd' );
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			General::konversiUom( $editor->db(), 'sodittd', $id );
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>