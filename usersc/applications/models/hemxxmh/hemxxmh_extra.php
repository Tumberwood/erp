<?php

	use 
		SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// General::isNextProcess( $editor->db(), '', 'hovxxmh', 'hemxxmh', $id, 'CREATE', $values );
			// General::isNextProcess( $editor->db(), '', 'hodxxmh', 'hemxxmh', $id, 'CREATE', $values );
			// General::isNextProcess( $editor->db(), '', 'hosxxmh', 'hemxxmh', $id, 'CREATE', $values );
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// General::isNextProcess( $editor->db(), '', 'hovxxmh', 'hemxxmh', $id, 'EDIT', $values );
			// General::isNextProcess( $editor->db(), '', 'hodxxmh', 'hemxxmh', $id, 'EDIT', $values );
			// General::isNextProcess( $editor->db(), '', 'hosxxmh', 'hemxxmh', $id, 'EDIT', $values );
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// General::isNextProcess( $editor->db(), '', 'hovxxmh', 'hemxxmh', $id, 'REMOVE', $values );
			// General::isNextProcess( $editor->db(), '', 'hodxxmh', 'hemxxmh', $id, 'REMOVE', $values );
			// General::isNextProcess( $editor->db(), '', 'hosxxmh', 'hemxxmh', $id, 'REMOVE', $values );
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>