<?php

	function update_id_lprxxmh_last($db, $id_lprxxmh, $id_ljoxxth){
		// update ljoxxth.id_lprxxmh_last
		$qu_ljoxxth = $db
			->query('update', 'ljoxxth')
			->set('id_lprxxmh_last', $id_lprxxmh )
			->where('id', $id_ljoxxth )
			->exec();
	}

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			update_id_lprxxmh_last($editor->db(), $values['ljoprtd']['id_lprxxmh'], $values['ljoprtd']['id_ljoxxth'] );
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			update_id_lprxxmh_last($editor->db(), $values['ljoprtd']['id_lprxxmh'], $values['ljoprtd']['id_ljoxxth'] );
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>