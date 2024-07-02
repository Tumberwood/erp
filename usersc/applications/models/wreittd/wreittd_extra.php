<?php

	use
        SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row )  use ($nama_table, $nama_table_before) {
			General::isNextProcess( $editor->db(), '', 'wlpxxmh', 'wreittd', $id, 'CREATE', $values );
			include('wreittd_fn_konversi_terkecil.php');
		})
		->on('preEdit',function( $editor, $id, $values ) {
			General::isNextProcess( $editor->db(), '', 'wlpxxmh', 'wreittd', $id, 'EDIT', $values );
		})
		->on('postEdit',function( $editor, $id, $values, $row )  use ($nama_table, $nama_table_before) {
			include('wreittd_fn_konversi_terkecil.php');
		})
		->on('preRemove',function( $editor, $id, $values ) {
			General::isNextProcess( $editor->db(), '', 'wlpxxmh', 'wreittd', $id, 'REMOVE', $values );
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>