<?php
	use 
	SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			//insert tabel detail item
			General::konversiUom($editor->db(), 'wkdlptd', $id);
		})
		->on('preEdit',function( $editor, $id, $values ) {
			
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
			General::konversiUom($editor->db(), 'wkdlptd', $id);
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>