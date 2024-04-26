<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
			$id_h = $values['isoittd_upload_fisik']['id_isoittd_upload'];
			$qu_def = $editor->db()
            ->raw()
            ->bind(':id_h', $id_h)
            ->exec('    UPDATE isoittd_upload AS b
                        SET 
                            b.is_skip = 0
                        WHERE b.id = :id_h
        	');
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
			$id_h = $values['isoittd_upload_fisik']['id_isoittd_upload'];
			$qu_def = $editor->db()
            ->raw()
            ->bind(':id_h', $id_h)
            ->exec('    UPDATE isoittd_upload AS b
                        SET 
                            b.is_skip = 0
                        WHERE b.id = :id_h
        	');
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>