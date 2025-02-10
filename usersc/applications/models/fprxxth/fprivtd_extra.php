<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
			$id_fprxxth = $values['fprivtd']['id_fprxxth'];
			$qu_fprxxth = $editor->db()
				->raw()
				->bind(':id_fprxxth', $id_fprxxth)
				->exec('UPDATE fprxxth b
						JOIN (
							SELECT 
								a.id_fprxxth,
								SUM(a.amount) AS total_amount,
								SUM(a.rencana_bayar) AS total_rencana_bayar,
								SUM(a.sisa) AS total_sisa
							FROM fprivtd a
							WHERE a.transaction_state <> -9
							GROUP BY a.id_fprxxth
						) AS sums ON sums.id_fprxxth = b.id
						SET
							b.amount = sums.total_amount,
							b.rencana_bayar = sums.total_rencana_bayar,
							b.sisa = sums.total_sisa
						WHERE b.id = :id_fprxxth;

			');

			$qu_pivxxth = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('UPDATE pivxxth a
						LEFT JOIN fprivtd b ON b.id_pivxxth = a.id
						SET
							a.terbayar = ifnull(a.terbayar,0) + b.rencana_bayar,
							a.selisih_bayar = a.selisih_bayar - b.rencana_bayar
						WHERE b.id = :id

			');
		})
		->on('preEdit',function( $editor, $id, $values ) {
			$rencana_bayar = $values['fprivtd']['rencana_bayar'];
			$id_pivxxth = $values['fprivtd']['id_pivxxth'];

			$qs_fprivtd = $editor->db()
				->query('select', 'fprivtd' )
				->get([
					'id_pivxxth'
				] )
				->where('id', $id )
				->exec();
			$rs_fprivtd = $qs_fprivtd->fetch();
			$id_pivxxth_old = $rs_fprivtd['id_pivxxth'];

			if ($id_pivxxth != $id_pivxxth_old) {

				//Jika PIV diganti lain, maka kembalikan nilai terbayar dan selisih
				$qu_pivxxth_old = $editor->db()
					->raw()
					->bind(':id', $id)
					->exec('UPDATE pivxxth a
							LEFT JOIN fprivtd b ON b.id_pivxxth = a.id
							SET
								a.terbayar = (ifnull(a.terbayar,0) - b.rencana_bayar),
								a.selisih_bayar = (a.selisih_bayar + b.rencana_bayar)
							WHERE b.id = :id

				');

				//Update PIV yang baru
				$qu_pivxxth_now = $editor->db()
					->raw()
					->bind(':id_pivxxth', $id_pivxxth)
					->bind(':rencana_bayar', $rencana_bayar)
					->exec('UPDATE pivxxth a
							SET
								a.terbayar = ifnull(a.terbayar,0) + :rencana_bayar,
								a.selisih_bayar = a.selisih_bayar - :rencana_bayar
							WHERE a.id = :id_pivxxth

				');
			} else {
				$qu_pivxxth = $editor->db()
					->raw()
					->bind(':id', $id)
					->bind(':rencana_bayar', $rencana_bayar)
					->exec('UPDATE pivxxth a
							LEFT JOIN fprivtd b ON b.id_pivxxth = a.id
							SET
								a.terbayar = (ifnull(a.terbayar,0) - b.rencana_bayar) + :rencana_bayar,
								a.selisih_bayar = (a.selisih_bayar + b.rencana_bayar) - :rencana_bayar
							WHERE b.id = :id

				');
			}
			

		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			$id_fprxxth = $values['fprivtd']['id_fprxxth'];
			$qu_fprxxth = $editor->db()
				->raw()
				->bind(':id_fprxxth', $id_fprxxth)
				->exec('UPDATE fprxxth b
						JOIN (
							SELECT 
								a.id_fprxxth,
								SUM(a.amount) AS total_amount,
								SUM(a.rencana_bayar) AS total_rencana_bayar,
								SUM(a.sisa) AS total_sisa
							FROM fprivtd a
							WHERE a.transaction_state <> -9
							GROUP BY a.id_fprxxth
						) AS sums ON sums.id_fprxxth = b.id
						SET
							b.amount = sums.total_amount,
							b.rencana_bayar = sums.total_rencana_bayar,
							b.sisa = sums.total_sisa
						WHERE b.id = :id_fprxxth;

			');
		})
		->on('preRemove',function( $editor, $id, $values ) {
			$id_fprxxth = $values['fprivtd']['id_fprxxth'];
			$rencana_bayar = $values['fprivtd']['rencana_bayar'];

			$qu_fprxxth = $editor->db()
				->raw()
				->bind(':id_fprxxth', $id_fprxxth)
				->bind(':id', $id)
				->exec('UPDATE fprxxth b
						JOIN (
							SELECT 
								a.id_fprxxth,
								SUM(a.amount) AS total_amount,
								SUM(a.rencana_bayar) AS total_rencana_bayar,
								SUM(a.sisa) AS total_sisa
							FROM fprivtd a
							WHERE a.transaction_state <> -9
							GROUP BY a.id_fprxxth
						) AS sums ON sums.id_fprxxth = b.id
						LEFT JOIN fprivtd c ON c.id = :id
						SET
							b.amount = sums.total_amount- c.amount,
							b.rencana_bayar = sums.total_rencana_bayar- c.rencana_bayar,
							b.sisa = sums.total_sisa - c.sisa
						WHERE b.id = :id_fprxxth;
			');

			$qu_pivxxth = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('UPDATE pivxxth a
						LEFT JOIN fprivtd b ON b.id_pivxxth = a.id
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