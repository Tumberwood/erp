<?php
    /**
     * Digunakan untuk insert ke table aglxxth dan aglaktd
     * Sumber data:
     * igixxth  : debit
     * igiittd  : kredit
	 * Jurnal
	 * 	Biaya
	 * 		Persediaan
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
	$jenis_transaksi = 'Goods Issue';

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
					igixxth.amount as total_nilai
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
			->query('select', 'igixxth' )
			->get([
				'igixxth.id_aakxxmh as id_aakxxmh',
				'igixxth.id as id_transaksi_h',
				'igixxth.created_by as created_by',
				'igixxth.keterangan as keterangan',
				'igixxth.amount as debit'
			] )
			->where('igixxth.id', $id_transaksi_h )
			->exec();
		$rs_debit = $qs_debit->fetch();
		
		$qi_debit = $db
			->query('insert', 'aglaktd')
			->set('id_aglxxth', $last_id)
			->set('id_aakxxmh',$rs_debit['id_aakxxmh'])
			->set('id_transaksi_d',$rs_debit['id_transaksi_h'])
			->set('created_by',$rs_debit['created_by'])
			->set('keterangan',$rs_debit['keterangan'])
			->set('debit_kredit', 'Debit')
			->set('debit', $rs_debit['debit']   )
			->set('kredit', 0)
			->exec();


		// kredit

		// get setting akun persediaan
		$qs_ggsaksh = $db
			->query('select', 'ggsaksh' )
			->get([
				'ggsaksh.aakxxmh_persediaan as aakxxmh_persediaan'
			] )
			->limit(1)
			->exec();
		$rs_ggsaksh       = $qs_ggsaksh->fetch();
		$tabel_persediaan = $rs_ggsaksh['aakxxmh_persediaan'];
		
		$qs_kredit = $db
			->raw()
			->bind(':id_transaksi_h', $id_transaksi_h)
			->exec('SELECT
					aakxxmh.id as id_aakxxmh,
					SUM(igiittd.hpp) as kredit

				FROM igiittd
				LEFT JOIN iimxxmh ON iimxxmh.id = igiittd.id_iimxxmh
				LEFT JOIN '.$tabel_persediaan.'_aakxxmh ON '.$tabel_persediaan.'_aakxxmh.id_'.$tabel_persediaan.' = iimxxmh.id_'.$tabel_persediaan.'
				LEFT JOIN aakxxmh ON aakxxmh.id = '.$tabel_persediaan.'_aakxxmh.id_aakxxmh_persediaan
				WHERE igiittd.id_igixxth = :id_transaksi_h
				GROUP BY '.$tabel_persediaan.'_aakxxmh.id_aakxxmh_persediaan
			');
		$rs_kredit = $qs_kredit->fetchAll();

		foreach ($rs_kredit as $row_kredit) {
			// insert kredit
			$qi_kredit = $db
				->query('insert', 'aglaktd')
				->set('id_aglxxth', $last_id)
				->set('id_aakxxmh',$row_kredit['id_aakxxmh'])
				->set('id_transaksi_d', 0 )
				->set('created_by',$rs_header['created_by'])
				->set('keterangan',$rs_header['keterangan'])
				->set('debit_kredit', 'Kredit')
				->set('debit', 0)
				->set('kredit', $row_kredit['kredit'])
				->exec();
		}

		

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