<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) use ($s_id_users, $s_username) {
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			$transaksi_in = $values['isoittd_upload']['transaksi_in'];
			$transaksi_out = $values['isoittd_upload']['transaksi_out'];

			$qu_selish_final = $editor->db()
				->raw()
				->bind(':id', $id)
				->bind(':transaksi_in', $transaksi_in)
				->bind(':transaksi_out', $transaksi_out)
				->exec('UPDATE isoittd_upload a
						SET 
							transaksi_in = :transaksi_in,
							transaksi_out = :transaksi_out,
							selisih_final = a.fisik + :transaksi_out - a.jumlah_terkecil - :transaksi_in
						WHERE a.id = :id
					'
			);
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>