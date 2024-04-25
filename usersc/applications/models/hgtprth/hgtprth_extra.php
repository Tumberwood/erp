<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) {
			// script diletakkan disini
		})
		->on('preEdit',function( $editor, $id, $values ) {
		})
		->on('postEdit',function( $editor, $id, $values, $row ) {
			$jam_disetujui = $values['htoxxth']['jam_disetujui'];
			
			// $qs_htoxxth = $editor->db()
			// 	->query('select', 'htoxxth' )
			// 	->get(['jam_disetujui'] )
			// 	->where('id', $id )
			// 	->exec();
			// $rs_htoxxth = $qs_htoxxth->fetch();

			// $jam_disetujui_old = $rs_htoxxth['jam_disetujui'];

			if ($jam_disetujui > 0) {
				$qu_hto = $editor->db()
					->query('update', 'htoxxth')
					->set('approval_state',1)
					->where('id',$id)
					->exec();

				$qi_htoxxrd = $editor->db()
					->raw()
					->bind(':id', $id)
					->exec('INSERT INTO htoxxrd (
								id_transaksi_h,
								id_users,
								id_hemxxmh,
								tanggal,
								durasi_lembur_jam,
								durasi_lembur_menit
							) 
							SELECT
								a.id,
								a.id_users,
								a.id_hemxxmh,
								a.tanggal_dibuat,
								a.jam_disetujui,
								a.jam_disetujui * 60 AS durasi_lembur_menit
							FROM htoxxth a
							WHERE a.id = :id
							'
				);
			}
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>