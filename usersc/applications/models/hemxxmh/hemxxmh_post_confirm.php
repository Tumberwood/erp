<?php
	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
	include( "../../../../usersc/helpers/datatables_fn_debug.php" );
    require '../../../../usersc/vendor/autoload.php';

    use Carbon\Carbon;
	
	use
		DataTables\Editor,
		DataTables\Editor\Query,
		DataTables\Editor\Result;

	// BEGIN definisi variable untuk fn_ajax_results.php
	$data      = array();
	$rs_opt    = array();
	$c_rs_opt  = 0;
	$morePages = 0;
	// END definisi variable untuk fn_ajax_results.php

	$id_transaksi_h = $_POST['id_transaksi_h'];

		try{
			$db->transaction();
			
			$qs_hemxxmh = $db
				->query('select', 'hemxxmh')
				->get([
					'kode',
					'nama'
				])
				->where('id',$id_transaksi_h)
				->exec();
			$rs_hemxxmh = $qs_hemxxmh->fetch();
			$kode       = $rs_hemxxmh['kode'] ;
			$nama       = $rs_hemxxmh['nama'] ;
			$email      = $kode . '@solusi-indonesia.com';

			$harini = new Carbon();

			// BEGIN create user
			$qs_users = $db
				->query('insert', 'users' )
				->set('username', $kode )
				->set('fname', $nama )
				->set('lname', 'LJI' )
				->set('email', $email )
				->set('password', password_hash('password', PASSWORD_BCRYPT, ['cost' => 12]), )
				->set('permissions', 1)
				->set('email_verified', 1)
				->set('join_date', $harini->format('Y-m-d H:i:s') )
				->set('vericode', randomstring(15) )
				->exec();

			$id_users = $qs_users->insertId();

			$qu_hemxxmh = $db
				->query('update', 'hemxxmh' )
				->set('id_users', $id_users )
				->where('id', $id_transaksi_h )
				->exec();

			$user_permission_matches = $db
				->query('insert', 'user_permission_matches')
				->set('user_id',$id_users)
				->set('permission_id', 1)
				->exec();

			$user_permission_matches = $db
				->query('insert', 'user_permission_matches')
				->set('user_id',$id_users)
				->set('permission_id', 5)
				->exec();

			//Data Permission
			$user_udp = $db
				->query('insert', 'udpxxsh')
				->set('id_users',$id_users)
				->set('data_permission', 1)
				->exec();

			//insert saldo cuti
			$qi_saldo = $db
			->raw()
			->exec('INSERT INTO htlxxrh (
						id_hemxxmh,
						saldo,
						tanggal,
						jumlah,
						nama
					)
					SELECT
						b.id_hemxxmh,
						IF( YEAR(b.tanggal_masuk) <> YEAR(CURDATE()) AND DATE_ADD(b.tanggal_masuk, INTERVAL 1 YEAR) < CURDATE(), 
							IF(
								TIMESTAMPDIFF(MONTH, b.tanggal_masuk, DATE_FORMAT(CURDATE(), "%Y-01-01")) >= 12,
								12,
								12 - MONTH(b.tanggal_masuk)
							),
							0
						) 
						AS saldo,
						CURDATE() AS tanggal,
						ifnull(c_id,0) AS c_id,
						"saldo"
					FROM
						hemxxmh AS a
					LEFT JOIN
						hemjbmh AS b ON b.id_hemxxmh = a.id
	
					LEFT JOIN (
						SELECT
							rh.id_hemxxmh,
							COUNT(rh.id) AS c_id
						FROM htlxxrh AS rh
						WHERE year(rh.tanggal) = YEAR(CURDATE()) AND rh.nama = "saldo"
						GROUP BY id_hemxxmh
					) AS c ON c.id_hemxxmh = a.id
					WHERE
						a.transaction_state = 1 AND b.id_hemxxmh > 0
					GROUP BY id_hemxxmh
					HAVING c_id = 0
					;				
					'
			);

			$db->commit();
			$data = array(
				'id_transaksi_h'=>$id_transaksi_h
			);
		}catch(PDOException $e){
			// rollback on error
			$db->rollback();
		}
?>