<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// set value
			$editor
				->field( 'ljoprtd.id_lprxxmh' )
				->setValue( 1 );
			$editor
				->field( 'ljoprtd.tanggaljam_start' )
				->setValue( $values['ljoprtd']['start_at'] );
			$editor
				->field( 'ljoprtd.tanggaljam_finish' )
				->setValue( $values['ljoprtd']['finish_at'] );

			$editor
				->field( 'ljoxxth.id_lprxxmh_last' )
				->setValue( 1 );
			
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
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>