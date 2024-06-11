<?php
	use 
		SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			General::isNextProcess( $editor->db(), 'prqxxth', 'prqittd', 'podittd', $id, 'CREATE', $values);
			General::konversiUom( $editor->db(), 'podittd', $id );
		})
		->on('preEdit',function( $editor, $id, $values ) {
			General::isNextProcess( $editor->db(), 'prqxxth', 'prqittd', 'podittd', $id, 'EDIT', $values );
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			General::konversiUom( $editor->db(), 'podittd', $id );
		})
		->on('preRemove',function( $editor, $id, $values ) {
			General::isNextProcess( $editor->db(), 'prqxxth', 'prqittd', 'podittd', $id, 'REMOVE', $values );
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>