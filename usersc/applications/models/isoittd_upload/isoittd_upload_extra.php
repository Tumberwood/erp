<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) use ($s_id_users, $s_username) {
			$fisik = $values['isoittd_upload']['fisik'];

			$qi_fisik = $editor->db()
				->query('insert', 'isoittd_upload_fisik')
				->set('fisik',$fisik)
				->set('id_isoittd_upload',$id)
				->exec();
				
			$qu_header = $editor->db()
				->query('update', 'isoittd_upload')
				->set('selisih',$fisik)
				->where('id',$id)
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