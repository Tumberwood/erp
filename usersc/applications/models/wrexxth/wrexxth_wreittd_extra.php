<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			$id_wreittd = $values['wrexxth_wreittd']['id_wreittd'];

			$qu_wreittd = $editor->db()
				->query('update', 'wreittd')
				->set('is_done_slip',1)
				->where('id',$id_wreittd)
				->exec();
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
		})
		->on('preRemove',function( $editor, $id, $values ) {
			$id_wreittd = $values['wrexxth_wreittd']['id_wreittd'];

			$qu_wreittd = $editor->db()
				->query('update', 'wreittd')
				->set('is_done_slip',0)
				->where('id',$id_wreittd)
				->exec();
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>