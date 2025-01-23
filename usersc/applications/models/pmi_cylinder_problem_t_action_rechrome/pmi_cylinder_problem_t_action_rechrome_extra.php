<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
			$keterangan_cyl = $values['pmi_cylinder_problem_t_action']['keterangan_cyl'];

			$qs_action = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('SELECT
							keterangan_cyl
						FROM pmi_cylinder_problem_t_action a
						where a.id = :id
			');
			
			$rs_action = $qs_action->fetch();
			$keterangan_cyl_old = $rs_action['keterangan_cyl'];

			if ($keterangan_cyl_old == null && $keterangan_cyl != null) {
				$qu_action = $editor->db()
					->raw()
					->bind(':id', $id)
					->exec('UPDATE pmi_cylinder_problem_t_action
							SET
								tanggal_keterangan = curdate()
							where id = :id
				');
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