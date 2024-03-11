<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// BEGIN isNextProcess
			if( $values['iimummd']['id_iumxxmh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iumxxmh', 'iimummd', $id, 'CREATE' );
			}
			// END isNextProcess
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// BEGIN isNextProcess
			if( $values['iimummd']['id_iumxxmh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iumxxmh', 'iimummd', $id, 'EDIT' );
			}
			// END isNextProcess
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// BEGIN isNextProcess
			if( $values['iimummd']['id_iumxxmh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iumxxmh', 'iimummd', $id, 'REMOVE' );
			}
			// END isNextProcess
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>