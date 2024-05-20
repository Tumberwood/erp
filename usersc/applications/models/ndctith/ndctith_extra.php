<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			$id_ndoxxth = $values['ndixxth']['id_ndoxxth'];
			$qi_ndidctd = $editor->db()
				->raw()
				->bind(':id_ndoxxth', $id_ndoxxth)
				->exec('
					INSERT INTO
						ndidctd (
							id_ndixxth,
							id_ndcrctd
						)
					SELECT
						'.$id.',
						id_ndcrctd
					FROM ndodctd
					WHERE 1
						AND id_ndoxxth = :id_ndoxxth
				');

			$qu_ndoxxth = $editor->db()
				->query('update', 'ndoxxth')
				->set('is_nextprocess', 1 )
				->where('id ', $id_ndoxxth )
				->exec();

		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>