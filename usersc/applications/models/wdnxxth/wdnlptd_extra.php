<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row )  use ($nama_table, $nama_table_before) {
			include('wdnxxth_fn_konversi_terkecil.php');

			include('wdnlptd_kalkulasi_items.php');
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row )  use ($nama_table, $nama_table_before) {
			include('wdnxxth_fn_konversi_terkecil.php');
			include('wdnlptd_kalkulasi_items.php');
		})
		->on('preRemove',function( $editor, $id, $values ) {
			$qs_this = $editor->db()
				->query('select', 'wdnlptd' )
				->get([
					'jumlah_terkecil',
				] )
				->where('id', $id )
				->exec();
			$rs_this = $qs_this->fetch();
			$id_wdplptd = $values['wdnlptd']['id_wdplptd'];

			$jumlah_terkecil = $rs_this['jumlah_terkecil'];

			$qu_wdo = $editor->db()
				->raw()
				->bind(':id_wdplptd', $id_wdplptd)
				->bind(':jumlah_terkecil', $jumlah_terkecil)
				->exec('UPDATE wdplptd
						SET
							jumlah_terkecil_os = jumlah_terkecil_os + :jumlah_terkecil,
							jumlah_terkecil_next = jumlah_terkecil_next - :jumlah_terkecil
						WHERE id = :id_wdplptd'
			);

		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
			include('wdnlptd_kalkulasi_items.php');
		});
?>