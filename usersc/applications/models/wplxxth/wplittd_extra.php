<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row )  use ($nama_table, $nama_table_before) {
			include('../../models/wreittd/wreittd_fn_konversi_terkecil.php');
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row )  use ($nama_table, $nama_table_before) {
			include('../../models/wreittd/wreittd_fn_konversi_terkecil.php');
		})
		->on('preRemove',function( $editor, $id, $values ) {
			$qs_this = $editor->db()
				->query('select', 'wplittd' )
				->get([
					'jumlah_terkecil',
					'jumlah_unit'
				] )
				->where('id', $id )
				->exec();
			$rs_this = $qs_this->fetch();
			$id_wdoittd = $values['wplittd']['id_wdoittd'];

			$jumlah_terkecil = $rs_this['jumlah_terkecil'];
			$jumlah_unit = $rs_this['jumlah_unit'];

			$qu_wdo = $editor->db()
				->raw()
				->bind(':id_wdoittd', $id_wdoittd)
				->bind(':jumlah_terkecil', $jumlah_terkecil)
				->bind(':jumlah_unit', $jumlah_unit)
				->exec('UPDATE wdoittd
						SET
							jumlah_terkecil_os = jumlah_terkecil_os + :jumlah_terkecil,
							jumlah_terkecil_next = jumlah_terkecil_next - :jumlah_terkecil,
							jumlah_unit_os = jumlah_unit_os + :jumlah_unit,
							jumlah_unit_next = jumlah_unit_next - :jumlah_unit
						WHERE id = :id_wdoittd'
			);

		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>