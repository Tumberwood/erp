<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			isNextProcess( $editor->db(), 'prqxxth', 'prqittd', 'podittd', $id, 'CREATE' );
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			isNextProcess( $editor->db(), 'prqxxth', 'prqittd', 'podittd', $id, 'EDIT' );
		})
		->on('preRemove',function( $editor, $id, $values ) {
			isNextProcess( $editor->db(), 'prqxxth', 'prqittd', 'podittd', $id, 'REMOVE' );
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>