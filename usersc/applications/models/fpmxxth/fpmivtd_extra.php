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
			$id_fpmxxth = $values['fpmivtd']['id_fpmxxth'];
			$qu_fpmxxth = $editor->db()
				->raw()
				->bind(':id_fpmxxth', $id_fpmxxth)
				->exec('UPDATE fpmxxth b
						JOIN (
							SELECT 
								a.id_fpmxxth,
								SUM(a.amount) AS total_amount,
								SUM(a.rencana_bayar) AS total_rencana_bayar,
								SUM(a.sisa) AS total_sisa
							FROM fpmivtd a
							WHERE a.transaction_state <> -9
							GROUP BY a.id_fpmxxth
						) AS sums ON sums.id_fpmxxth = b.id
						SET
							b.amount = sums.total_amount,
							b.rencana_bayar = sums.total_rencana_bayar,
							b.sisa = sums.total_sisa
						WHERE b.id = :id_fpmxxth;

			');
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>