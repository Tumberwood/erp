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
			$repaired_by = $values['pmi_cylinder_problem_t_action']['repaired_by'];

			$qs_action = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('SELECT
							repaired_by
						FROM pmi_cylinder_problem_t_action a
						where a.id = :id
			');
			
			$rs_action = $qs_action->fetch();
			$repaired_by_old = $rs_action['repaired_by'];

			if ($repaired_by_old == null && $repaired_by != null) {
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