<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
		})
		->on('preRemove',function( $editor, $id, $values ) {
		

		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>