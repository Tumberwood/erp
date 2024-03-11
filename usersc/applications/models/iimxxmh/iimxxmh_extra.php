<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// BEGIN isNextProcess
			if( $values['iimxxmh']['id_iigxxmh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iigxxmh', 'iimxxmh', $id, 'CREATE' );
			}
			if( $values['iimxxmh']['id_iigx2mh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iigx2mh', 'iimxxmh', $id, 'CREATE' );
			}
			if( $values['iimxxmh']['id_iibxxmh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iibxxmh', 'iimxxmh', $id, 'CREATE' );
			}
			// END isNextProcess
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// BEGIN isNextProcess
			if( $values['iimxxmh']['id_iigxxmh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iigxxmh', 'iimxxmh', $id, 'EDIT' );
			}
			if( $values['iimxxmh']['id_iigx2mh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iigx2mh', 'iimxxmh', $id, 'EDIT' );
			}
			if( $values['iimxxmh']['id_iibxxmh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iibxxmh', 'iimxxmh', $id, 'EDIT' );
			}
			// END isNextProcess
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// BEGIN isNextProcess
			if( $values['iimxxmh']['id_iigxxmh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iigxxmh', 'iimxxmh', $id, 'REMOVE' );
			}
			if( $values['iimxxmh']['id_iigx2mh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iigx2mh', 'iimxxmh', $id, 'REMOVE' );
			}
			if( $values['iimxxmh']['id_iibxxmh'] > 0 ){
				isNextProcess( $editor->db(), '', 'iibxxmh', 'iimxxmh', $id, 'REMOVE' );
			}
			// END isNextProcess
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>