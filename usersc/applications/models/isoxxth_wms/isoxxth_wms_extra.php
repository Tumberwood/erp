<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			$id_iwhxxmh = $values['isoxxth_wms']['id_iwhxxmh'];

			$qu_isoittd_wms = $editor->db()
				->raw()
				->bind(':id', $id)
				->bind(':id_iwhxxmh', $id_iwhxxmh)
				->exec('UPDATE isoittd_wms a
						SET
							a.id_isoxxth_wms = :id
						WHERE a.id_iwhxxmh = :id_iwhxxmh 
						AND a.transaction_state = 0 
						AND a.id_isoxxth_wms = 0
			');
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
		})
		->on('preRemove',function( $editor, $id, $values ) {
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>