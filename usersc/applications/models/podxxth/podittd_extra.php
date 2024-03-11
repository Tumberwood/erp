<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			isNextProcess( $editor->db(), 'prqxxth', 'prqittd', 'podittd', $id, 'CREATE', $values);
		})
		->on('preEdit',function( $editor, $id, $values ) {
			isNextProcess( $editor->db(), 'prqxxth', 'prqittd', 'podittd', $id, 'EDIT', $values );
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
		})
		->on('preRemove',function( $editor, $id, $values ) {
			isNextProcess( $editor->db(), 'prqxxth', 'prqittd', 'podittd', $id, 'REMOVE', $values );
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>