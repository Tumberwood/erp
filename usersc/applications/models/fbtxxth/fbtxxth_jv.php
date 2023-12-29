<?php
	/**
	 * Digunakan untuk insert ke table aglxxth dan aglaktd
	 * Sumber data:
	 * fbtxxth tujuan	: debit
	 * fbtxxth asal		: kredit
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
	$transaksi_tipe = 'Transfer Bank';

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
					fbtxxth.id_gbrxxmh_asal as id_gbrxxmh,
					fbtxxth.kode as kode,
					fbtxxth.created_by as created_by,
					fbtxxth.tanggal as tanggal,
					fbtxxth.keterangan as keterangan,
					fbtxxth.amount as total_nilai
				FROM fbtxxth
				WHERE 
					fbtxxth.id = :id_transaksi_h
			');
		$rs_header = $qs_fbtxxth->fetch();

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
			->set('jenis_transaksi','Kas Bank Transfer')
			->set('kode_transaksi',$rs_header['kode'])
			->set('total_debit', $rs_header['total_nilai'])
			->set('total_kredit', $rs_header['total_nilai'])
			->exec();
		$last_id = $sql_insert_aglxxth->insertId();  // ambil id 

		// detail
		// select debit
		$qs_debit = $db
			->query('select', 'fbtxxth')
			->get('fbtxxth.id_aakxxmh_tujuan as id_aakxxmh')
			->get('fbtxxth.id as id_transaksi_d')
			->get('fbtxxth.created_by as created_by')
			->get('fbtxxth.keterangan as keterangan')
			->get('fbtxxth.amount as debit')
			->where('fbtxxth.id', $id_transaksi_h )
			->exec();
		$rs_debit = $qs_debit->fetch();

		// insert debit
		$qi_debit = $db
			->query('insert', 'aglaktd')
			->set('id_aglxxth', $last_id)
			->set('id_aakxxmh',$rs_debit['id_aakxxmh'])
			->set('id_transaksi_d',$rs_debit['id_transaksi_d'])
			->set('created_by',$rs_debit['created_by'])
			->set('keterangan',$rs_debit['keterangan'])
			->set('debit_kredit', 'Debit')
			->set('debit', $rs_debit['debit'])
			->set('kredit', 0)
			->exec();

		
		// select kredit
		$qs_kredit = $db
			->query('select', 'fbtxxth')
			->get('fbtxxth.id_aakxxmh_asal as id_aakxxmh')
			->get('fbtxxth.id as id_transaksi_h')
			->get('fbtxxth.created_by as created_by')
			->get('fbtxxth.keterangan as keterangan')
			->get('fbtxxth.amount as kredit')
			->where('fbtxxth.id', $id_transaksi_h )
			->exec();
		$rs_kredit = $qs_kredit->fetch();

		$qi_kredit = $db
			->query('insert', 'aglaktd')
			->set('id_aglxxth', $last_id)
			->set('id_aakxxmh',$rs_kredit['id_aakxxmh'])
			->set('id_transaksi_d',$rs_kredit['id_transaksi_h'])
			->set('created_by',$rs_kredit['created_by'])
			->set('keterangan',$rs_kredit['keterangan'])
			->set('debit_kredit', 'Kredit')
			->set('debit', 0)
			->set('kredit', $rs_kredit['kredit']   )
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

	$data = array(
		'message'      => $message,
		'type_message' => $type_message
	);

    // tampilkan results
	include_once( "../../../helpers/fn_ajax_results.php" );
	
?>