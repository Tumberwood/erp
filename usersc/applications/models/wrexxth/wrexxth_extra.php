<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			$tanggal = $values['wrexxth']['tanggal'];
			$id_wroxxth = $values['wrexxth']['id_wroxxth'];

			$qi_det = $editor->db()
				->raw()
				->bind(':id', $id)
				->bind(':tanggal', $tanggal)
				->bind(':id_wroxxth', $id_wroxxth)
				->exec('INSERT INTO wrexxth_wreittd (
							id_wrexxth,
							id_wreittd
						)
						SELECT
							:id,
							a.id
						FROM wreittd a
						WHERE a.id_wroxxth = :id_wroxxth AND DATE_FORMAT(a.finish_at, "%d %b %Y") = :tanggal AND a.is_done_slip = 0
			');

			$qu_wreittd = $editor->db()
				->raw()
				->bind(':tanggal', $tanggal)
				->bind(':id_wroxxth', $id_wroxxth)
				->exec('UPDATE wreittd a
						SET
							a.is_done_slip = 1
						WHERE a.id_wroxxth = :id_wroxxth AND DATE_FORMAT(a.finish_at, "%d %b %Y") = :tanggal AND a.is_done_slip = 0
			');
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
		})
		->on('preRemove',function( $editor, $id, $values ) {
			$qs_slip = $editor->db()
				->query('select', 'wrexxth_wreittd' )
				->get(['id_wreittd'] )
				->where('id_wrexxth', $id )
				->exec();
			$rs_slip = $qs_slip->fetchAll();

			foreach ($rs_slip as $key => $slip) {
				$qu_wreittd = $editor->db()
					->query('update', 'wreittd')
					->set('is_done_slip', 0)
					->where('id',$slip['id_wreittd'])
					->exec();
			}

			$qd_det = $editor->db()
				->query('delete', 'wrexxth_wreittd')
				->where('id_wrexxth',$id)
				->exec();
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>