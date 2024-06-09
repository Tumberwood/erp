<?php
	/** 
	 * 240608 - 3.0.0
	 * - Mengubah menggunakan class
	 * 
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

	use
        SolusiIndonesia\Utilities\General;

	$editor
		// input activity_log_ml on Add
		->on('postCreate',function( $editor, $id, $values, $row ) use ($nama_table, $s_id_users, $s_username) {
			General::logChange( $editor->db() , $nama_table, $s_id_users, $s_username, 'CREATE', $id, $values, $values[$nama_table]['start_at'] , $values[$nama_table]['finish_at'] );
		})
		// input activity_log_ml on Edit
		->on('postEdit',function( $editor, $id, $values, $row ) use ($nama_table, $s_id_users, $s_username) {
			General::logChange( $editor->db() , $nama_table, $s_id_users, $s_username, 'EDIT', $id, $values, $values[$nama_table]['start_at'] , $values[$nama_table]['finish_at'] );
		})
		// input activity_log_ml on Delete
		->on( 'preRemove', function ( $editor, &$id, &$values ) use ($nama_table, $s_id_users, $s_username) {
			General::logChange( $editor->db() , $nama_table, $s_id_users, $s_username, 'REMOVE', $id, $values, $values[$nama_table]['start_at'] , $values[$nama_table]['finish_at'] );
		})
?>