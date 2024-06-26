<?php 
    require_once( "../../../../users/init.php" );
    require_once( "../../../../usersc/lib/DataTables.php" );
    require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	require_once( "../../../../usersc/vendor/autoload.php");
	require_once( "../../../helpers/hakakses_s_fn.php" );

	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    // END definisi variable untuk fn_ajax_results.php

    try{
		$db->transaction();
		
		$id_users    = $_POST['id_users'];
		$id_udpxxsh = $_POST['id_udpxxsh'];

		$c_newpage = 0;
		$c_delpage = 0;
		$check = 1;
		$messsage_newpage = '';
		$messsage_delpage = '';

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

		// cek apakah ada id_pages di ucudasd yang sudah tidak ada lagi di table pages
		// jika ada yang sudah tidak ada, berarti pages tersebut sudah dihapus dari web. maka harus dihapus dari ucudasd juga
		$qs_null_pages = $db
			->query('select', 'ucudasd')
			->get('ucudasd.id_pages as id_pages_null')
			->join('pages', 'pages.id = ucudasd.id_pages','LEFT')
			->where( 'pages.id', NULL)
			->exec();
		$rss_null_pages = $qs_null_pages->fetchAll();

		if(count($rss_null_pages) > 0){
			foreach ($rss_null_pages as $row) {
				$qd_null_pages = $db
					->query('delete', 'ucudasd')
					->where( 'ucudasd.id_udpxxsh', $id_udpxxsh)
					->where( 'ucudasd.id_pages', $row['id_pages_null'])
					->exec();
			}

			$c_delpage = count($rss_null_pages);
			$messsage_delpage = ' ' . $c_delpage . ' pages baru berhasil dihapus.';
		}

		if( $c_newpage > 0 ){
			// jika ada yang harus ditambahkan
			if( empty($qi_ucudasd) ){
				$check = 0;
			}
		}

		if( $c_delpage > 0 ){
			// jika ada yang harus ditambahkan
			if( empty($qd_null_pages) ){
				$check = 0;
			}
		}

		if( $check == 1){
			$db->commit();
			$status_code  = '200';
			$message      = 'Regenerate Pages Berhasil.' . $messsage_newpage . $messsage_delpage;
			$type_message = 'success';
		}else{
			$db->rollback();
			$status_code  = '500';
			$message      = 'Regenerate Pages Gagal';
			$type_message = 'error';
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = '500';
		$message      = 'Regenerate Pages Gagal! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Regenerate Pages Gagal!, ' . $e->getMessage();
		$type_message = 'error';
	}
	// build response
	$data = array(
		'status_code'    => $status_code,
		'message'        => $message,
		'type_message'   => $type_message
	);

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>