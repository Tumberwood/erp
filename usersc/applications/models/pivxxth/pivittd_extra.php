<?php
	use 
		SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row )  use ($nama_table, $nama_table_before) {
			include('../../models/wreittd/wreittd_fn_konversi_terkecil.php');
			General::konversiUom2( $editor->db(), 'pivittd', $id );
			$id_pivxxth = $values['pivittd']['id_pivxxth'];
			
			// $qs_def = $editor->db()
			// ->raw()
			// ->bind(':id_pivxxth', $id_pivxxth)
			// ->exec('    UPDATE isoittd_upload AS b
			// 			LEFT JOIN (
			// 				SELECT
			// 					a.id_isoittd_upload,
			// 					SUM(a.diskon_final) AS sum_diskon_final,
			// 					SUM(a.pajak_final) AS sum_pajak_final
			// 				FROM isoittd_upload_fisik AS a
			// 				WHERE a.id_isoittd_upload = :id_h
			// 			) AS c ON c.id_isoittd_upload = b.id
			// 			SET 
			// 				b.fisik = sum_fisik,
			// 				b.selisih = sum_fisik - b.jumlah_terkecil,
			// 				b.selisih_final = sum_fisik + ifnull(b.transaksi_out,0) - b.jumlah_terkecil -ifnull( b.transaksi_in,0)
			// 			WHERE b.id = :id_h
			// ');
		})
		->on('preEdit',function( $editor, $id, $values ) {
			// General::kalkulasiJumlahTransaksiBefore2( $editor->db(), $id, $values, 'Edit', 'pivittd', 'prcittd' );
			// General::isNextProcess( $editor->db(), 'prqxxth', 'prqittd', 'pivittd', $id, 'EDIT', $values );
		})
		->on('postEdit',function( $editor, $id, $values, $row )  use ($nama_table, $nama_table_before) {
			include('../../models/wreittd/wreittd_fn_konversi_terkecil.php');
			General::konversiUom2( $editor->db(), 'pivittd', $id );
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// General::isNextProcess( $editor->db(), 'prqxxth', 'prqittd', 'pivittd', $id, 'REMOVE', $values );
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>