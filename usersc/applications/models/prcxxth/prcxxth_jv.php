<?php
    /**
     * Digunakan untuk insert ke table aglxxth dan aglaktd
     * Cara menentukan akun persediaan, ditentukan dari table ggsaksh.persediaan
	 * Setelah itu baru diambil dari settingan di table terkait.
	 * Misal table ggsaksh.persediaan = 'iicxxmh', maka akun persediaan ditentukan dari table iicxxmh_aakxxmh
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
    // END definisi variable untuk fn_ajax_results.php
	
	$id_transaksi_h  = $_POST['id_transaksi_h'];
	$state           = $_POST['state'];
	$jenis_transaksi = 'Goods Receive';

	try{
		$db->transaction();

		// get setting akun
		$qs_ggsaksh = $db
			->query('select', 'ggsaksh' )
			->get([
				'ggsaksh.aakxxmh_persediaan as aakxxmh_persediaan',
				'ggsaksh.id_aakxxmh_hutang_sementara as id_aakxxmh_hutang_sementara',
				'aakxxmh_hutang_sementara.kode as aakxxmh_hutang_sementara_kode',
				'aakxxmh_hutang_sementara.nama as aakxxmh_hutang_sementara_nama'
			] )
			->join('aakxxmh as aakxxmh_hutang_sementara','aakxxmh_hutang_sementara.id = ggsaksh.id_aakxxmh_hutang_sementara','LEFT' )
			->limit(1)
			->exec();
		$rs_ggsaksh = $qs_ggsaksh->fetch();
		$tabel_persediaan = $rs_ggsaksh['aakxxmh_persediaan'];
		
		// select prcxxth
		$qs_prcxxth = $db
			->raw()
			->bind(':id_transaksi_h', $id_transaksi_h)
			->exec('SELECT
					prcxxth.id as id_transaksi_h,
					prcxxth.id_gcpxxmh as id_gcpxxmh,
					prcxxth.id_gbrxxmh as id_gbrxxmh,
					prcxxth.kode as kode,
					prcxxth.created_by as created_by,
					prcxxth.tanggal as tanggal,
					prcxxth.subtotal as subtotal,
					prcxxth.dpp_final as total_nilai,
					grlxxmh.nama as grlxxmh_nama
				FROM prcxxth
				LEFT JOIN grlxxmh ON grlxxmh.id = prcxxth.id_grlxxmh_supplier
				WHERE 
					prcxxth.id = :id_transaksi_h
			');
		$rs_header = $qs_prcxxth->fetch();
		$keterangan = $rs_header['grlxxmh_nama'] . " - " . $rs_header['kode'];

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
			->set('keterangan', $keterangan)
			->set('jenis_transaksi',$jenis_transaksi)
			->set('kode_transaksi',$rs_header['kode'])
			->set('total_debit', $rs_header['total_nilai'])
			->set('total_kredit', $rs_header['total_nilai'])
			->exec();
		$last_id = $sql_insert_aglxxth->insertId();  // ambil id 

		// detail
		// select debit
		$qs_debit = $db
			->raw()
			->bind(':id_transaksi_h', $id_transaksi_h)
			->exec('
				SELECT
					prcittd.id_prcxxth as id_transaksi_h,
					aakxxmh.id as id_aakxxmh,
					prcittd.created_by as created_by,
					prcittd.keterangan as keterangan,
					'.$rs_header["subtotal"].',
					'.$rs_header["total_nilai"].',
					SUM(prcittd.dpp / ' . $rs_header["subtotal"] .'*'. $rs_header["total_nilai"].') as debit
				FROM prcittd
				LEFT JOIN iimxxmh ON iimxxmh.id = prcittd.id_iimxxmh
				LEFT JOIN '.$tabel_persediaan.'_aakxxmh ON '.$tabel_persediaan.'_aakxxmh.id_'.$tabel_persediaan.' = iimxxmh.id_'.$tabel_persediaan.'
				LEFT JOIN aakxxmh ON aakxxmh.id = '.$tabel_persediaan.'_aakxxmh.id_aakxxmh_persediaan
				WHERE prcittd.id_prcxxth = :id_transaksi_h
				GROUP BY '.$tabel_persediaan.'_aakxxmh.id_aakxxmh_persediaan
			');
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
			->set('id_aakxxmh', $rs_ggsaksh['id_aakxxmh_hutang_sementara'])
			->set('id_transaksi_d', 0 )
			->set('created_by',$rs_header['created_by'])
			->set('keterangan',$keterangan)
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