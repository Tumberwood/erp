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
	$jenis_transaksi = 'Sales Invoice';

	$qs_id_iitxxmh = $db
		->query('select', 'sivxxth' )
		->get([
			'sivxxth.id_iitxxmh as id_iitxxmh',
			'sivxxth.down_payment AS down_payment'
		] )
		->where('sivxxth.id', $id_transaksi_h )
		->exec();
	$rs_id_iitxxmh = $qs_id_iitxxmh->fetch();	

	try{
		$db->transaction();

		if ($rs_id_iitxxmh['down_payment'] > 0) {
			//kalo down payment tidak insert Jurnal???
			$db->commit();
			$status_code  = '200';
			$message      = $jenis_transaksi . ' Berhasil Dibukukan';
			$type_message = 'success';
		} else {
			// select sivxxth
			$qs_sivxxth = $db
				->raw()
				->bind(':id_transaksi_h', $id_transaksi_h)
				->exec('SELECT
						sivxxth.id as id_transaksi_h,
						sivxxth.id_gcpxxmh as id_gcpxxmh,
						sivxxth.id_sdlxxth as id_sdlxxth,
						sivxxth.id_gbrxxmh as id_gbrxxmh,
						sivxxth.kode as kode,
						sivxxth.created_by as created_by,
						sivxxth.start_at as start_at,
						sivxxth.finish_at as finish_at,
						sivxxth.tanggal as tanggal,
						sivxxth.subtotal as subtotal,
						sivxxth.dpp_final as total_nilai,
						sivxxth.is_pajak as is_pajak,
						sivxxth.pajak_final as pajak_final,
						sivxxth.grand_total as grand_total,
						grlxxmh.nama as grlxxmh_nama
					FROM sivxxth
					LEFT JOIN grlxxmh ON grlxxmh.id = sivxxth.id_grlxxmh_customer
					WHERE 
						sivxxth.id = :id_transaksi_h
				');
			$rs_header = $qs_sivxxth->fetch();
			$keterangan = $rs_header['grlxxmh_nama'] . " - " . $rs_header['kode'];
	
			// BEGIN generate kode JV
			include_once("../../../../usersc/helpers/kode_fn_generate_jv.php");
			// END generate kode JV

			
			// get setting akun persediaan
			$qs_ggsaksh = $db
				->query('select', 'ggsaksh' )
				->get([
					'ggsaksh.aakxxmh_persediaan as aakxxmh_persediaan',
					'ggsaksh.id_aakxxmh_persediaan_perjalanan as id_aakxxmh_persediaan_perjalanan',
					'ggsaksh.id_aakxxmh_hpp as id_aakxxmh_hpp',
					'ggsaksh.id_aakxxmh_piutang_usaha as id_aakxxmh_piutang_usaha',
					'ggsaksh.id_aakxxmh_pajak_masukan as id_aakxxmh_pajak_masukan',
					'ggsaksh.aakxxmh_biaya as aakxxmh_biaya',
					'ggsaksh.id_aakxxmh_hutang_sementara as id_aakxxmh_hutang_sementara',
					'aakxxmh_hutang_sementara.kode as aakxxmh_hutang_sementara_kode',
					'aakxxmh_hutang_sementara.nama as aakxxmh_hutang_sementara_nama'
				] )
				->join('aakxxmh as aakxxmh_hutang_sementara','aakxxmh_hutang_sementara.id = ggsaksh.id_aakxxmh_hutang_sementara','LEFT' )
				->limit(1)
				->exec();
			$rs_ggsaksh       = $qs_ggsaksh->fetch();
			$tabel_persediaan = $rs_ggsaksh['aakxxmh_persediaan'];
			$tabel_biaya      = $rs_ggsaksh['aakxxmh_biaya'];

			//akun untuk jurnal kedua
			$id_aakxxmh_hpp      = $rs_ggsaksh['id_aakxxmh_hpp']; //debit
			$id_aakxxmh_persediaan_perjalanan      = $rs_ggsaksh['id_aakxxmh_persediaan_perjalanan']; //kredit
			
	
			////////////////////// BEGIN Jurnal pertama //////////////////////
			// INSERT aglxxth
			$sql_insert_aglxxth = $db
				->query('insert', 'aglxxth')
				->set('id_gbrxxmh', $rs_header['id_gbrxxmh'])
				->set('id_transaksi_h', $rs_header['id_transaksi_h'])
				->set('kode', $kode )
				->set('created_by',$rs_header['created_by'])
				->set('start_at',$rs_header['start_at'])
				->set('finish_at',$rs_header['finish_at'])
				->set('tanggal',$rs_header['tanggal'])
				->set('keterangan', $keterangan)
				->set('jenis_transaksi',$jenis_transaksi)
				->set('kode_transaksi',$rs_header['kode'])
				->set('total_debit', $rs_header['grand_total'] * 2)
				->set('total_kredit', $rs_header['grand_total'] * 2)
				->exec();
			$last_id = $sql_insert_aglxxth->insertId();  // ambil id 
	
			// insert Debit
			$qi_debit = $db
				->query('insert', 'aglaktd')
				->set('id_aglxxth', $last_id)
				->set('id_aakxxmh', $rs_ggsaksh['id_aakxxmh_hutang_sementara'])
				->set('id_transaksi_d', 0 )
				->set('created_by',$rs_header['created_by'])
				->set('start_at',$rs_header['start_at'])
				->set('finish_at',$rs_header['finish_at'])
				->set('keterangan',$keterangan)
				->set('debit_kredit', 'Debit')
				->set('debit', $rs_header['total_nilai'])
				->set('kredit', 0)
				->exec();
	
			//jika ada pajak
			if ($rs_header['pajak_final'] > 0 && $rs_header['is_pajak'] == 1) {
	
				//insert pajak masukan
				$qi_debit = $db
				->query('insert', 'aglaktd')
				->set('id_aglxxth', $last_id)
				->set('id_aakxxmh', $rs_ggsaksh['id_aakxxmh_pajak_masukan']) //56
				->set('id_transaksi_d', 0 )
				->set('created_by',$rs_header['created_by'])
				->set('start_at',$rs_header['start_at'])
				->set('finish_at',$rs_header['finish_at'])
				->set('keterangan',$keterangan)
				->set('debit_kredit', 'Debit')
				->set('debit', $rs_header['pajak_final'])
				->set('kredit', 0)
				->exec();
	
				$total_kredit = $rs_header['total_nilai'] + $rs_header['pajak_final'];
			} else {
				$total_kredit = $rs_header['total_nilai'];
			}
	
			// insert Kredit
			$qi_kredit = $db
				->query('insert', 'aglaktd')
				->set('id_aglxxth', $last_id)
				->set('id_aakxxmh', $rs_ggsaksh['id_aakxxmh_piutang_usaha']) //dimasukkan settingan id_aak =  99
				->set('id_transaksi_d', 0 )
				->set('created_by',$rs_header['created_by'])
				->set('start_at',$rs_header['start_at'])
				->set('finish_at',$rs_header['finish_at'])
				->set('keterangan',$keterangan)
				->set('debit_kredit', 'Kredit')
				->set('debit', 0)
				->set('kredit', $total_kredit)
				->exec();

			// insert Debit
			$qi_debit_kedua = $db
				->query('insert', 'aglaktd')
				->set('id_aglxxth', $last_id)
				->set('id_aakxxmh', $id_aakxxmh_hpp)
				->set('id_transaksi_d', 0 )
				->set('created_by',$rs_header['created_by'])
				->set('start_at',$rs_header['start_at'])
				->set('finish_at',$rs_header['finish_at'])
				->set('keterangan',$keterangan)
				->set('debit_kredit', 'Debit')
				->set('debit', $rs_header['total_nilai'])
				->set('kredit', 0)
				->exec()
			;
			
			// insert Kredit
			$qi_kredit_kedua = $db
				->query('insert', 'aglaktd')
				->set('id_aglxxth', $last_id)
				->set('id_aakxxmh', $id_aakxxmh_persediaan_perjalanan)
				->set('id_transaksi_d', 0 )
				->set('created_by',$rs_header['created_by'])
				->set('start_at',$rs_header['start_at'])
				->set('finish_at',$rs_header['finish_at'])
				->set('keterangan',$keterangan)
				->set('debit_kredit', 'Kredit')
				->set('debit', 0)
				->set('kredit', $total_kredit)
				->exec()
			;
			
			//cek di Transaksi Sebelumnya (sdlxxth), apakah nilainya berubah saat di invoice.
			$qs_sdlxxth = $db
				->query('select', 'sdlxxth' )
				->get([
					'dpp_final'
					] )
				->where('id', $rs_header['id_sdlxxth'] )
				->exec();
			$rs_sdlxxth = $qs_sdlxxth->fetch();
	
			//jika dpp final di sdl != dpp final di invoice, maka edit agl dan sdl nya
			if ($rs_sdlxxth['dpp_final'] != $rs_header['total_nilai']) {
				$qu_sdlxxth = $db
					->query('update', 'sdlxxth')
					->set('dpp_final',$rs_header['total_nilai'])
					->where('id',$rs_header['id_sdlxxth'])
					->exec();
				
				//cek di agl
				$qs_aglxxth = $db
					->query('select', 'aglxxth' )
					->get([
						'id'
						] )
					->where('id_transaksi_h', $rs_header['id_sdlxxth'] )
					->where('jenis_transaksi', "Sales Delivery" )
					->exec();
				$rs_aglxxth = $qs_aglxxth->fetch();
	
				$qu_aglxxth = $db
					->query('update', 'aglxxth')
					->set('total_debit',$rs_header['total_nilai'])
					->set('total_kredit',$rs_header['total_nilai'])
					->where('id',$rs_aglxxth['id'])
					->exec();
	
				$qu_aglaktd_debit = $db
					->query('update', 'aglaktd')
					->set('debit',$rs_header['total_nilai'])
					->where('id_aglxxth',$rs_aglxxth['id'])
					->where('debit_kredit','Debit')
					->exec();
	
				$qu_aglaktd_kredit = $db
					->query('update', 'aglaktd')
					->set('kredit',$rs_header['total_nilai'])
					->where('id_aglxxth',$rs_aglxxth['id'])
					->where('debit_kredit','Kredit')
					->exec();
			}
			////////////////////// END Jurnal pertama //////////////////////
			
			// check apakah query ada resultnya
			if(!empty($qi_debit) && !empty($qi_kredit) && !empty($qi_debit_kedua) && !empty($qi_kredit_kedua) ){
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