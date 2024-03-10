<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			isNextProcess( $editor->db(), 'prqxxth', 'prqittd', $id, 'CREATE' );
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			isNextProcess( $editor->db(), 'prqxxth', 'prqittd', $id, 'EDIT' );
		})
		->on('preRemove',function( $editor, $id, $values ) {
			isNextProcess( $editor->db(), 'prqxxth', 'prqittd', $id, 'REMOVE' );
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>