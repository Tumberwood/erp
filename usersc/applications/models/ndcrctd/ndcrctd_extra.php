<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			$qi_ndcxxmh = $editor->db()
				->query('insert', 'ndcxxmh')
				->set('dokumen_nomor', $values['ndcxxmh']['dokumen_nomor'])
				->set('status_dokumen', 1)
				->exec();

			$id_ndcrctd = $qi_ndcxxmh->insertId();
			
			$qu_ndcrctd = $editor->db()
				->query('update', 'ndcrctd')
				->set('id_ndcxxmh',$id_ndcrctd)
				->where('id',$id)
				->exec();
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			$qu_ndcxxmh = $editor->db()
				->query('update', 'ndcxxmh')
				->set('dokumen_nomor', $values['ndcxxmh']['dokumen_nomor'])
				->where('id', $values['ndcxxmh']['id'])
				->exec();
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>