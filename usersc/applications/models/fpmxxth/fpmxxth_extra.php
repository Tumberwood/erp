<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			$id_fprxxth = $values['fpmxxth']['id_fprxxth'];
			$qi_fpmivtd = $editor->db()
				->raw()
				->bind(':id_fprxxth', $id_fprxxth)
				->bind(':id', $id)
				->exec('INSERT INTO fpmivtd (
							id_fpmxxth,
							id_fprivtd,
							id_pivxxth,
							tanggal,
							tanggal_jatuh_tempo,
							amount,
							rencana_bayar,
							sisa
						)
						SELECT
							:id,
							b.id,
							b.id_pivxxth,
							b.tanggal,
							b.tanggal_jatuh_tempo,
							b.amount,
							b.rencana_bayar,
							b.sisa
						FROM fprivtd b
						WHERE b.id_fprxxth = :id_fprxxth AND b.transaction_state = 1
			');

			$qu_fprivtd = $editor->db()
				->query('update', 'fprivtd')
				->set('is_purchase_payment',1)
				->where('id_fprxxth',$id_fprxxth)
				->exec();
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