<?php
    /**
     * Digunakan untuk insert ke table aglxxth dan aglaktd
     * Sumber data:
     * igixxth  : debit
     * igiittd  : kredit
     */

	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
    include_once( "../../../helpers/datatables_fn_debug.php" );
    include_once( "../../../helpers/SolusiIndonesiaUtilities.php" );

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
		// select igixxth
		$qs_igixxth = $db
			->raw()
			->bind(':id_transaksi_h', $id_transaksi_h)
			->exec('SELECT
					igixxth.id as id_transaksi_h,
					igixxth.id_gcpxxmh as id_gcpxxmh,
					igixxth.id_gbrxxmh as id_gbrxxmh,
					igixxth.id_aakxxmh as id_aakxxmh,
					igixxth.kode as kode,
					igixxth.created_by as created_by,
					igixxth.tanggal as tanggal,
					igixxth.keterangan as keterangan,
					-- igixxth.amount as total_nilai
				FROM igixxth
				WHERE 
					igixxth.id = :id_transaksi_h
			');
		$rs_header = $qs_igixxth->fetch();

		// BEGIN generate kode JV
		include_once("../../../../usersc/helpers/kode_fn_generate_jv.php");
		// END generate kode JV

		// INSERT aglxxth
		$sql_insert_aglxxth = $db
			->query('insert', 'aglxxth')
			->set('id_gcpxxmh', $rs_header['id_gcpxxmh'])
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
			->query('select', 'igiittd')
			->get('igiittd.id_aakxxmh as id_aakxxmh')
			->get('igiittd.id as id_transaksi_h')
			->get('igiittd.created_by as created_by')
			->get('igiittd.keterangan as keterangan')
			->get('igiittd.amount as debit')
			->where('igiittd.id_igixxth', $id_transaksi_h )
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