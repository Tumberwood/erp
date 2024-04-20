<?php
	function ndcxxmh_update ( $db, $transaction_state, $id, &$values )  {
		$qu_ndcxxmh = $db
			->query('update', 'ndcxxmh')
			->set('document_state', $transaction_state)
			->where('id', $values['ndctotd']['id_ndcxxmh'])
			->exec();
	}

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			ndcxxmh_update( $editor->db(), 0, $id, $values );
		})
		->on('preEdit',function( $editor, $id, $values ) {
			$qs_ndctotd = $editor->db()
				->query('select', 'ndctotd' )
				->get([
					'ndctotd.id_ndcxxmh as id_ndcxxmh_old'
				] )
				->where('ndctotd.id', $id )
				->exec();
			$rs_ndctotd = $qs_ndctotd->fetch();
			$id_ndcxxmh_old = $rs_ndctotd['id_ndcxxmh_old'];

			if($id_ndcxxmh_old != $values['ndctotd']['id_ndcxxmh']){
				// jika value berubah
				// update document_state lama menjadi 1
				ndcxxmh_update( $editor->db(), 1, $id, $values );
			}
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			ndcxxmh_update( $editor->db(), 0, $id, $values );
		})
		->on('preRemove',function( $editor, $id, $values ) {
			ndcxxmh_update( $editor->db(), 1, $id, $values );
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>