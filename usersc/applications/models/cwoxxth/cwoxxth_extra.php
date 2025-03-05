<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			$qi_cwoittd = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('INSERT INTO cwoittd (
							id_cwoxxth,
							id_dbmittd,
							id_iimxxmh,
							kode,
							nama,
							id_iumxxmh_unit,
							jumlah_bom,
							jumlah_total
						)
						SELECT
							a.id,
							c.id id_dbmittd,
							c.id_iimxxmh,
							d.kode,
							d.nama,
							c.id_iumxxmh_unit,
							c.jumlah_unit,
							c.jumlah_unit * a.jumlah_unit
						FROM cwoxxth a
						LEFT JOIN dbmxxth b ON b.id = a.id_dbmxxth
						LEFT JOIN dbmittd c ON c.id_dbmxxth = b.id
						LEFT JOIN iimxxmh d ON d.id = c.id_iimxxmh
						WHERE a.id = :id
			');
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			$qd_cwoittd = $editor->db()
				->query('delete', 'cwoittd')
				->where('id_cwoxxth',$id)
				->exec();
			
			$qi_cwoittd = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('INSERT INTO cwoittd (
							id_cwoxxth,
							id_dbmittd,
							id_iimxxmh,
							kode,
							nama,
							id_iumxxmh_unit,
							jumlah_bom,
							jumlah_total
						)
						SELECT
							a.id,
							c.id id_dbmittd,
							c.id_iimxxmh,
							d.kode,
							d.nama,
							c.id_iumxxmh_unit,
							c.jumlah_unit,
							c.jumlah_unit * a.jumlah_unit
						FROM cwoxxth a
						LEFT JOIN dbmxxth b ON b.id = a.id_dbmxxth
						LEFT JOIN dbmittd c ON c.id_dbmxxth = b.id
						LEFT JOIN iimxxmh d ON d.id = c.id_iimxxmh
						WHERE a.id = :id
			');
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>