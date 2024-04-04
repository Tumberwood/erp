<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini			
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// BEGIN update tanggaljam_start dan tanggaljam_finish
			// Jika create, tanggaljam_start dan tanggaljam_finish diambilkan dari berapa lama user input form
			$qr__blank = $db
				->raw()
				->bind(':variable1', variable1)
				->bind(':variable2', variable2)
				->exec('
				
				');

			$qu_ljoprtd = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('
					UPDATE ljoprtd a
					INNER JOIN ljoprtd b ON b.id = a.id
					SET
						a.tanggaljam_start = b.start_at,
						a.tanggaljam_finish = b.finish_at
					WHERE
						a.id =:id
				');
			// END update tanggaljam_start dan tanggaljam_finish

			// BEGIN update durasi
			$qu_ljoprtd = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('
					UPDATE ljoprtd a
					INNER JOIN ljoprtd b ON b.id = a.id
					SET
						a.durasi_detik = TIMESTAMPDIFF(SECOND, b.tanggaljam_start, b.tanggaljam_finish )
					WHERE
						a.id =:id
				');
			// END update durasi
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// BEGIN update tanggaljam_finish
			// Jika edit, hanya tanggaljam_finish yamg diedit
			// diambilkan dari berapa lama user input form
			$qu_ljoprtd = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('
					UPDATE ljoprtd a
					INNER JOIN ljoprtd b ON b.id = a.id
					SET
						a.tanggaljam_finish = b.finish_at
					WHERE
						a.id =:id
				');
			// END update tanggaljam_finish

			// BEGIN update durasi
			$qu_ljoprtd = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('
					UPDATE ljoprtd a
					INNER JOIN ljoprtd b ON b.id = a.id
					SET
						a.durasi_detik = TIMESTAMPDIFF(SECOND, b.tanggaljam_start, b.tanggaljam_finish )
					WHERE
						a.id =:id
				');
			// END update durasi

			
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>