<?php

	use
        SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) use ($nama_table) {
			General::konversiUom($editor->db(), $nama_table, $id);
			$wlpxxmh_kode = $values['wptittd']['wlpxxmh_kode'];

			$qs_wreittd = $editor->db()
				->query('select', 'wreittd' )
				->get(['id'] )
				->where('transaction_state', 1 )
				->where('wlpxxmh_kode', $wlpxxmh_kode )
				->exec();
			$rs_wreittd = $qs_wreittd->fetch();
			$id_wreittd = $rs_wreittd['id'];

			$qu_wptittd = $editor->db()
				->query('update', 'wptittd')
				->set('id_wreittd',$id_wreittd)
				->where('id',$id)
				->exec();
				
			General::isNextProcess( $editor->db(), '', 'wreittd', 'wptittd', $id, 'CREATE', $values );
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) use ($nama_table) {
			General::konversiUom($editor->db(), $nama_table, $id);
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>