<?php

	use 
		SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			General::konversiUom( $editor->db(), 'prcittd', $id );
			General::kalkulasiJumlahTransaksiBefore( $editor->db(), $id, $values, 'Create', 'prcittd', 'podittd' );
		})
		->on('preEdit',function( $editor, $id, $values ) {
			General::kalkulasiJumlahTransaksiBefore( $editor->db(), $id, $values, 'Edit', 'prcittd', 'podittd' );
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			General::konversiUom( $editor->db(), 'prcittd', $id );
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>