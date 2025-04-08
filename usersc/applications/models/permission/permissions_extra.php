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
			$qd_user_permission_matches = $editor->db()
				->query('delete', 'user_permission_matches')
				->where('permission_id',$id)
				->exec()
			;

			$qd_permission_page_matches = $editor->db()
				->query('delete', 'permission_page_matches')
				->where('permission_id',$id)
				->exec()
			;
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>