<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
			$kode = $values['isoxxth_upload']['kode'];
			$tanggal = $values['isoxxth_upload']['tanggal'];
			$id_iwhxxmh = $values['isoxxth_upload']['id_iwhxxmh'];

			$qi_header = $editor->db()
				->query('insert', 'isoxxth_upload')
				->set('id_iwhxxmh',$id_iwhxxmh)
				->set('kode',$kode)
				->set('tanggal',$tanggal)
				->set('id_gcpxxmh',1)
				->set('id_gbrxxmh',1)
				->set('transaction_state',1)
				->exec();
			
			//Ambil id last insert
			$id_header = $qi_header->insertId();

			$qu_detail = $editor->db()
				->query('update', 'isoittd_upload')
				->set('id_isoxxth_upload',$id_header)
				->where('id',$id)
				->exec();
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
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