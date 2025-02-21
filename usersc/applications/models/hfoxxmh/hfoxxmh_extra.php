<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// $hfoxxmh_parents = $values['hfoxxmh_parents'];
			// print_r($values['hfoxxmh_parents']);
			// foreach ($hfoxxmh_parents as $key => $parent) {
			// 	$qi_hfoxxmh_parents = $editor->db()
			// 		->query('insert', 'hfoxxmh_parents')
			// 		->set('id_hfoxxmh',$id)
			// 		->set('id_hfoxxmh_parents',$parent['id'])
			// 		->exec();
			// }
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// $hfoxxmh_parents = $values['hfoxxmh_parents'];
			// print_r($hfoxxmh_parents);
			// $qd_hfoxxmh_parents = $editor->db()
			// 	->query('delete', 'hfoxxmh_parents')
			// 	->where('id_hfoxxmh',$id)
			// 	->exec();

			// foreach ($hfoxxmh_parents as $key => $parent) {
			// 	$qi_hfoxxmh_parents = $editor->db()
			// 		->query('insert', 'hfoxxmh_parents')
			// 		->set('id_hfoxxmh',$id)
			// 		->set('id_hfoxxmh_parents',$parent['id'])
			// 		->exec();
			// }
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