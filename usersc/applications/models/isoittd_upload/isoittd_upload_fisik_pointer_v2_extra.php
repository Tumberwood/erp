<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
			$id_h = $values['isoittd_upload_fisik']['id_isoittd_upload'];
			$kode = $values['isoittd_upload_fisik']['kode'];
			$foto = $values['foto'];
			$filePath = '../../../files/isoxxth_pointer/';
			$imageUrl  = $filePath.$foto.'.jpg';
			$filename = $foto.'.jpg';
			
			$qs_path = $editor->db()
				->raw()
				->exec('SELECT
							CONCAT("/", SUBSTRING_INDEX(a.genpath, "/applications", 1)) AS genpath
						FROM ggsxxsh a
			');
			$rs_path = $qs_path->fetch();
			$genpath = $rs_path['genpath'];

			$qs_iso_td = $editor->db()
				->query('select', 'isoittd_upload' )
				->get([
					'id_files_pointer',
					'id_isoxxth_upload'
					] )
				->where('id', $id_h )
				->exec();
			$rs_iso_td = $qs_iso_td ->fetch();
			$id_files_pointer = $rs_iso_td['id_files_pointer'];
			$id_isoxxth_upload = $rs_iso_td['id_isoxxth_upload'];

			//Jika gambar pointer sudah diisi
			if ($id_files_pointer > 0) {
				$qs_pointer = $editor->db()
					->raw()
					->bind(':id_files_pointer', $id_files_pointer)
					->bind(':id_isoxxth_upload', $id_isoxxth_upload)
					->exec('SELECT
								a.id
							FROM isoittd_upload a
							WHERE a.id_isoxxth_upload = :id_isoxxth_upload AND a.id_files_pointer = :id_files_pointer 
					');
				$rs_pointer = $qs_pointer->fetchAll();
				
				if (file_exists($imageUrl)) {
					
					foreach ($rs_pointer as $key => $pointer_td) {
						$id_isoittd = $pointer_td['id'];
						
						$qd_isoittd_upload_fisik = $editor->db()
							->raw()
							->bind(':kode', $kode)
							->bind(':id_isoittd', $id_isoittd)
							->exec('DELETE FROM isoittd_upload_fisik
									WHERE id_isoittd_upload = :id_isoittd
									AND is_pointer = 1
									AND (kode IS NULL OR kode <> :kode);
						');
	
						// Get file information
						$fileInfo = stat($imageUrl);
						$web_path = $genpath.'/files/isoxxth_pointer/'.$foto.'.jpg';
						
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
						
						if ($id_isoittd != $id_h) {
							$qi_fisik = $editor->db()
							->raw()
							->bind(':id_isoittd', $id_isoittd)
							->bind(':id', $id)
							->exec('INSERT INTO isoittd_upload_fisik 
									(
										id_isoittd_upload,
										is_pointer,
										jumlah_konversi,
										jumlah_unit,
										fisik,
										kode,
										keterangan_pointer
									)
									SELECT 
										:id_isoittd,
										is_pointer,
										jumlah_konversi,
										jumlah_unit,
										fisik,
										kode,
										keterangan_pointer
									FROM isoittd_upload_fisik
									WHERE id = :id;
							');
							$id_insert = $qi_fisik->insertId();
						} else {
							$id_insert = $id;
						}
	
						$qi_files = $editor->db()
							->query('insert', 'filestr')
							->set('id_files',$id_files)
							->set('id_transaksi',$id_insert)
							->exec();
	
						// $qu_def = $editor->db()
						// 	->raw()
						// 	->bind(':id_isoittd', $id_isoittd)
						// 	->exec('    UPDATE isoittd_upload AS b
						// 				SET 
						// 					b.is_skip = 0
						// 				WHERE b.id = :id_isoittd
						// 	');
				
							$qu_header_fisik = $editor->db()
								->raw()
								->bind(':id_isoittd', $id_isoittd)
								->exec('    UPDATE isoittd_upload AS b
											INNER JOIN (
												SELECT
													a.id_isoittd_upload,
													SUM(a.fisik) AS sum_fisik
												FROM isoittd_upload_fisik AS a
												WHERE a.id_isoittd_upload = :id_isoittd
											) AS c ON c.id_isoittd_upload = b.id
											SET 
												b.is_skip = 0,
												b.is_pointer = 1,
												b.fisik = sum_fisik,
												b.selisih_final = sum_fisik - b.jumlah_terkecil,
												b.selisih = sum_fisik - b.jumlah_terkecil
											WHERE b.id = :id_isoittd
							');
					}
				}
			} else {
				$id_isoittd = $id_h;

				$qd_isoittd_upload_fisik = $editor->db()
					->raw()
					->bind(':kode', $kode)
					->bind(':id_isoittd', $id_isoittd)
					->exec('DELETE FROM isoittd_upload_fisik
							WHERE id_isoittd_upload = :id_isoittd
							AND is_pointer = 1
							AND (kode IS NULL OR kode <> :kode);
				');

				// Get file information
				$fileInfo = stat($imageUrl);
				$web_path = $genpath.'/files/isoxxth_pointer/'.$foto.'.jpg';
				
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
				
				$id_insert = $id;

				$qi_files = $editor->db()
					->query('insert', 'filestr')
					->set('id_files',$id_files)
					->set('id_transaksi',$id_insert)
					->exec();

				// $qu_def = $editor->db()
				// 	->raw()
				// 	->bind(':id_isoittd', $id_isoittd)
				// 	->exec('    UPDATE isoittd_upload AS b
				// 				SET 
				// 					b.is_skip = 0
				// 				WHERE b.id = :id_isoittd
				// 	');
		
					$qu_header_fisik = $editor->db()
						->raw()
						->bind(':id_isoittd', $id_isoittd)
						->exec('    UPDATE isoittd_upload AS b
									INNER JOIN (
										SELECT
											a.id_isoittd_upload,
											SUM(a.fisik) AS sum_fisik
										FROM isoittd_upload_fisik AS a
										WHERE a.id_isoittd_upload = :id_isoittd
									) AS c ON c.id_isoittd_upload = b.id
									SET 
										b.is_skip = 0,
										b.is_pointer = 1,
										b.fisik = sum_fisik,
										b.selisih_final = sum_fisik + ifnull(b.transaksi_out,0) - b.jumlah_terkecil -ifnull( b.transaksi_in,0),
										b.selisih = sum_fisik - b.jumlah_terkecil
									WHERE b.id = :id_isoittd
					');
			}

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