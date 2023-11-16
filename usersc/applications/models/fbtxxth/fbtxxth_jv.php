<?php
	/*
		Digunakan untuk insert ke table aglxxth dan aglaktd
	*/


    require_once( "../../users/init.php" );
	require_once( "../../usersc/lib/DataTables.php" );
    require_once( "datatables_fn_debug.php" );
    require_once( "hakakses_s_fn.php" );

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
	$state          = $_POST['state'];
	$transaksi_tipe = 'Transfer Bank';

	if($state == 1){
		// jika approve
		try{
			$db->transaction();

            // header
            // select fbtxxth
			$qs_fbtxxth = $db
				->raw()
				->bind(':id_transaksi_h', $id_transaksi_h)
				->exec('
					SELECT
						fbtxxth.id as id_transaksi_h,
						fbtxxth.id_gbrxxmh_dari as id_gbrxxmh,
						fbtxxth.kode as kode,
						fbtxxth.created_by as created_by,
						fbtxxth.is_approve as is_approve,
						fbtxxth.approved_by as approved_by,
						fbtxxth.approved_on as approved_on,
						fbtxxth.tanggal as tanggal,
						fbtxxth.keterangan as keterangan,
						fbtxxth.nilai as total_nilai
					FROM fbtxxth
					WHERE 
						fbtxxth.id = :id_transaksi_h
				');
			$rs_fbtxxth = $qs_fbtxxth->fetch();

			// BEGIN generate kode JV
			include_once("../../../../usersc/helpers/kode_fn_generate_jv.php");
			// END generate kode JV

            // INSERT aglxxth
			$qi_aglxxth = $db
				->raw()
				->bind(':variable1', variable1)
				->bind(':variable2', variable2)
				->exec('
					INSERT INTO aglxxth
					
				');

            $sql_insert_aglxxth = $db
                ->query('insert', 'aglxxth')
                ->set('id_gbrxxmh', $result_select_header['id_gbrxxmh'])
                ->set('id_transaksi_h', $result_select_header['id_transaksi_h'])
                ->set('kode', $kode )
                ->set('created_by',$result_select_header['created_by'])
                ->set('is_approve',$result_select_header['is_approve'])
                ->set('approved_by',$result_select_header['approved_by'])
                ->set('approved_on',$result_select_header['approved_on'])
                ->set('tanggal',$result_select_header['tanggal'])
                ->set('keterangan',$result_select_header['keterangan'])
                ->set('jenis_transaksi','Transfer Bank')
                ->set('kode_transaksi',$result_select_header['kode'])
                ->set('total_debit', $result_select_header['total_nilai'])
                ->set('total_kredit', $result_select_header['total_nilai'])
                ->set('is_jurnal', 1 )
                ->exec();
            $last_id = $sql_insert_aglxxth->insertId();  // ambil id 

            // detail
            // select debit
			$sql_select_debit = $db
				->query('select', 'fbtxxth')
				->get('fbtxxth.id_aakxxmh_ke as id_aakxxmh')
				->get('fbtxxth.id as id_transaksi_d')
				->get('fbtxxth.kode as kode')
				->get('fbtxxth.created_by as created_by')
				->get('fbtxxth.keterangan as keterangan')
				->get('fbtxxth.nilai as debit')
				->where('fbtxxth.id', $id_transaksi_h )
				->exec();
			$results_select_debit = $sql_select_debit->fetch();

            // insert debit
            $sql_insert_debit = $db
                ->query('insert', 'aglaktd')
                ->set('id_aglxxth', $last_id)
                ->set('id_aakxxmh',$results_select_debit['id_aakxxmh'])
                ->set('id_transaksi_d',$results_select_debit['id_transaksi_d'])
                ->set('created_by',$results_select_debit['created_by'])
                ->set('keterangan',$results_select_debit['keterangan'])
                ->set('debit_kredit', 'Debit')
                ->set('debit',$results_select_debit['debit'])
                ->set('kredit', 0 )
                ->exec();

			$sql_select_kredit = $db
				->query('select', 'fbtxxth')
				->get('fbtxxth.id_aakxxmh_dari as id_aakxxmh')
				->get('fbtxxth.id as id_transaksi_h')
				->get('fbtxxth.created_by as created_by')
				->get('fbtxxth.keterangan as keterangan')
				->get('fbtxxth.nilai as kredit')
				->where('fbtxxth.id', $id_transaksi_h )
				->exec();
			$result_select_kredit = $sql_select_kredit->fetch();

			$sql_insert_kredit = $db
                ->query('insert', 'aglaktd')
                ->set('id_aglxxth', $last_id)
                ->set('id_aakxxmh',$result_select_kredit['id_aakxxmh'])
                ->set('id_transaksi_d',$result_select_kredit['id_transaksi_h'])
                ->set('created_by',$result_select_kredit['created_by'])
                ->set('keterangan',$result_select_kredit['keterangan'])
                ->set('debit_kredit', 'Kredit')
                ->set('debit', 0)
                ->set('kredit', $result_select_kredit['kredit']   )
                ->exec();

			// commit transaction
			$db->commit();
			$message = 'Transfer Bank Berhasil Dibukukan';
			$type_message = 'success';
			
		}catch(PDOException $e){
			// rollback on error
			$db->rollback();
			$message = 'Transfer Bank Gagal Dibukukan';
			$type_message = 'danger';
			
		}

	}elseif ($state == -9){
		// jika void
		try{
			$db->transaction();

            $sql_select_aglxxth = $db
				->query('select', 'aglxxth')
				->get('id as id_aglxxth')
				->where('id_transaksi_h', $id_transaksi_h )
                ->where('jenis_transaksi','Transfer Bank')
				->exec();
			$result_select_aglxxth = $sql_select_aglxxth->fetch();
            $id_aglxxth = $result_select_aglxxth['id_aglxxth'];

			$sql_nonaktif_aglxxth = $db
				->query('update', 'aglxxth')
                ->set('is_approve',-9)
                ->set('void_by', $_SESSION['user'])
                ->set('void_on', date("Y-m-d H:i:s") )
				->where('id_transaksi_h',$id_transaksi_h)
				->where('jenis_transaksi','Transfer Bank')
				->exec();

            $sql_nonaktif_aglaktd = $db
				->query('update', 'aglaktd')
                ->set('is_approve',-9)
                ->set('void_by', $_SESSION['user'])
                ->set('void_on', date("Y-m-d H:i:s") )
				->where('id_aglxxth',$id_aglxxth)
				->exec();

			// commit transaction
			$db->commit();
			$message = 'Transfer Bank Berhasil Dibatalkan';
			$type_message = 'success';

		}catch(PDOException $e){
			// rollback on error
			$db->rollback();
			$message = 'Transfer Bank Gagal Dibatalkan';
			$type_message = 'danger';
			
		}
	}

	$data = array(
		'message'      => $message,
		'type_message' => $type_message
	);

    // tampilkan results
    require_once( "fn_ajax_results.php" );
	
?>