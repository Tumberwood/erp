<?php	
	/**
	 * Digunakan untuk insert inventory ke iivxxrd
	 */
	include_once( "../../../../users/init.php" );
	include_once( "../../../../usersc/lib/DataTables.php" );
	include_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	include_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../../usersc/helpers/hakakses_s_fn.php" );
	include_once( "../../../helpers/SolusiIndonesiaUtilities.php" );
	// include_once( "../../../helpers/hakakses_s_fn.php" );

    use Carbon\Carbon;
	use
        SolusiIndonesia\Utilities\General;
	
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

	try{
		$db->transaction();

		$id_iumxxmh_unit    = $_POST['id_iumxxmh_unit'];
		$idTransaksi    = $_POST['idTransaksi'];
		$jumlah_unit    = $_POST['jumlah_unit'];
		$keterangan = 'putaway_multi_id_wptittd_'.$idTransaksi;

		$qs_iimxxmh = $db
			->query('select', 'wptittd')
			->get('id_iimxxmh')
			->where('id',$idTransaksi)
			->exec();
		$rs_iimxxmh = $qs_iimxxmh->fetch();
		$id_iimxxmh = $rs_iimxxmh['id_iimxxmh'];

		// BEGIN get jumlah_konversi
		$qs_jumlah_konversi = $db
			->query('select', 'iimummd')
			->get('jumlah_konversi')
			->where('id_iimxxmh',$id_iimxxmh)
			->where('id_iumxxmh',$id_iumxxmh_unit)
			->exec();
		$rs_jumlah_konversi = $qs_jumlah_konversi->fetch();

		$jumlah_konversi    = $rs_jumlah_konversi['jumlah_konversi'];
		$jumlah_terkecil    = $jumlah_konversi * $jumlah_unit; 
		// END get jumlah_konversi

		// BEGIN get UoM terkecil
		$qs_iumxxmh_terkecil = $db
			->query('select', 'iimummd' )
			->get([
				'id_iumxxmh as id_iumxxmh_terkecil'
			] )
			->where('iimummd.id_iimxxmh', $id_iimxxmh )
			->where('iimummd.is_terkecil', 1 )
			->exec();
		$rs_iumxxmh_terkecil = $qs_iumxxmh_terkecil->fetch();

		$id_iumxxmh_terkecil = $rs_iumxxmh_terkecil['id_iumxxmh_terkecil'];
		// END get UoM terkecil

		// BEGIN get UoM default
		$qs_iumxxmh_default = $db
			->query('select', 'iimummd' )
			->get([
				'id_iumxxmh as id_iumxxmh_default',
				'jumlah_konversi as jumlah_konversi_default'
			] )
			->where('iimummd.id_iimxxmh', $id_iimxxmh )
			->where('iimummd.is_default', 1 )
			->exec();
		$rs_iumxxmh_default = $qs_iumxxmh_default->fetch();

		$id_iumxxmh_default         = $rs_iumxxmh_default['id_iumxxmh_default'];
		$jumlah_konversi_default    = $rs_iumxxmh_default['jumlah_konversi_default'];

		$jumlah_default = $jumlah_konversi * $jumlah_unit / $jumlah_konversi_default;
		// END get UoM default

		//nama uom dan kode
		$qs_uom_unit = $db
			->query('select', 'iumxxmh' )
			->get([
				'kode',
				'nama',
				] )
			->where('id', $id_iumxxmh_unit )
			->exec();
		$rs_uom_unit = $qs_uom_unit->fetch();
		$iumxxmh_unit_kode = $rs_uom_unit['kode'];
		$iumxxmh_unit_nama = $rs_uom_unit['nama'];

		$qu_wptittd = $db
			->query('update', 'wptittd')
			->set('id_iumxxmh_unit',$id_iumxxmh_unit)
			->set('id_iumxxmh_terkecil',$id_iumxxmh_terkecil)
			->set('id_iumxxmh_default',$id_iumxxmh_default)
			->set('jumlah_unit',$jumlah_unit)
			->set('jumlah_konversi',$jumlah_konversi)
			->set('jumlah_terkecil',$jumlah_terkecil) 
			->set('jumlah_default',$jumlah_default) 
			->where('id',$idTransaksi)
			->exec();

		$qu_iivxxrd = $db
			->query('update', 'iivxxrd')
			->set('iumxxmh_unit_kode',$iumxxmh_unit_kode)
			->set('iumxxmh_unit_nama',$iumxxmh_unit_nama)
			->set('id_iumxxmh_unit',$id_iumxxmh_unit)
			->set('id_iumxxmh_terkecil',$id_iumxxmh_terkecil)
			->set('id_iumxxmh_default',$id_iumxxmh_default)
			->set('jumlah_unit',-$jumlah_unit)
			->set('jumlah_konversi',$jumlah_konversi)
			->set('jumlah_terkecil',-$jumlah_terkecil) 
			->set('jumlah_default',-$jumlah_default) 
			->where('keterangan',$keterangan)
			->exec();

		
		

		if(!empty($qu_iivxxrd)){
			$db->commit();
			$status_code  = 200;
			$message      = 'Inventory Berhasil Diupdate';
			$type_message = 'success';
		}else{
			$db->rollback();
			$status_code  = 500;
			$message      = 'Inventory Gagal Diupdate!';
			$type_message = 'error';
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$message      = 'Inventory Gagal Diupdate! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Inventory Gagal Diupdate!, ' . $e->getMessage();
		$type_message = 'error';
	}
	// build response
	$data = array(
		'status_code'    => $status_code,
		'message'        => $message,
		'type_message'   => $type_message,
		'idTransaksi'    => $idTransaksi,
	);

	// tampilkan results
    include( "../../../../usersc/helpers/fn_ajax_results.php" );
?>