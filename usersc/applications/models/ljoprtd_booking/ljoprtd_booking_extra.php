<?php

	include_once( "../../../../usersc/vendor/autoload.php");
	use 
		Carbon\Carbon;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// UPDATE last status menjadi Booking (1)
			$editor
				->field( 'ljoxxth.id_lprxxmh_last' )
				->setValue( 1 );
			
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// INSERT activity Booking (1) ke ljoprtd
			$cb_start_at = Carbon::parse($values['ljoxxth']['start_at']);
			$cb_finish_at = Carbon::parse($values['ljoxxth']['finish_at']);
			$durasi_detik = $cb_start_at->diffInSeconds($cb_finish_at);

			$qi_ljoprtd = $editor->db()
				->raw()
				->bind(':id_ljoxxth', $id)
				->bind(':tanggaljam_start', $values['ljoxxth']['start_at'])
				->bind(':tanggaljam_finish', $values['ljoxxth']['finish_at'])
				->bind(':durasi_detik', $durasi_detik)
				->exec('
					INSERT INTO
						ljoprtd (
							id_ljoxxth,
							id_lprxxmh,
							tanggaljam_start,
							tanggaljam_finish,
							durasi_detik
						)
					VALUES(
						:id_ljoxxth,
						1,
						:tanggaljam_start,
						:tanggaljam_finish,
						:durasi_detik
					)
				');
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