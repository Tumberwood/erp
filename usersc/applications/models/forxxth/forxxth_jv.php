<?php
    /**
     * Digunakan untuk insert ke table aglxxth dan aglaktd
     * Sumber data:
     * forxxth  : debit
     * foraktd  : kredit
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
	$jenis_transaksi = 'Other Receipt';

	try{
		$db->transaction();

		// header
		// select forxxth
		$qs_forxxth = $db
			->raw()
			->bind(':id_transaksi_h', $id_transaksi_h)
			->exec('
				SELECT
					forxxth.id as id_transaksi_h,
					forxxth.id_gbrxxmh as id_gbrxxmh,
					forxxth.id_aakxxmh as id_aakxxmh,
					forxxth.kode as kode,
					forxxth.created_by as created_by,
					forxxth.tanggal as tanggal,
					forxxth.keterangan as keterangan,
					forxxth.amount as total_nilai
				FROM forxxth
				WHERE 
					forxxth.id = :id_transaksi_h
			');
		$rs_header = $qs_forxxth->fetch();

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
		// insert debit
		$qi_debit = $db
			->query('insert', 'aglaktd')
			->set('id_aglxxth', $last_id)
			->set('id_aakxxmh',$rs_header['id_aakxxmh'])
			->set('id_transaksi_d', 0 )
			->set('created_by',$rs_header['created_by'])
			->set('keterangan',$rs_header['keterangan'])
			->set('debit_kredit', 'Debit')
			->set('debit', $rs_header['total_nilai'])
			->set('kredit', 0)
			->exec();

		
		// select kredit
		$qs_kredit = $db
			->query('select', 'foraktd')
			->get('foraktd.id_aakxxmh as id_aakxxmh')
			->get('foraktd.id as id_transaksi_h')
			->get('foraktd.created_by as created_by')
			->get('foraktd.keterangan as keterangan')
			->get('foraktd.amount as kredit')
			->where('foraktd.id_forxxth', $id_transaksi_h )
			->exec();
		$rs_kredit = $qs_kredit->fetchAll();

		foreach ($rs_kredit as $row_kredit) {
			$qi_kredit = $db
				->query('insert', 'aglaktd')
				->set('id_aglxxth', $last_id)
				->set('id_aakxxmh',$row_kredit['id_aakxxmh'])
				->set('id_transaksi_d',$row_kredit['id_transaksi_h'])
				->set('created_by',$row_kredit['created_by'])
				->set('keterangan',$row_kredit['keterangan'])
				->set('debit_kredit', 'Kredit')
				->set('debit', 0)
				->set('kredit', $row_kredit['kredit']   )
				->exec();
		}
		
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