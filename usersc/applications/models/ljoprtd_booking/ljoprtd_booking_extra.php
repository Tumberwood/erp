<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// ambil id max
			$qs_ljoxxth = $editor->db()
				->query('select', 'ljoxxth' )
				->get([
					'ljoxxth.id as id_ljoxxth'
				] )
				->order('ljoxxth.id DESC')
				->limit(1)
				->exec();
			$rs_ljoxxth = $qs_ljoxxth->fetch();
			$new_id = $rs_ljoxxth['id_ljoxxth'] + 1;

			$editor
				->field( 'ljoxxth.id' )
				->setValue( $new_id );

			$editor
				->field( 'ljoprtd.id_ljoxxth' )
				->setValue( $new_id );


		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// BEGIN update tanggaljam_start dan tanggaljam_finish
			// Jika create, tanggaljam_start dan tanggaljam_finish diambilkan dari berapa lama user input form
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