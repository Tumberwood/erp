<?php
    /**
     * Digunakan untuk insert ke table aglxxth dan aglaktd
     * Sumber data:
     * fopxxth  : debit
     * fopaktd  : kredit
     */
	/*
    

	*/

	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
    include_once( "../../../helpers/datatables_fn_debug.php" );

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
	$jenis_transaksi = 'Other Payment';

	try{
		$db->transaction();

		// header
		// select fopxxth
		$qs_fopxxth = $db
			->raw()
			->bind(':id_transaksi_h', $id_transaksi_h)
			->exec('
				SELECT
					fopxxth.id as id_transaksi_h,
					fopxxth.id_gbrxxmh as id_gbrxxmh,
					fopxxth.id_aakxxmh as id_aakxxmh,
					fopxxth.kode as kode,
					fopxxth.created_by as created_by,
					fopxxth.tanggal as tanggal,
					fopxxth.keterangan as keterangan,
					fopxxth.amount as total_nilai
				FROM fopxxth
				WHERE 
					fopxxth.id = :id_transaksi_h
			');
		$rs_header = $qs_fopxxth->fetch();

		// BEGIN generate kode JV
		include_once("../../../../usersc/helpers/kode_fn_generate_jv.php");
		// END generate kode JV

		// INSERT aglxxth
		$sql_insert_aglxxth = $db
			->query('insert', 'aglxxth')
			->set('id_gbrxxmh', $rs_header['id_gbrxxmh'])
			->set('id_transaksi_h', $rs_header['id_transaksi_h'])
			->set('kode', $kode )
			->set('created_by',$rs_header['created_by'])
			->set('tanggal',$rs_header['tanggal'])
			->set('keterangan',$rs_header['keterangan'])
			->set('jenis_transaksi',$jenis_transaksi)
			->set('kode_transaksi',$rs_header['kode'])
			->set('total_debit', $rs_header['total_nilai'])
			->set('total_kredit', $rs_header['total_nilai'])
			->exec();
		$last_id = $sql_insert_aglxxth->insertId();  // ambil id 

		// detail
		// select debit
		$qs_debit = $db
			->query('select', 'fopaktd')
			->get('fopaktd.id_aakxxmh as id_aakxxmh')
			->get('fopaktd.id as id_transaksi_h')
			->get('fopaktd.created_by as created_by')
			->get('fopaktd.keterangan as keterangan')
			->get('fopaktd.amount as debit')
			->where('fopaktd.id_fopxxth', $id_transaksi_h )
			->exec();
		$rs_debit = $qs_debit->fetchAll();

		foreach ($rs_debit as $row_debit) {
			$qi_debit = $db
				->query('insert', 'aglaktd')
				->set('id_aglxxth', $last_id)
				->set('id_aakxxmh',$row_debit['id_aakxxmh'])
				->set('id_transaksi_d',$row_debit['id_transaksi_h'])
				->set('created_by',$row_debit['created_by'])
				->set('keterangan',$row_debit['keterangan'])
				->set('debit_kredit', 'Debit')
				->set('debit', $row_debit['debit']   )
				->set('kredit', 0)
				->exec();
		}

		// insert kredit
		$qi_kredit = $db
			->query('insert', 'aglaktd')
			->set('id_aglxxth', $last_id)
			->set('id_aakxxmh',$rs_header['id_aakxxmh'])
			->set('id_transaksi_d', 0 )
			->set('created_by',$rs_header['created_by'])
			->set('keterangan',$rs_header['keterangan'])
			->set('debit_kredit', 'Kredit')
			->set('debit', 0)
			->set('kredit', $rs_header['total_nilai'])
			->exec();

		// commit transaction
		$db->commit();
		$message = $jenis_transaksi . ' Berhasil Dibukukan';
		$type_message = 'success';
		
	}catch(PDOException $e){
		// rollback on error
		$db->rollback();
		$message = $jenis_transaksi. ' Gagal Dibukukan';
		$type_message = 'danger';
		
	}

	$data = array(
		'message'      => $message,
		'type_message' => $type_message
	);

    // tampilkan results
	include_once( "../../../helpers/fn_ajax_results.php" );
	
?>