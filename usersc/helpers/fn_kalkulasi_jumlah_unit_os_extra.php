<?php
	
	//Extra kalkulasi jumlah_unit_os
	// $nama_table_d = 'prcittd';
	// $nama_table_d_before = 'podittd';
	// include( "../../../helpers/fn_kalkulasi_jumlah_unit_os_extra.php" );

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) use ($nama_table_d, $nama_table_d_before) {
			$id_transaksi_d_before = $values[$nama_table_d]['id_'.$nama_table_d_before];
			$jumlah_unit = $values[$nama_table_d]['jumlah_unit'];

			//select unit podittd dan id_proyek
			$s_transaksi_os = $editor->db()
			->raw()
			->bind(':id_transaksi_d_before', $id_transaksi_d_before)
			->exec(' SELECT
						b.jumlah_unit AS jumlah_unit,
						b.jumlah_unit_next AS jumlah_unit_next					
					FROM '.$nama_table_d.' AS a
					LEFT JOIN '.$nama_table_d_before.' AS b ON b.id = a.id_'.$nama_table_d_before.'
					WHERE b.id = :id_transaksi_d_before
					'
					);
			$sel_transaksi_os = $s_transaksi_os->fetch();

			//Hitung unit next
			$jumlah_unit_next = $sel_transaksi_os['jumlah_unit_next'] + $jumlah_unit;
			//Hitung unit OS
			$jumlah_unit_os = $sel_transaksi_os['jumlah_unit'] - $jumlah_unit_next;

			//edit podittd unit next dan os
			$edit_podittd = $editor->db()
				->query('update', $nama_table_d_before)
				->set('jumlah_unit_next',$jumlah_unit_next)
				->set('jumlah_unit_os',$jumlah_unit_os)
				->where('id', $id_transaksi_d_before )
			->exec();
			
			//Mengupdate OS dan Next Detail item PRC
			$edit_prcittd = $editor->db()
				->query('update', $nama_table_d)
				->set('jumlah_unit_next',0)
				->set('jumlah_unit_os',$jumlah_unit)
				->where('id', $id )
			->exec();
		})
		->on('preEdit',function( $editor, $id, $values ) use ($nama_table_d, $nama_table_d_before) {
			$id_transaksi_d_before = $values[$nama_table_d]['id_'.$nama_table_d_before];
			$jumlah_unit = $values[$nama_table_d]['jumlah_unit'];

			//select unit podittd dan id_proyek
			$s_transaksi_os = $editor->db()
			->raw()
			->bind(':id_transaksi_d_before', $id_transaksi_d_before)
			->exec(' SELECT
						b.jumlah_unit AS jumlah_unit,
						b.jumlah_unit_next AS jumlah_unit_next					
					FROM '.$nama_table_d_before.' AS b
					WHERE b.id = :id_transaksi_d_before
					'
					);
			$sel_transaksi_os = $s_transaksi_os->fetch();

			//Ambil jumlah unit lama di PRC
			$s_prcittd_old = $editor->db()
			->raw()
			->bind(':id', $id)
			->exec(' SELECT
						a.jumlah_unit AS jumlah_unit
					FROM '.$nama_table_d.' AS a
					WHERE a.id = :id
					'
					);
			$sel_prcittd_old = $s_prcittd_old->fetch();

			//Nilai next podittd dikurangi old value
			$jumlah_unit_next_old = $sel_transaksi_os['jumlah_unit_next'] - $sel_prcittd_old['jumlah_unit'];

			// echo $sel_transaksi_os['jumlah_unit_next'];
			// echo $sel_prcittd_old['jumlah_unit'];
			// echo $jumlah_unit_next_old;
			//Hitung unit next
			$jumlah_unit_next = $jumlah_unit_next_old + $jumlah_unit;
			//Hitung unit OS
			$jumlah_unit_os = $sel_transaksi_os['jumlah_unit'] - $jumlah_unit_next;

			//edit podittd unit next dan os
			$edit_podittd = $editor->db()
				->query('update', $nama_table_d_before)
				->set('jumlah_unit_next',$jumlah_unit_next)
				->set('jumlah_unit_os',$jumlah_unit_os)
				->where('id', $id_transaksi_d_before )
				->exec();

			//Mengupdate OS dan Next Detail item PRC
			$edit_prcittd = $editor->db()
				->query('update', $nama_table_d)
				->set('jumlah_unit_os',$jumlah_unit)
				->where('id', $id )
			->exec();
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			
		})
		->on('preRemove',function( $editor, $id, $values ) use ($nama_table_d, $nama_table_d_before) {
			//Ambil jumlah unit lama di PRC
			$s_prcittd_old = $editor->db()
			->raw()
			->bind(':id', $id)
			->exec(' SELECT
						id_'.$nama_table_d_before.' AS id_detail_item_before,
						a.jumlah_unit AS jumlah_unit
					FROM '.$nama_table_d.' AS a
					WHERE a.id = :id
					'
					);
			$sel_prcittd_old = $s_prcittd_old->fetch();

			$jumlah_unit = $sel_prcittd_old['jumlah_unit'];
			$id_detail_item_before = $sel_prcittd_old['id_detail_item_before'];

			$qu_before_d = $editor->db()
			->raw()
			->bind(':id_detail_item_before', $id_detail_item_before)
			->bind(':jumlah_unit', $jumlah_unit)
			->exec('UPDATE '.$nama_table_d_before.'
					SET 
						jumlah_unit_next = jumlah_unit_next - :jumlah_unit,
						jumlah_unit_os = jumlah_unit_os + :jumlah_unit
					WHERE id = :id_detail_item_before;
					'
					);
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>