<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
		})
		->on('preRemove',function( $editor, $id, $values ) {
			/**
			 * Hapus data ucudasd sesuai pages yang dihapus dan permission terpilih
			 */
			$permission_id = $values['permission_page_matches']['permission_id'];
			$page_id = $values['permission_page_matches']['page_id'];
			$qd_ucudasd = $editor->db()
				->raw()
				->bind(':id_pages', $page_id)
				->bind(':permission_id', $permission_id)
				->exec('
					DELETE
					FROM ucudasd
					WHERE ucudasd.id IN (
						SELECT
							a.id
						FROM ucudasd a
						LEFT JOIN udpxxsh b ON b.id = a.id_udpxxsh
						LEFT JOIN user_permission_matches c ON c.user_id = b.id_users
						WHERE 1
							AND a.id_pages = :id_pages
							AND c.permission_id = :permission_id
					)
				');
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>