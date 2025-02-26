<?php
	use 
		SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row )  use ($nama_table, $nama_table_before) {
			include('../../models/wreittd/wreittd_fn_konversi_terkecil.php');
			General::konversiUom2( $editor->db(), 'sivittd', $id );
			$id_sivxxth = $values['sivittd']['id_sivxxth'];
			
			$qi_sivaktd = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('INSERT INTO sivaktd (
							id_sivxxth,
							id_sivittd,
							id_aakxxmh,
							nominal
						)
						SELECT
							z.id_sivxxth,
							z.id,
							IFNULL(e.id_aakxxmh_biaya, d.id_aakxxmh_biaya) id_biaya,
							z.dpp
						FROM sivittd z
						LEFT JOIN sivxxth h ON h.id = z.id_sivxxth
						LEFT JOIN iimxxmh a ON a.id = z.id_iimxxmh
						LEFT JOIN iicxxmh b ON b.id = a.id_iicxxmh
						LEFT JOIN iigxxmh c ON c.id = a.id_iigxxmh
						LEFT JOIN iicxxmh_aakxxmh d ON d.id_iicxxmh = b.id
						LEFT JOIN iigxxmh_aakxxmh e ON e.id_iigxxmh = c.id
						WHERE a.id_iitxxmh = 3 AND z.id = :id AND h.id_iitxxmh = 3
			');
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// General::kalkulasiJumlahTransaksiBefore2( $editor->db(), $id, $values, 'Edit', 'sivittd', 'sdlittd' );
			// General::isNextProcess( $editor->db(), 'prqxxth', 'prqittd', 'sivittd', $id, 'EDIT', $values );
		})
		->on('postEdit',function( $editor, $id, $values, $row )  use ($nama_table, $nama_table_before) {
			include('../../models/wreittd/wreittd_fn_konversi_terkecil.php');
			General::konversiUom2( $editor->db(), 'sivittd', $id );

			$qd_sivaktd = $editor->db()
				->query('delete', 'sivaktd')
				->where('id_sivittd',$id)
				->exec();
			
			$qi_sivaktd = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('INSERT INTO sivaktd (
							id_sivxxth,
							id_sivittd,
							id_aakxxmh,
							nominal
						)
						SELECT
							z.id_sivxxth,
							z.id,
							IFNULL(e.id_aakxxmh_biaya, d.id_aakxxmh_biaya) id_biaya,
							z.dpp
						FROM sivittd z
						LEFT JOIN sivxxth h ON h.id = z.id_sivxxth
						LEFT JOIN iimxxmh a ON a.id = z.id_iimxxmh
						LEFT JOIN iicxxmh b ON b.id = a.id_iicxxmh
						LEFT JOIN iigxxmh c ON c.id = a.id_iigxxmh
						LEFT JOIN iicxxmh_aakxxmh d ON d.id_iicxxmh = b.id
						LEFT JOIN iigxxmh_aakxxmh e ON e.id_iigxxmh = c.id
						WHERE a.id_iitxxmh = 3 AND z.id = :id AND h.id_iitxxmh = 3
			');
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// General::isNextProcess( $editor->db(), 'prqxxth', 'prqittd', 'sivittd', $id, 'REMOVE', $values );
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>