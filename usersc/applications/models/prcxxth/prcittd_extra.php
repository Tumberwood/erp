<?php

	use 
		SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			General::konversiUom( $editor->db(), 'prcittd', $id );
			General::kalkulasiJumlahTransaksiBefore2( $editor->db(), $id, $values, 'Create', 'prcittd', 'podittd' );
			General::konversiBuy( $editor->db(), 'prcittd', $id );

			$qi_prcaktd = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('INSERT INTO prcaktd (
							id_prcxxth,
							id_prcittd,
							id_aakxxmh,
							nominal
						)
						SELECT
							z.id_prcxxth,
							z.id,
							IFNULL(e.id_aakxxmh_biaya, d.id_aakxxmh_biaya) id_biaya,
							z.dpp
						FROM prcittd z
						LEFT JOIN prcxxth h ON h.id = z.id_prcxxth
						LEFT JOIN iimxxmh a ON a.id = z.id_iimxxmh
						LEFT JOIN iicxxmh b ON b.id = a.id_iicxxmh
						LEFT JOIN iigxxmh c ON c.id = a.id_iigxxmh
						LEFT JOIN iicxxmh_aakxxmh d ON d.id_iicxxmh = b.id
						LEFT JOIN iigxxmh_aakxxmh e ON e.id_iigxxmh = c.id
						WHERE a.id_iitxxmh = 3 AND z.id = :id AND h.id_iitxxmh = 3
			');
		})
		->on('preEdit',function( $editor, $id, $values ) {
			General::kalkulasiJumlahTransaksiBefore2( $editor->db(), $id, $values, 'Edit', 'prcittd', 'podittd' );
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			General::konversiUom( $editor->db(), 'prcittd', $id );
			General::konversiBuy( $editor->db(), 'prcittd', $id );

			$qd_prcaktd = $editor->db()
				->query('delete', 'prcaktd')
				->where('id_prcittd',$id)
				->exec();
			
			$qi_prcaktd = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('INSERT INTO prcaktd (
							id_prcxxth,
							id_prcittd,
							id_aakxxmh,
							nominal
						)
						SELECT
							z.id_prcxxth,
							z.id,
							IFNULL(e.id_aakxxmh_biaya, d.id_aakxxmh_biaya) id_biaya,
							z.dpp
						FROM prcittd z
						LEFT JOIN prcxxth h ON h.id = z.id_prcxxth
						LEFT JOIN iimxxmh a ON a.id = z.id_iimxxmh
						LEFT JOIN iicxxmh b ON b.id = a.id_iicxxmh
						LEFT JOIN iigxxmh c ON c.id = a.id_iigxxmh
						LEFT JOIN iicxxmh_aakxxmh d ON d.id_iicxxmh = b.id
						LEFT JOIN iigxxmh_aakxxmh e ON e.id_iigxxmh = c.id
						WHERE a.id_iitxxmh = 3 AND z.id = :id AND h.id_iitxxmh = 3
			');
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>