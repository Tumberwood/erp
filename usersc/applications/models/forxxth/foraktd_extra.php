<?php
	// function hitung_sum_header($t_header, $t_detail, $f_header, $f_detail){
	function hitung_sum_header($values){
		global $editor;

		$qs_foraktd = $editor->db()
			->raw()
			->bind(':id_forxxth', $values['foraktd']['id_forxxth'])
			->exec('
				SELECT
					SUM(amount) as s_amount
				FROM foraktd
				WHERE 
					id_forxxth = :id_forxxth
			');
		$rs_foraktd = $qs_foraktd->fetch();

		$qu_forxxth = $editor->db()
			->raw()
			->bind(':s_amount', $rs_foraktd['s_amount'])
			->bind(':id_forxxth', $values['foraktd']['id_forxxth'])
			->exec('
				UPDATE forxxth
				SET amount = :s_amount
				WHERE id = :id_forxxth
			');

	}

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			hitung_sum_header($values);
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			hitung_sum_header($values);
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>