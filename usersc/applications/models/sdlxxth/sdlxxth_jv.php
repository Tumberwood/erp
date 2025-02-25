<?php
    /**
     * Digunakan untuk insert ke table aglxxth dan aglaktd
     * Cara menentukan akun persediaan, ditentukan dari table ggsaksh.persediaan
	 * Setelah itu baru diambil dari settingan di table terkait.
	 * Misal table ggsaksh.persediaan = 'iicxxmh', maka akun persediaan ditentukan dari table iicxxmh_aakxxmh
	 * Jurnal:
	 * Persediaan Dalam Perjalanan
	 * 		Persediaan (sesuai grouping persediaan)
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
	$jenis_transaksi = 'Sales Delivery';

	try{
		$db->transaction();

		//sekarang ini yang persediaan
		//kalau konsinyasi aak persediaan berubah menjadi, aakxxmh = 47 (debit), kreditnya sama seperti persediaan.

		// get setting akun
		$qs_ggsaksh = $db
			->query('select', 'ggsaksh' )
			->get([
				'ggsaksh.aakxxmh_persediaan as aakxxmh_persediaan',
				'ggsaksh.id_aakxxmh_persediaan_perjalanan as id_aakxxmh_persediaan_perjalanan',
				'aakxxmh_persediaan_perjalanan.kode as aakxxmh_persediaan_perjalanan_kode',
				'aakxxmh_persediaan_perjalanan.nama as aakxxmh_persediaan_perjalanan_nama'
			] )
			->join('aakxxmh as aakxxmh_persediaan_perjalanan','aakxxmh_persediaan_perjalanan.id = ggsaksh.id_aakxxmh_persediaan_perjalanan','LEFT' )
			->limit(1)
			->exec();
		$rs_ggsaksh = $qs_ggsaksh->fetch();
		$tabel_persediaan = $rs_ggsaksh['aakxxmh_persediaan'];
		
		// select sdlxxth
		$qs_sdlxxth = $db
			->raw()
			->bind(':id_transaksi_h', $id_transaksi_h)
			->exec('SELECT
					sdlxxth.id as id_transaksi_h,
					sdlxxth.id_gcpxxmh as id_gcpxxmh,
					sdlxxth.id_gbrxxmh as id_gbrxxmh,
					sdlxxth.kode as kode,
					sdlxxth.created_by as created_by,
					sdlxxth.tanggal as tanggal,
					sdlxxth.subtotal as subtotal,
					sdlxxth.dpp_final as total_nilai,
					grlxxmh.nama as grlxxmh_nama
				FROM sdlxxth
				LEFT JOIN grlxxmh ON grlxxmh.id = sdlxxth.id_grlxxmh_customer
				WHERE 
					sdlxxth.id = :id_transaksi_h
			');
		$rs_header = $qs_sdlxxth->fetch();
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
		// insert debit
		$qi_debit = $db
			->query('insert', 'aglaktd')
			->set('id_aglxxth', $last_id)
			->set('id_aakxxmh', $rs_ggsaksh['id_aakxxmh_persediaan_perjalanan'])
			->set('id_transaksi_d', 0 )
			->set('created_by',$rs_header['created_by'])
			->set('keterangan',$keterangan)
			->set('debit_kredit', 'Debit')
			->set('debit', $rs_header['total_nilai'])
			->set('kredit', 0)
			->exec();

		// select kredit
		$qs_kredit = $db
			->raw()
			->bind(':id_transaksi_h', $id_transaksi_h)
			->exec('
				SELECT
					sdlittd.id_sdlxxth as id_transaksi_h,
					aakxxmh.id as id_aakxxmh,
					sdlittd.created_by as created_by,
					sdlittd.keterangan as keterangan,
					'.$rs_header["subtotal"].',
					'.$rs_header["total_nilai"].',
					SUM(sdlittd.dpp / ' . $rs_header["subtotal"] .'*'. $rs_header["total_nilai"].') as kredit
				FROM sdlittd
				LEFT JOIN iimxxmh ON iimxxmh.id = sdlittd.id_iimxxmh
				LEFT JOIN '.$tabel_persediaan.'_aakxxmh ON '.$tabel_persediaan.'_aakxxmh.id_'.$tabel_persediaan.' = iimxxmh.id_'.$tabel_persediaan.'
				LEFT JOIN aakxxmh ON aakxxmh.id = '.$tabel_persediaan.'_aakxxmh.id_aakxxmh_persediaan
				WHERE sdlittd.id_sdlxxth = :id_transaksi_h
				GROUP BY '.$tabel_persediaan.'_aakxxmh.id_aakxxmh_persediaan
			');
		$rs_kredit = $qs_kredit->fetchAll();

		foreach ($rs_kredit as $row_kredit) {
			$qi_kredit = $db
				->query('insert', 'aglaktd')
				->set('id_aglxxth', $last_id)
				->set('id_aakxxmh',$row_kredit['id_aakxxmh'])
				->set('id_transaksi_d',$row_kredit['id_transaksi_h'])
				->set('created_by',$row_kredit['created_by'])
				->set('keterangan',$keterangan)
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