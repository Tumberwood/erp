<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
			$id_sprxxth = $values['sprivtd']['id_sprxxth'];
			$qu_sprxxth = $editor->db()
				->raw()
				->bind(':id_sprxxth', $id_sprxxth)
				->exec('UPDATE sprxxth b
						JOIN (
							SELECT 
								a.id_sprxxth,
								SUM(a.amount) AS total_amount,
								SUM(a.rencana_bayar) AS total_rencana_bayar,
								SUM(a.sisa) AS total_sisa
							FROM sprivtd a
							WHERE a.transaction_state <> -9
							GROUP BY a.id_sprxxth
						) AS sums ON sums.id_sprxxth = b.id
						SET
							b.amount = sums.total_amount,
							b.rencana_bayar = sums.total_rencana_bayar,
							b.sisa = sums.total_sisa
						WHERE b.id = :id_sprxxth;

			');

			$qu_sivxxth = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('UPDATE sivxxth a
						LEFT JOIN sprivtd b ON b.id_sivxxth = a.id
						SET
							a.terbayar = ifnull(a.terbayar,0) + b.rencana_bayar,
							a.selisih_bayar = a.selisih_bayar - b.rencana_bayar
						WHERE b.id = :id

			');
		})
		->on('preEdit',function( $editor, $id, $values ) {
			$rencana_bayar = $values['sprivtd']['rencana_bayar'];
			$id_sivxxth = $values['sprivtd']['id_sivxxth'];

			$qs_sprivtd = $editor->db()
				->query('select', 'sprivtd' )
				->get([
					'id_sivxxth'
				] )
				->where('id', $id )
				->exec();
			$rs_sprivtd = $qs_sprivtd->fetch();
			$id_sivxxth_old = $rs_sprivtd['id_sivxxth'];

			if ($id_sivxxth != $id_sivxxth_old) {

				//Jika siv diganti lain, maka kembalikan nilai terbayar dan selisih
				$qu_sivxxth_old = $editor->db()
					->raw()
					->bind(':id', $id)
					->exec('UPDATE sivxxth a
							LEFT JOIN sprivtd b ON b.id_sivxxth = a.id
							SET
								a.terbayar = (ifnull(a.terbayar,0) - b.rencana_bayar),
								a.selisih_bayar = (a.selisih_bayar + b.rencana_bayar)
							WHERE b.id = :id

				');

				//Update siv yang baru
				$qu_sivxxth_now = $editor->db()
					->raw()
					->bind(':id_sivxxth', $id_sivxxth)
					->bind(':rencana_bayar', $rencana_bayar)
					->exec('UPDATE sivxxth a
							SET
								a.terbayar = ifnull(a.terbayar,0) + :rencana_bayar,
								a.selisih_bayar = a.selisih_bayar - :rencana_bayar
							WHERE a.id = :id_sivxxth

				');
			} else {
				$qu_sivxxth = $editor->db()
					->raw()
					->bind(':id', $id)
					->bind(':rencana_bayar', $rencana_bayar)
					->exec('UPDATE sivxxth a
							LEFT JOIN sprivtd b ON b.id_sivxxth = a.id
							SET
								a.terbayar = (ifnull(a.terbayar,0) - b.rencana_bayar) + :rencana_bayar,
								a.selisih_bayar = (a.selisih_bayar + b.rencana_bayar) - :rencana_bayar
							WHERE b.id = :id

				');
			}
			

		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			$id_sprxxth = $values['sprivtd']['id_sprxxth'];
			$qu_sprxxth = $editor->db()
				->raw()
				->bind(':id_sprxxth', $id_sprxxth)
				->exec('UPDATE sprxxth b
						JOIN (
							SELECT 
								a.id_sprxxth,
								SUM(a.amount) AS total_amount,
								SUM(a.rencana_bayar) AS total_rencana_bayar,
								SUM(a.sisa) AS total_sisa
							FROM sprivtd a
							WHERE a.transaction_state <> -9
							GROUP BY a.id_sprxxth
						) AS sums ON sums.id_sprxxth = b.id
						SET
							b.amount = sums.total_amount,
							b.rencana_bayar = sums.total_rencana_bayar,
							b.sisa = sums.total_sisa
						WHERE b.id = :id_sprxxth;

			');
		})
		->on('preRemove',function( $editor, $id, $values ) {
			$id_sprxxth = $values['sprivtd']['id_sprxxth'];
			$rencana_bayar = $values['sprivtd']['rencana_bayar'];

			$qu_sprxxth = $editor->db()
				->raw()
				->bind(':id_sprxxth', $id_sprxxth)
				->bind(':id', $id)
				->exec('UPDATE sprxxth b
						JOIN (
							SELECT 
								a.id_sprxxth,
								SUM(a.amount) AS total_amount,
								SUM(a.rencana_bayar) AS total_rencana_bayar,
								SUM(a.sisa) AS total_sisa
							FROM sprivtd a
							WHERE a.transaction_state <> -9
							GROUP BY a.id_sprxxth
						) AS sums ON sums.id_sprxxth = b.id
						LEFT JOIN sprivtd c ON c.id = :id
						SET
							b.amount = sums.total_amount- c.amount,
							b.rencana_bayar = sums.total_rencana_bayar- c.rencana_bayar,
							b.sisa = sums.total_sisa - c.sisa
						WHERE b.id = :id_sprxxth;
			');

			$qu_sivxxth = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('UPDATE sivxxth a
						LEFT JOIN sprivtd b ON b.id_sivxxth = a.id
						SET
							a.terbayar = (ifnull(a.terbayar,0) - b.rencana_bayar),
							a.selisih_bayar = (a.selisih_bayar + b.rencana_bayar)
						WHERE b.id = :id

			');
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>