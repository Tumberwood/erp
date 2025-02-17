<?php
    $editor
		->on('preCreate',function( $editor, $values ) {
			// script diletakkan disini
		})
		->on('postCreate',function( $editor, $id, $values, $row ) use ($s_id_users){
			$saldo_awal = $values['aakxxmh']['saldo_awal'];
			$nama = $values['aakxxmh']['nama'];
			$saldo_awal_tanggal = date('Y-m-d', strtotime($values['aakxxmh']['saldo_awal_tanggal']));
			$keterangan = "Master aakxxmh = ". $nama;
			
			$rs_header['tanggal'] = date('Y-m-d');
			$db =  $editor->db();
			// BEGIN generate kode JV
			include_once("../../../../usersc/helpers/kode_fn_generate_jv.php");
			// END generate kode JV
			
			if ($saldo_awal > 0) {
				$sql_insert_aglxxth = $editor->db()
					->raw()
					->bind(':saldo_awal_tanggal', $saldo_awal_tanggal)
					->bind(':s_id_users', $s_id_users)
					->bind(':kode', $kode)
					->bind(':id', $id)
					->exec('INSERT INTO aglxxth (
								id_gbrxxmh,
								id_transaksi_h,
								kode,
								created_by,
								start_at,
								finish_at,
								tanggal,
								keterangan,
								jenis_transaksi,
								kode_transaksi,
								total_debit,
								total_kredit
							)
							SELECT
								0,
								a.id,
								:kode,
								:s_id_users,
								NOW(),
								NOW(),
								:saldo_awal_tanggal,
								CONCAT("Master aakxxmh = ", a.nama) keterangan,
								"Chart of Account",
								a.kode,
								a.saldo_awal,
								a.saldo_awal
							FROM aakxxmh a
							WHERE a.id = :id
				');
				
				$last_id = $sql_insert_aglxxth->insertId();  // ambil id 
					
				// insert Debit
				$qi_debit = $editor->db()
					->query('insert', 'aglaktd')
					->set('id_aglxxth', $last_id)
					->set('id_aakxxmh', $id)
					->set('id_transaksi_d', 0 )
					->set('created_by',$s_id_users)
					->set('start_at',date('Y-m-d H:i:s') )
					->set('finish_at',date('Y-m-d H:i:s') )
					->set('keterangan',$keterangan)
					->set('debit_kredit', 'Debit')
					->set('debit', $saldo_awal)
					->set('kredit', 0)
					->exec()
				;

				$qs_ggsaksh = $editor->db()
					->query('select', 'ggsaksh' )
					->get(['id_aakxxmh_ekuitas'] )
					->where('id', 1 )
					->exec();
				$rs_ggsaksh = $qs_ggsaksh->fetch();
				$id_aakxxmh_ekuitas = $rs_ggsaksh['id_aakxxmh_ekuitas'];
					
				// insert Kredit
				$qi_kredit = $editor->db()
					->query('insert', 'aglaktd')
					->set('id_aglxxth', $last_id)
					->set('id_aakxxmh', $id_aakxxmh_ekuitas)
					->set('id_transaksi_d', 0 )
					->set('created_by',$s_id_users)
					->set('start_at',date('Y-m-d H:i:s') )
					->set('finish_at',date('Y-m-d H:i:s') )
					->set('keterangan',$keterangan)
					->set('debit_kredit', 'Kredit')
					->set('debit', 0)
					->set('kredit', $saldo_awal)
					->exec()
				;
			}
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