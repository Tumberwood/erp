<?php
    /**
     * Digunakan untuk insert ke table aglxxth dan aglaktd
     * Cara menentukan akun persediaan, ditentukan dari table ggsaksh.persediaan
	 * Setelah itu baru diambil dari settingan di table terkait.
	 * Misal table ggsaksh.persediaan = 'iicxxmh', maka akun persediaan ditentukan dari table iicxxmh_aakxxmh
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
	$jenis_transaksi = 'Sales Receive';
	try{
		$db->transaction();

		// select spmxxth
		$qs_spmxxth = $db
			->raw()
			->bind(':id_transaksi_h', $id_transaksi_h)
			->exec('SELECT
					spmxxth.id as id_transaksi_h,
					spmxxth.id_gcpxxmh as id_gcpxxmh,
					spmxxth.id_gbrxxmh as id_gbrxxmh,
					spmxxth.kode as kode,
					spmxxth.created_by as created_by,
					spmxxth.tanggal as tanggal,
					spmxxth.start_at as start_at,
					spmxxth.finish_at as finish_at,
					spmxxth.rencana_bayar as grand_total,
					grlxxmh.nama as grlxxmh_nama
				FROM spmxxth
				LEFT JOIN grlxxmh ON grlxxmh.id = spmxxth.id_grlxxmh_customer
				WHERE 
					spmxxth.id = :id_transaksi_h
			');
		$rs_header = $qs_spmxxth->fetch();
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
			->set('start_at',$rs_header['start_at'])
			->set('finish_at',$rs_header['finish_at'])
			->set('keterangan', $keterangan)
			->set('jenis_transaksi',$jenis_transaksi)
			->set('kode_transaksi',$rs_header['kode'])
			->set('total_debit', $rs_header['grand_total'] * 2)
			->set('total_kredit', $rs_header['grand_total'])
			->exec();
		$last_id = $sql_insert_aglxxth->insertId();  // ambil id 

		// insert Debit
		$qi_debit = $db
			->raw()
			->bind(':id_transaksi_h', $id_transaksi_h)
			->bind(':last_id', $last_id)
			->bind(':keterangan', $keterangan)
			->exec('INSERT INTO aglaktd(
						id_aglxxth,
						id_aakxxmh,
						id_transaksi_d,
						created_by,
						start_at,
						finish_at,
						keterangan,
						debit_kredit,
						debit,
						kredit
					)
					SELECT 
						:last_id,
						e.id_aakxxmh,
						b.id id_transaksi_d,
						a.created_by,
						a.start_at,
						a.finish_at,
						:keterangan,
						"Debit" AS debit_kredit,
						b.rencana_bayar AS debit,   
						0 kredit
					FROM spmivtd b                                 
					LEFT JOIN spmxxth a ON a.id = b.id_spmxxth
					LEFT JOIN sivxxth c ON c.id = b.id_sivxxth            
					LEFT JOIN aglxxth d ON d.kode_transaksi = c.kode
					LEFT JOIN aglaktd e ON e.kredit > 0 AND e.id_aglxxth = d.id
					WHERE a.id = :id_transaksi_h;
		');

		// insert Kredit
		$qi_kredit = $db
		->raw()
		->bind(':id_transaksi_h', $id_transaksi_h)
		->bind(':last_id', $last_id)
		->bind(':keterangan', $keterangan)
		->exec('INSERT INTO aglaktd(
					id_aglxxth,
					id_aakxxmh,
					id_transaksi_d,
					created_by,
					start_at,
					finish_at,
					keterangan,
					debit_kredit,
					debit,
					kredit
				)
				SELECT 
					:last_id,
					a.id_aakxxmh,
					b.id id_transaksi_d,
					a.created_by,
					a.start_at,
					a.finish_at,
					:keterangan,
					"Kredit" AS debit_kredit,
					0 AS debit,   
					b.rencana_bayar AS kredit 
				FROM spmivtd b                                 
				LEFT JOIN spmxxth a ON a.id = b.id_spmxxth
				WHERE a.id = :id_transaksi_h;
	');

		// check apakah query ada resultnya
		if(!empty($qi_debit) && !empty($qi_kredit) ){
			$db->commit();
			$status_code  = '200';
			$message      = $jenis_transaksi . ' Berhasil Dibukukan';
			$type_message = 'success';
			// parameter lain
		}else{
			$db->rollback();
			$status_code  = '500';
			$message      = $jenis_transaksi . ' Gagal Dibukukan';
			$type_message = 'error';
			// parameter lain
		}
		
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = '500';
		$message      = $jenis_transaksi . ' Gagal Dibukukan' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = $jenis_transaksi . ' Gagal Dibukukan' . $e->getMessage();
		$type_message = 'error';
	}

	// build response
	$data = array(
		'status_code'    => $status_code,
		'message'        => $message,
		'type_message'   => $type_message
	);

    // tampilkan results
	include_once( "../../../helpers/fn_ajax_results.php" );
	
?>