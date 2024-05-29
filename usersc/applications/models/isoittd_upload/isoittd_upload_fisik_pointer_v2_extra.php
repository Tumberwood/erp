<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
			$id_h = $values['isoittd_upload_fisik']['id_isoittd_upload'];
			$foto = $values['foto'];
			$filePath = '../../../files/isoxxth_pointer/';
			$imageUrl  = $filePath.$foto.'.jpg';
			$filename = $foto.'.jpg';
			
			
			if (file_exists($imageUrl)) {
				// Get file information
				$fileInfo = stat($imageUrl);
				$web_path = '/erpx/usersc/files/isoxxth_pointer/'.$foto.'.jpg';
				
				// Get file extension
				$extn = pathinfo($imageUrl, PATHINFO_EXTENSION);
				$system_path = str_replace('\\', '/', realpath($imageUrl));
				$filesize = $fileInfo['size'];

				$qi_files = $editor->db()
					->query('insert', 'files')
					->set('filename',$filename)
					->set('filesize',$filesize)
					->set('web_path',$web_path)
					->set('system_path',$system_path)
					->set('extn',$extn)
					->exec();
				$id_files = $qi_files->insertId();

				$qi_files = $editor->db()
					->query('insert', 'filestr')
					->set('id_files',$id_files)
					->set('id_transaksi',$id)
					->exec();
			}

			$qu_def = $editor->db()
            ->raw()
            ->bind(':id_h', $id_h)
            ->exec('    UPDATE isoittd_upload AS b
                        SET 
                            b.is_skip = 0
                        WHERE b.id = :id_h
        	');

			$qu_header_fisik = $editor->db()
				->raw()
				->bind(':id_h', $id_h)
				->exec('    UPDATE isoittd_upload AS b
							INNER JOIN (
								SELECT
									a.id_isoittd_upload,
									SUM(a.fisik) AS sum_fisik
								FROM isoittd_upload_fisik AS a
								WHERE a.id_isoittd_upload = :id_h
							) AS c ON c.id_isoittd_upload = b.id
							SET 
								b.fisik = sum_fisik,
								b.selisih = sum_fisik - b.jumlah_terkecil
							WHERE b.id = :id_h
			');

		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>