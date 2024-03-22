<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) use ($s_id_users, $s_username) {
			$fisik = $values['isoittd_upload']['fisik'];
			$start_button = $values['isoittd_upload']['start_at'];

			$qi_fisik = $editor->db()
				->query('insert', 'isoittd_upload_fisik')
				->set('fisik',$fisik)
				->set('id_isoittd_upload',$id)
				->exec();

			$id_det = $qi_det->insertId();
				
			$qu_header = $editor->db()
				->query('update', 'isoittd_upload')
				->set('selisih',$fisik)
				->where('id',$id)
				->exec();
			
			$end = date('Y-m-d H:i:s');
			$durasi_detik = strtotime($end) - strtotime($start_button);

			$qi_log = $editor->db()
				->raw()
				->bind(':id_users', $s_id_users)
				->bind(':username', $s_username)
				->bind(':start_button', $start_button)
				->bind(':end', $end)
				->bind(':durasi_detik', $durasi_detik)
				->bind(':id_det', $id_det)
				->exec('INSERT INTO activity_log_ml
					(
						id_transaksi,
						kode,
						nama,
						keterangan,
						created_by,
						username,
						start_on,
						finish_on,
						durasi_detik
					)
					SELECT 
						:id_det,
						"CREATE",
						"isoittd_upload_fisik",	
						"DARI CREATE ISOITTD HEADER",
						:id_users,
						:username,
						:start_button,
						:end,
						:durasi_detik
				'
			);
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