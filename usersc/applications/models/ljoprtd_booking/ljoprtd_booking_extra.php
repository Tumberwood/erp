<?php

	include_once( "../../../../usersc/vendor/autoload.php");
	use 
		Carbon\Carbon;

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

				// ljoprtd.durasi_detik
				$cb_start_at = Carbon::parse($values['ljoprtd']['start_at']);
				$cb_finish_at = Carbon::parse($values['ljoprtd']['finish_at']);
				$durasi_detik = $cb_start_at->diffInSeconds($cb_finish_at);
				
				$editor
					->field( 'ljoprtd.durasi_detik' )
					->setValue( $durasi_detik );

			$editor
				->field( 'ljoxxth.id_lprxxmh_last' )
				->setValue( 1 );
			
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
			$editor
				->field( 'ljoprtd.tanggaljam_finish' )
				->setValue( $values['ljoprtd']['finish_at'] );

				// ljoprtd.durasi_detik
				$cb_start_at = Carbon::parse($values['ljoprtd']['start_at']);
				$cb_finish_at = Carbon::parse($values['ljoprtd']['finish_at']);
				$durasi_detik = $cb_start_at->diffInSeconds($cb_finish_at);
				
				$editor
					->field( 'ljoprtd.durasi_detik' )
					->setValue( $durasi_detik );
				
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