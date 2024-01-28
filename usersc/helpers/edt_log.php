<?php
	/** 
	 * 231010 - 2.1.0
	 * - Mengubah menjadi function logChange
	 * - start_at dan finish_at dicatatkan di table database lewat field start_at dan finish_at
	 * 
	 * 230210 - 2.0.1
	 * - Mengubah finish_at diisi dari editor form, karena jika beda timezone, perhitungan durasi akan salah
	 * 
	 * 230101 - 2.0.0
	 * - Mencatatkan durasi finish_at, untuk mengetahui durasi_detik
	
	*/

	function logChange ( $db, $nama_table, $s_id_users, $s_username, $action, $id, &$values )  {
		$start_at     = date('Y-m-d H:i:s', strtotime($values[$nama_table]['start_at']));
		$finish_at    = date('Y-m-d H:i:s', strtotime($values[$nama_table]['finish_at']));
		$durasi_detik = strtotime($finish_at) - strtotime($start_at);

		$db->insert( 'activity_log_ml', array(
			'id_transaksi' 	=> $id,
			'kode' 			=> $action,
			'nama' 			=> $nama_table,
			'keterangan' 	=> json_encode($values, JSON_UNESCAPED_SLASHES),
			'created_by'   	=> $s_id_users,
			'username'   	=> $s_username,
			'start_on'   	=> $start_at,
			'finish_on'   	=> $finish_at,
			'durasi_detik'  => $durasi_detik
		) );
	}
	

	$editor
		// input activity_log_ml on Add
		->on('postCreate',function( $editor, $id, $values, $row ) use ($nama_table, $s_id_users, $s_username) {
			logChange( $editor->db(), $nama_table, $s_id_users, $s_username, 'CREATE', $id, $values );
		})
		// input activity_log_ml on Edit
		->on('postEdit',function( $editor, $id, $values, $row ) use ($nama_table, $s_id_users, $s_username) {
			logChange( $editor->db(), $nama_table, $s_id_users, $s_username, 'EDIT', $id, $values );
		})
		// input activity_log_ml on Delete
		->on( 'preRemove', function ( $editor, &$id, &$values ) use ($nama_table, $s_id_users, $s_username) {
			logChange( $editor->db(), $nama_table, $s_id_users, $s_username, 'DELETE', $id, $values );
		})
?>