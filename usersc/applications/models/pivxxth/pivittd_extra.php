<?php
	use 
		SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row )  use ($nama_table, $nama_table_before) {
			include('../../models/wreittd/wreittd_fn_konversi_terkecil.php');
			General::konversiUom2( $editor->db(), 'pivittd', $id );
			$id_pivxxth = $values['pivittd']['id_pivxxth'];
			
			$qi_pivaktd = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('INSERT INTO pivaktd (
							id_pivxxth,
							id_pivittd,
							id_aakxxmh,
							nominal
						)
						SELECT
							z.id_pivxxth,
							z.id,
							IFNULL(e.id_aakxxmh_biaya, d.id_aakxxmh_biaya) id_biaya,
							z.dpp
						FROM pivittd z
						LEFT JOIN pivxxth h ON h.id = z.id_pivxxth
						LEFT JOIN iimxxmh a ON a.id = z.id_iimxxmh
						LEFT JOIN iicxxmh b ON b.id = a.id_iicxxmh
						LEFT JOIN iigxxmh c ON c.id = a.id_iigxxmh
						LEFT JOIN iicxxmh_aakxxmh d ON d.id_iicxxmh = b.id
						LEFT JOIN iigxxmh_aakxxmh e ON e.id_iigxxmh = c.id
						WHERE a.id_iitxxmh = 3 AND z.id = :id AND h.id_iitxxmh = 3
			');
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// General::kalkulasiJumlahTransaksiBefore2( $editor->db(), $id, $values, 'Edit', 'pivittd', 'prcittd' );
			// General::isNextProcess( $editor->db(), 'prqxxth', 'prqittd', 'pivittd', $id, 'EDIT', $values );
		})
		->on('postEdit',function( $editor, $id, $values, $row )  use ($nama_table, $nama_table_before) {
			include('../../models/wreittd/wreittd_fn_konversi_terkecil.php');
			General::konversiUom2( $editor->db(), 'pivittd', $id );

			$qd_pivaktd = $editor->db()
				->query('delete', 'pivaktd')
				->where('id_pivittd',$id)
				->exec();
			
			$qi_pivaktd = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('INSERT INTO pivaktd (
							id_pivxxth,
							id_pivittd,
							id_aakxxmh,
							nominal
						)
						SELECT
							z.id_pivxxth,
							z.id,
							IFNULL(e.id_aakxxmh_biaya, d.id_aakxxmh_biaya) id_biaya,
							z.dpp
						FROM pivittd z
						LEFT JOIN pivxxth h ON h.id = z.id_pivxxth
						LEFT JOIN iimxxmh a ON a.id = z.id_iimxxmh
						LEFT JOIN iicxxmh b ON b.id = a.id_iicxxmh
						LEFT JOIN iigxxmh c ON c.id = a.id_iigxxmh
						LEFT JOIN iicxxmh_aakxxmh d ON d.id_iicxxmh = b.id
						LEFT JOIN iigxxmh_aakxxmh e ON e.id_iigxxmh = c.id
						WHERE a.id_iitxxmh = 3 AND z.id = :id AND h.id_iitxxmh = 3
			');
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// General::isNextProcess( $editor->db(), 'prqxxth', 'prqittd', 'pivittd', $id, 'REMOVE', $values );
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>