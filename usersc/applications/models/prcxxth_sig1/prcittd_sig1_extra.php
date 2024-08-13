<?php

	use 
		SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			General::konversiUom( $editor->db(), 'prcittd_sig1', $id );
			General::konversiBuy( $editor->db(), 'prcittd_sig1', $id );
		})
		->on('preEdit',function( $editor, $id, $values ) {
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			General::konversiUom( $editor->db(), 'prcittd_sig1', $id );
			General::konversiBuy( $editor->db(), 'prcittd_sig1', $id );
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>