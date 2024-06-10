<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			$id_ndctoth = $values['ndctith']['id_ndctoth'];
			$qi_ndctitd = $editor->db()
				->raw()
				->bind(':id_ndctoth', $id_ndctoth)
				->exec('
					INSERT INTO
						ndctitd (
							id_ndctith,
							id_ndcxxmh
						)
					SELECT
						'.$id.',
						id_ndcxxmh
					FROM ndctotd
					WHERE 1
						AND id_ndctoth = :id_ndctoth
				');

			$qu_ndctoth = $editor->db()
				->query('update', 'ndctoth')
				->set('is_nextprocess', 1 )
				->where('id ', $id_ndctoth )
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