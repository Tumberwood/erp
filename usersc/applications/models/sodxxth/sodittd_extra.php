<?php
	use 
		SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			General::isNextProcess( $editor->db(), 'sqtxxth', 'sqtittd', 'sodittd', $id, 'CREATE', $values);
			General::konversiUom( $editor->db(), 'sodittd', $id );
			General::kalkulasiJumlahTransaksiBefore( $editor->db(), $id, $values, 'Create', 'sodittd', 'sqtittd' );
		})
		->on('preEdit',function( $editor, $id, $values ) {
			General::isNextProcess( $editor->db(), 'sqtxxth', 'sqtittd', 'sodittd', $id, 'EDIT', $values );
			General::kalkulasiJumlahTransaksiBefore( $editor->db(), $id, $values, 'Edit', 'sodittd', 'sqtittd' );
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			
		})
		->on('preRemove',function( $editor, $id, $values ) {
			
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>