<?php
	// function hitung_sum_header($t_header, $t_detail, $f_header, $f_detail){
	function hitung_sum_header($values){
		global $editor;

		$qs_fopaktd = $editor->db()
			->raw()
			->bind(':id_fopxxth', $values['fopaktd']['id_fopxxth'])
			->exec('
				SELECT
					SUM(amount) as s_amount
				FROM fopaktd
				WHERE 
					id_fopxxth = :id_fopxxth
			');
		$rs_fopaktd = $qs_fopaktd->fetch();

		$qu_fopxxth = $editor->db()
			->raw()
			->bind(':s_amount', $rs_fopaktd['s_amount'])
			->bind(':id_fopxxth', $values['fopaktd']['id_fopxxth'])
			->exec('
				UPDATE fopxxth
				SET amount = :s_amount
				WHERE id = :id_fopxxth
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