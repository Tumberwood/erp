<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			$id_gfrxxth = $values['gfrfltd']['id_gfrxxth'];
			$type_data = $values['gfrfltd']['type_data'];

			$qs_gfrfltd = $editor->db()
				->raw()
				->bind(':id_gfrxxth', $id_gfrxxth)
				->exec('SELECT
							COUNT(a.id) c_id,
							CONCAT(b.nama_tabel,".field_", COUNT(a.id)) nama,
							CONCAT("field_", COUNT(a.id)) field_name,
							b.nama_tabel
						FROM gfrfltd a
						LEFT JOIN gfrxxth b ON b.id = a.id_gfrxxth
						WHERE a.id_gfrxxth = :id_gfrxxth
						'
			);
			$rs_gfrfltd = $qs_gfrfltd->fetch();

			$qu_gfrfltd = $editor->db()
			->query('update', 'gfrfltd')
			->set('nama',$rs_gfrfltd['nama'])
			->where('id',$id)
			->exec();

			$q_alter_table = $editor->db()
			->raw()
			->exec('ALTER TABLE `' . $rs_gfrfltd['nama_tabel'] . '` 
					ADD COLUMN IF NOT EXISTS `' . $rs_gfrfltd['field_name'] . '` ' . $type_data . ';'
			);

		})
		->on('preEdit',function( $editor, $id, $values ) {
			$type_data_new = $values['gfrfltd']['type_data'];

			$qs_gfrfltd = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('SELECT
							type_data type_data_old,
							SUBSTRING_INDEX(a.nama, ".", -1) field_name,
							b.nama_tabel
						FROM gfrfltd a
						LEFT JOIN gfrxxth b ON b.id = a.id_gfrxxth
						WHERE a.id = :id
						'
			);
			$rs_gfrfltd = $qs_gfrfltd->fetch();
			$type_data_old = $rs_gfrfltd['type_data_old'];

			if ($type_data_new != $type_data_old) {
				$q_alter_table = $editor->db()
				->raw()
				->exec('ALTER TABLE `' . $rs_gfrfltd['nama_tabel'] . '` 
						MODIFY COLUMN `' . $rs_gfrfltd['field_name'] . '` ' . $type_data_new . ';'
				);
			}
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>