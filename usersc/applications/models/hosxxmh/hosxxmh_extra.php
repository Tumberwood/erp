<?php

	use 
		SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			General::isNextProcess( $editor->db(), '', 'hodxxmh', 'hosxxmh', $id, 'CREATE', $values );
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			General::isNextProcess( $editor->db(), '', 'hodxxmh', 'hosxxmh', $id, 'EDIT', $values );
		})
		->on('preRemove',function( $editor, $id, $values ) {
			General::isNextProcess( $editor->db(), '', 'hodxxmh', 'hosxxmh', $id, 'REMOVE', $values );
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>