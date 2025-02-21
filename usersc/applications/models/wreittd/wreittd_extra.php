<?php

	use
        SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row )  use ($nama_table, $nama_table_before) {
			General::isNextProcess( $editor->db(), '', 'wlpxxmh', 'wreittd', $id, 'CREATE', $values );
			General::konversiUom( $editor->db(), 'wreittd', $id );
			General::kalkulasiJumlahTransaksiBefore2( $editor->db(), $id, $values, 'Create', 'wreittd', 'wroittd' );
		})
		->on('preEdit',function( $editor, $id, $values ) {
			General::isNextProcess( $editor->db(), '', 'wlpxxmh', 'wreittd', $id, 'EDIT', $values );
			General::kalkulasiJumlahTransaksiBefore2( $editor->db(), $id, $values, 'Edit', 'wreittd', 'wroittd' );
		})
		->on('postEdit',function( $editor, $id, $values, $row )  use ($nama_table, $nama_table_before) {
			General::konversiUom( $editor->db(), 'wreittd', $id );
		})
		->on('preRemove',function( $editor, $id, $values ) {
			General::isNextProcess( $editor->db(), '', 'wlpxxmh', 'wreittd', $id, 'REMOVE', $values );

			$imtxxmh_kode = 112;

			$qi_iivxxrd = $editor->db()
			->raw()
			->bind(':id', $id)
			->exec('
				INSERT INTO iivxxrd (
					id_transaksi_h,
					id_transaksi_d,
					id_gcpxxmh,
					id_gbrxxmh,
					id_iwhxxmh,
					id_wloctmh,
					id_wloxxmh,
					id_relasi_m,
					id_iimxxmh,
					id_iumxxmh_unit,
					id_iumxxmh_terkecil,
					id_iumxxmh_default,
					kode,
					keterangan,
					confirmed_at,
					created_by,
					gcpxxmh_kode,
					gcpxxmh_nama,
					gbrxxmh_kode,
					gbrxxmh_nama,
					iwhxxmh_kode,
					iwhxxmh_nama,
					wloxxmh_kode,
					wloxxmh_nama,
					relasi_m_kode,
					relasi_m_nama,
					iimxxmh_kode,
					iimxxmh_nama,
					iumxxmh_unit_kode,
					iumxxmh_unit_nama,
					iumxxmh_terkecil_kode,
					iumxxmh_terkecil_nama,
					iumxxmh_default_kode,
					iumxxmh_default_nama,
					imtxxmh_kode,
					imtxxmh_movement_type,
					tanggal,
					is_fisik,
					jumlah_unit,
					jumlah_konversi,
					jumlah_terkecil,
					jumlah_default,
					wlpxxmh_kode,
					wpaxxmh_kode,
					expired_date,
					batch_number
				)
				SELECT
					a.id as id_transaksi_h,
					a.id as id_transaksi_d,
					a.id_gcpxxmh as id_gcpxxmh,
					a.id_gbrxxmh as id_gbrxxmh,
					a.id_iwhxxmh as id_iwhxxmh,
					wloxxmh.id_wloctmh as id_wloctmh,
					a.id_wloxxmh as id_wloxxmh,
					a.id_grlxxmh_supplier as id_relasi_m,
					a.id_iimxxmh,
					a.id_iumxxmh_unit,
					a.id_iumxxmh_terkecil,
					a.id_iumxxmh_default,
					a.kode,
					a.keterangan,
					"now()",
					a.created_by,
					gcpxxmh.kode,
					gcpxxmh.nama,
					gbrxxmh.kode,
					gbrxxmh.nama,
					iwhxxmh.kode,
					iwhxxmh.nama,
					wloxxmh.kode,
					wloxxmh.nama,
					grlxxmh.kode,
					grlxxmh.nama,
					iimxxmh.kode,
					iimxxmh.nama,
					iumxxmh_unit.kode,
					iumxxmh_unit.nama,
					iumxxmh_terkecil.kode,
					iumxxmh_terkecil.nama,
					iumxxmh_default.kode,
					iumxxmh_default.nama,
					'.$imtxxmh_kode.' as imtxxmh_kode,
					imtxxmh.movement_type,
					"curdate()",
					1 as is_fisik,
					- a.jumlah_unit as jumlah_unit,
					a.jumlah_konversi as jumlah_konversi,
					- a.jumlah_terkecil as jumlah_terkecil,
					- a.jumlah_default as jumlah_default,
					a.wlpxxmh_kode,
					a.wpaxxmh_kode,
					a.expired_date,
					a.batch_number
				FROM wreittd a
				LEFT JOIN gcpxxmh ON gcpxxmh.id = a.id_gcpxxmh
				LEFT JOIN gbrxxmh ON gbrxxmh.id = a.id_gbrxxmh
				LEFT JOIN iwhxxmh ON iwhxxmh.id = a.id_iwhxxmh
				LEFT JOIN wloxxmh ON wloxxmh.id = a.id_wloxxmh
				LEFT JOIN grlxxmh ON grlxxmh.id = a.id_grlxxmh_supplier
				LEFT JOIN iimxxmh ON iimxxmh.id = a.id_iimxxmh
				LEFT JOIN iumxxmh as iumxxmh_unit ON iumxxmh_unit.id = a.id_iumxxmh_unit
				LEFT JOIN iumxxmh as iumxxmh_terkecil ON iumxxmh_terkecil.id = a.id_iumxxmh_terkecil
				LEFT JOIN iumxxmh as iumxxmh_default ON iumxxmh_default.id = a.id_iumxxmh_default
				LEFT JOIN imtxxmh as imtxxmh ON imtxxmh.kode = '.$imtxxmh_kode.'
				WHERE a.id = :id
			');
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>