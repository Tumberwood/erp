<?php

	include_once( "../../../../usersc/vendor/autoload.php");
	use 
		Carbon\Carbon;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini			
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// INSERT ljoprtd jika belum ada
			$qs_ljoprtd = $editor->db()
				->query('select', 'ljoprtd' )
				->get([
					'COUNT(ljoprtd.id) as c_id_ljoprtd'
				] )
				->where('ljoprtd.id_ljoxxth', $id )
				->where('ljoprtd.id_lprxxmh', 2 )
				->exec();
			$rs_ljoprtd = $qs_ljoprtd->fetch();
			$c_id_ljoprtd = $rs_ljoprtd['c_id_ljoprtd'];

			if($c_id_ljoprtd == 0){
				// belum ada arrival, harus insert
				$cb_start_at = Carbon::parse($values['ljoprtd']['start_at']);
				$cb_finish_at = Carbon::parse($values['ljoprtd']['finish_at']);
				$durasi_detik = $cb_start_at->diffInSeconds($cb_finish_at);

				$qi_ljoprtd = $editor->db()
					->raw()
					->bind(':id_ljoxxth', $id)
					->bind(':tanggaljam_start', $values['ljoprtd']['start_at'])
					->bind(':tanggaljam_finish', $values['ljoprtd']['finish_at'])
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
							2,
							:tanggaljam_start,
							:tanggaljam_finish,
							:durasi_detik
						)
					');

				// UPDATE id_lprxxmh_last
				$qu_ljoxxth = $editor->db()
					->query('update', 'ljoxxth')
					->set('id_lprxxmh_last', 2)
					->where('id',$id)
					->exec();
			}
			
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>