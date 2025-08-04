<?php

	use
        SolusiIndonesia\Utilities\General;

    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) use ($nama_table) {
			General::konversiUom($editor->db(), $nama_table, $id);
			$wlpxxmh_kode = $values['wptittd']['wlpxxmh_kode'];

			$qs_wreittd = $editor->db()
				->query('select', 'wreittd' )
				->get(['id'] )
				->where('transaction_state', 1 )
				->where('wlpxxmh_kode', $wlpxxmh_kode )
				->exec();
			$rs_wreittd = $qs_wreittd->fetch();
			$id_wreittd = $rs_wreittd['id'];

			$qu_wptittd = $editor->db()
				->query('update', 'wptittd')
				->set('id_wreittd',$id_wreittd)
				->where('id',$id)
				->exec();
				
			General::isNextProcess( $editor->db(), '', 'wreittd', 'wptittd', $id, 'CREATE', $values );

			//Update Status Drive IN (IN | OUT | NETRAL)
			$qs_loc = $editor->db()
				->raw()
				->bind(':id', $id)
				->exec('SELECT
							a.id_wloxxmh_tujuan,
							b.id_iwhxxmh,
							b.id_wloctmh,
							b.id_wlotpmh,
							b.id_wloznmh,
							b.rack_name,
							b.bay_name
						FROM wptittd a
						INNER JOIN wloxxmh b ON b.id = a.id_wloxxmh_tujuan
						WHERE a.id = :id
			');
			$rs_loc = $qs_loc->fetch();

			if (!empty($rs_loc)) {
				//Cari max depth dan max level untuk rack dan bay ini.
				$qs_max_wloxxmh = $editor->db()
					->raw()
					->bind(':id_iwhxxmh', $rs_loc['id_iwhxxmh'])
					->bind(':id_wloctmh', $rs_loc['id_wloctmh'])
					->bind(':id_wlotpmh', $rs_loc['id_wlotpmh'])
					->bind(':id_wloznmh', $rs_loc['id_wloznmh'])
					->bind(':rack_name', $rs_loc['rack_name'])
					->bind(':bay_name', $rs_loc['bay_name'])
					->exec('SELECT id
							FROM wloxxmh
							WHERE id_iwhxxmh = :id_iwhxxmh
								AND id_wloctmh = :id_wloctmh
								AND id_wlotpmh = :id_wlotpmh
								AND id_wloznmh = :id_wloznmh
								AND rack_name = :rack_name
								AND bay_name = :bay_name
							ORDER BY depth DESC, `level` DESC
							LIMIT 1
				');
				$rs_max_wloxxmh = $qs_max_wloxxmh->fetch();

				if (!empty($rs_max_wloxxmh)) {
					//cek apakah last depth & level sudah ada isinya, ini cek apakah bay sudah penuh
					$qs_inv = $editor->db()
						->raw()
						->bind(':id_wloxxmh', $rs_max_wloxxmh['id'])
						->exec('SELECT
									a.id_wloxxmh
								FROM iivxxrd a
								WHERE a.id_wloctmh = 3 AND a.is_fisik = 1
								GROUP BY a.id_wloxxmh
								HAVING SUM(a.jumlah_terkecil) > 0 AND a.id_wloxxmh = :id_wloxxmh
					');
					$rs_inv = $qs_inv->fetch();

					//jika sudah penuh, maka netral
					if (!empty($rs_inv)) {
						$status_drive_in = 'netral';
					} else {
						$status_drive_in = 'in';
					}

					$qu_loc = $editor->db()
						->query('update', 'wloxxmh')
						->set('status_drive_in',$status_drive_in)
						->where('id_iwhxxmh',$rs_loc['id_iwhxxmh'])
						->where('id_wloctmh',$rs_loc['id_wloctmh'])
						->where('id_wlotpmh',$rs_loc['id_wlotpmh'])
						->where('id_wloznmh',$rs_loc['id_wloznmh'])
						->where('rack_name',$rs_loc['rack_name'])
						->where('bay_name',$rs_loc['bay_name'])
						->where('status_drive_in',"in", "<>")
					->exec();
				}
			}

		})
		->on('preEdit',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postEdit',function( $editor, $id, $values, $row ) use ($nama_table) {
			General::konversiUom($editor->db(), $nama_table, $id);
		})
		->on('preRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		})
		->on('postRemove',function( $editor, $id, $values ) {
			// script diletakkan disini
		});
?>