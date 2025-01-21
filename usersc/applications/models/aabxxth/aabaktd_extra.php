<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
			$id_aabxxth = $values['aabaktd']['id_aabxxth'];

			$qu_aabxxth = $editor->db()
				->raw()
				->bind(':id_aabxxth', $id_aabxxth)
				->exec('UPDATE aabxxth AS a
						LEFT JOIN (
							SELECT
								id_aabxxth,
								SUM(a.nominal) s_nominal
							FROM aabaktd a
							WHERE a.id_aabxxth = :id_aabxxth AND a.transaction_state <> -9
						) b ON b.id_aabxxth = a.id
						SET
							a.subtotal = s_nominal
						WHERE a.id = :id_aabxxth
			');
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
			$id_aabxxth = $values['aabaktd']['id_aabxxth'];

			$qu_aabxxth = $editor->db()
				->raw()
				->bind(':id_aabxxth', $id_aabxxth)
				->exec('UPDATE aabxxth AS a
						LEFT JOIN (
							SELECT
								id_aabxxth,
								SUM(a.nominal) s_nominal
							FROM aabaktd a
							WHERE a.id_aabxxth = :id_aabxxth AND a.transaction_state <> -9
						) b ON b.id_aabxxth = a.id
						SET
							a.subtotal = s_nominal
						WHERE a.id = :id_aabxxth
			');
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>