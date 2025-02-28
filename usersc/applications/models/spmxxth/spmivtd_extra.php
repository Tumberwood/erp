<?php
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
			$id_spmxxth = $values['spmivtd']['id_spmxxth'];
			$qu_spmxxth = $editor->db()
				->raw()
				->bind(':id_spmxxth', $id_spmxxth)
				->exec('UPDATE spmxxth b
						JOIN (
							SELECT 
								a.id_spmxxth,
								SUM(a.amount) AS total_amount,
								SUM(a.rencana_bayar) AS total_rencana_bayar,
								SUM(a.sisa) AS total_sisa
							FROM spmivtd a
							WHERE a.transaction_state <> -9
							GROUP BY a.id_spmxxth
						) AS sums ON sums.id_spmxxth = b.id
						SET
							b.amount = sums.total_amount,
							b.rencana_bayar = sums.total_rencana_bayar,
							b.sisa = sums.total_sisa
						WHERE b.id = :id_spmxxth;

			');
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>