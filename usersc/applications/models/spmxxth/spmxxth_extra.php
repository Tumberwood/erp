<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			$id_sprxxth = $values['spmxxth']['id_sprxxth'];
			$qi_spmivtd = $editor->db()
				->raw()
				->bind(':id_sprxxth', $id_sprxxth)
				->bind(':id', $id)
				->exec('INSERT INTO spmivtd (
							id_spmxxth,
							id_sprivtd,
							id_sivxxth,
							tanggal,
							tanggal_jatuh_tempo,
							amount,
							rencana_bayar,
							sisa
						)
						SELECT
							:id,
							b.id,
							b.id_sivxxth,
							b.tanggal,
							b.tanggal_jatuh_tempo,
							b.amount,
							b.rencana_bayar,
							b.sisa
						FROM sprivtd b
						WHERE b.id_sprxxth = :id_sprxxth AND b.transaction_state = 1
			');

			$qu_sprivtd = $editor->db()
				->query('update', 'sprivtd')
				->set('is_purchase_payment',1)
				->where('id_sprxxth',$id_sprxxth)
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