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

	$id_transaksi = $_POST['id_transaksi'];

		try{
			$db->transaction();

			
			$qs_ggshrsh = $db
				->query('select', 'ggshrsh' )
				->get(['is_autocreateusers'] )
				->where('id', 1 )
				->exec();
			$rs_ggshrsh = $qs_ggshrsh->fetch();
			$is_autocreateusers = $rs_ggshrsh['is_autocreateusers'];

			if ($is_autocreateusers == 1) {
				$qs_hemxxmh = $db
					->query('select', 'hemxxmh')
					->get([
						'hemxxmh.kode as kode',
						'hemjbmh.id_gcpxxmh as id_gcpxxmh',
						'hemjbmh.id_gbrxxmh as id_gbrxxmh',
						'hemxxmh.fname as fname',
						'hemxxmh.lname as lname'
					])
					->join('hemjbmh','hemjbmh.id_hemxxmh = hemxxmh.id','LEFT' )
					->where('hemxxmh.id',$id_transaksi)
					->exec();
				$rs_hemxxmh = $qs_hemxxmh->fetch();

				$kode       = $rs_hemxxmh['kode'] ;
				$id_gcpxxmh       = $rs_hemxxmh['id_gcpxxmh'] ;
				$id_gbrxxmh       = $rs_hemxxmh['id_gbrxxmh'] ;
				$fname       = $rs_hemxxmh['fname'] ;
				$lname       = $rs_hemxxmh['lname'] ;
				$email      = $kode . '@solusi-indonesia.com';
	
				$harini = new Carbon();
	
				// BEGIN create user
				$qs_users = $db
					->query('insert', 'users' )
					->set('username', $kode )
					->set('fname', $fname )
					->set('lname', $lname )
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
					->where('id', $id_transaksi )
					->exec();
	
				$user_permission_matches = $db
					->query('insert', 'user_permission_matches')
					->set('user_id',$id_users)
					->set('permission_id', 1)
					->exec();
	
				$user_permission_matches = $db
					->query('insert', 'user_permission_matches')
					->set('user_id',$id_users)
					->set('permission_id', 27)
					->exec();

				//Data Permission
				$user_udp = $db
					->query('insert', 'udpxxsh')
					->set('id_users',$id_users)
					->set('id_gcpxxmh',$id_gcpxxmh)
					->set('id_gbrxxmh',$id_gbrxxmh)
					->set('data_permission', 1)
					->set('transaction_state', 1)
					->exec();
					
				$id_udpxxsh = $user_udp->insertId();
				
				// cek user_permission_matches
				$rq_user_permission_matches = $db
					->query('select', 'user_permission_matches')
					->get('permission_id as permission_id')
					->where( 'user_id', $id_users)
					->exec();
				$rss_user_permission_matches = $rq_user_permission_matches->fetchAll();
				
				$arr_permission_id = array();
				foreach ($rss_user_permission_matches as $row) {
					array_push($arr_permission_id,$row['permission_id']);
				}
				
				// select id_pages yang sudah ada
				$qs_ucudasd_in = $db
					->query('select', 'ucudasd')
					->get('id_pages')
					->where('id_users',$id_users)
					->exec();
				$rss_ucudasd_in = $qs_ucudasd_in->fetchAll();
				$arr_id_pages = array();
				foreach ($rss_ucudasd_in as $row) {
					array_push($arr_id_pages,$row['id_pages']);
				}
				
				// cek permission_page_matches
				// id_pages yang sudah ada di ucudasd tidak dipilih lagi 
				$rs_permission_page_matches = $db
					->query('select', 'permission_page_matches')
					->get('permission_page_matches.page_id as page_id')
					->join('pages', 'pages.id=permission_page_matches.page_id','LEFT')
					->join('pages_extend', 'pages_extend.id=pages.id','LEFT')
					->where_in( ' permission_page_matches.permission_id', $arr_permission_id)
					->where_in( ' permission_page_matches.page_id NOT', $arr_id_pages)
					->where( 'pages_extend.is_setting', 0)
					->where( 'pages_extend.is_crud', 1)
					->exec();
				$rss_permission_page_matches = $rs_permission_page_matches->fetchAll();

				if(count($rss_permission_page_matches) > 0){
					// INSERT data pages baru
					foreach ($rss_permission_page_matches as $row) {
						$qi_ucudasd = $db
							->query('insert', 'ucudasd')
							->set('id_udpxxsh',$id_udpxxsh)
							->set('id_users', $id_users)
							->set('id_pages', $row['page_id'])
							->exec();
					}

					$c_newpage = count($rss_permission_page_matches);
					$messsage_newpage = ' ' . $c_newpage . ' pages baru berhasil ditambahkan.';
				}
			}

			//insert saldo cuti
			$qi_saldo = $db
			->raw()
			->exec('INSERT INTO httxxrd (
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
						FROM httxxrd AS rh
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
			$status_code  = 200;
			$message = "Confirm Berhasil ";
			$type_message = "success";
		}catch(PDOException $e){
			// rollback on error
			$db->rollback();
			$status_code  = 500;
			$message = "Confirm Gagal ";
			$type_message = 'error';
		}

		// build response
		$data = array(
			'status_code'    => $status_code,
			'message'        => $message,
			'type_message'   => $type_message
		);	
	
		// tampilkan results
		include( "../../../../usersc/helpers/fn_ajax_results.php" );
	
?>