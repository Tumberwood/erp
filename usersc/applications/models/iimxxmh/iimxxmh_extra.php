<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// BEGIN isNextProcess
			if( $values['iimxxmh']['id_iigxxmh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iigxxmh', 'iimxxmh', $id, 'CREATE', $values );
			}
			if( $values['iimxxmh']['id_iigx2mh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iigx2mh', 'iimxxmh', $id, 'CREATE', $values );
			}
			if( $values['iimxxmh']['id_iibxxmh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iibxxmh', 'iimxxmh', $id, 'CREATE', $values );
			}
			// END isNextProcess
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// BEGIN isNextProcess
			if( $values['iimxxmh']['id_iigxxmh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iigxxmh', 'iimxxmh', $id, 'EDIT', $values );
			}
			if( $values['iimxxmh']['id_iigx2mh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iigx2mh', 'iimxxmh', $id, 'EDIT', $values );
			}
			if( $values['iimxxmh']['id_iibxxmh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iibxxmh', 'iimxxmh', $id, 'EDIT', $values );
			}
			// END isNextProcess
			
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// BEGIN isNextProcess
			if( $values['iimxxmh']['id_iigxxmh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iigxxmh', 'iimxxmh', $id, 'REMOVE', $values );
			}
			if( $values['iimxxmh']['id_iigx2mh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iigx2mh', 'iimxxmh', $id, 'REMOVE', $values );
			}
			if( $values['iimxxmh']['id_iibxxmh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iibxxmh', 'iimxxmh', $id, 'REMOVE', $values );
			}
			// END isNextProcess
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>