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

	$json['hakakses'] = $hakakses;
	$s_id_users = $hakakses['s_id_users'];
	$s_username = $hakakses['s_username'];

	try{
		$db->transaction();

		$id_transaksi_h    = $_POST['id_transaksi_h'];
		$pesan = "";
		
		// $qs_ggswmsh = $db
		// 	->query('select', 'ggswmsh' )
		// 	->get([
		// 		'vehicle_capacity',
		// 	] )
		// 	->where('id', 1 )
		// 	->exec();
		// $rs_ggswmsh = $qs_ggswmsh->fetch();
		// $vehicle_capacity = $rs_ggswmsh['vehicle_capacity'];
				
		$qs_pl = $db
			->raw()
			->bind(':id_transaksi_h', $id_transaksi_h)
			->exec('SELECT
						a.id,
						a.id_iumxxmh_unit,
						a.id_iimxxmh,
						SUM(a.jumlah_unit) sum_jumlah_input,
						-- b.gw berat,
						-- b.panjang * b.lebar * b.tinggi dimensi,
						SUM(a.jumlah_unit * b.gw) weight,
						-- SUM(a.jumlah_unit * (b.panjang * b.lebar * b.tinggi)) dimension_cm,
						SUM((a.jumlah_unit * (b.panjang * b.lebar * b.tinggi)) / 100) dimension_meter,
						SUM(a.jumlah_default) sum_jumlah_default, -- untuk uom vehicle = Unit
						c.uom_vehicle,
						c.jumlah_unit_vehicle,
						d.nama
						
						-- a.jumlah_unit * b.gw weight,
						-- (a.jumlah_unit * (b.panjang * b.lebar * b.tinggi)) dimension_cm,
						-- (a.jumlah_unit * (b.panjang * b.lebar * b.tinggi)) / 100 dimension_meter
					FROM wplittd a
					LEFT JOIN iimummd b ON b.id_iimxxmh = a.id_iimxxmh AND b.id_iumxxmh = a.id_iumxxmh_unit
					LEFT JOIN wplxxth c ON c.id = a.id_wplxxth
					LEFT JOIN lvtxxmh d ON d.id = c.id_lvtxxmh
					WHERE a.id_wplxxth = :id_transaksi_h AND a.transaction_state <> -9
		');
		
		$rs_pl = $qs_pl->fetch();

		$vehicle_capacity = $rs_pl['uom_vehicle'];

		$jumlah_unit_vehicle = number_format($rs_pl['jumlah_unit_vehicle'],2);
		$nama = $rs_pl['nama'];
		
		$weight = number_format($rs_pl['weight'], 2);
		$dimension_meter = number_format($rs_pl['dimension_meter'], 2);
		$sum_jumlah_default = number_format($rs_pl['sum_jumlah_default'], 2);

		//Jika None maka tidak perlu muncul confirm
		if ($vehicle_capacity == 'None') {
			$pesan = '';
		} else if ($vehicle_capacity == 'Weight') {
			if ($weight > $jumlah_unit_vehicle) {
				$pesan = "Weight Picking List Melebihi Kapasitas Kendaraan.\n\n$nama: $jumlah_unit_vehicle kg\nPicking List: $weight kg\n\nApakah Anda Tetap Ingin Melanjutkan?";
			} else {
				$pesan = '';
			}
		} else if ($vehicle_capacity == 'Unit') {
			if ($sum_jumlah_default > $jumlah_unit_vehicle) {
				$pesan = "Unit Picking List Melebihi Kapasitas Kendaraan.\n\n$nama: $jumlah_unit_vehicle \nPicking List: $sum_jumlah_default\n\nApakah Anda Tetap Ingin Melanjutkan?";
			} else {
				$pesan = '';
			}
		} else {
			if ($dimension_meter > $jumlah_unit_vehicle) {
				$pesan = "Dimensi Picking List Melebihi Kapasitas Kendaraan.\n\n$nama: $jumlah_unit_vehicle m³\nPicking List: $dimension_meter m³\n\nApakah Anda Tetap Ingin Melanjutkan?";
			} else {
				$pesan = '';
			}
		}

		if($pesan == ''){
			
			$db->commit();
			$status_code  = 200;
			$message      = 'Job Picking Berhasil di Generate';
			$type_message = 'success';
			
		}else{
			// $db->rollback();
			$db->commit();
			$status_code  = 500;
			$message      = 'Job Picking Gagal di Generate!'. '<br>' . $pesan;
			$type_message = 'error';
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = 500;
		$pesan  = '';
		$message      = 'Job Picking Gagal di Generate! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$pesan  = '';
		$message = 'Job Picking Gagal di Generate!, ' . $e->getMessage();
		$type_message = 'error';
	}
	// build response
	$data = array(
		'status_code'    => $status_code,
		'message'        => $message,
		'type_message'   => $type_message,
		'pesan'   => $pesan,
	);

	// tampilkan results
    include( "../../../../usersc/helpers/fn_ajax_results.php" );
?>