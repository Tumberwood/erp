<?php
    /**
     * Digunakan untuk menghitung harga dari Purchase Order untuk di insert ke field terkait harga di prcittd
     * 
     */

	include( "../../../../users/init.php" );
	include( "../../../../usersc/lib/DataTables.php" );
	include( "../../../../usersc/helpers/datatables_fn_debug.php" );
    require '../../../../usersc/vendor/autoload.php';

    use Carbon\Carbon;
	
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
		
		// ganti movement type sesuai jenis transaksi
		$imtxxmh_kode = 101;

		$id    = $_POST['id_transaksi_h'];
		$state = $_POST['state'];

        $qr__blank = $db
            ->raw()
            ->bind(':variable1', variable1)
            ->bind(':variable2', variable2)
            ->exec('UPDATE prcittd a
                LEFT JOIN podittd b ON b.id = a.id_podittd
                SET
                    a.harga_unit = b.harga_unit,
                    a.subtotal = b.harga_unit * a.jumlah_unit,
                    a.diskon_jenis = b.diskon_jenis,
                    a.diskon_persen = b.diskon_persen,
                    a.diskon_value = b.diskon_value,
                    a.diskon_final = IF(b.diskon_persen>0,b.diskon_persen/100*(b.harga_unit * a.jumlah_unit),b.diskon_value),
                    a.dpp = (b.harga_unit*a.jumlah_unit) - IF(b.diskon_persen>0,b.diskon_persen/100*(b.harga_unit * a.jumlah_unit),b.diskon_value)
                WHERE
                    a.id_where = $variable
            ');

		// check apakah query ada resultnya
		if(!empty($qi_iivxxrd)){
			$db->commit();
			$status_code  = '200';
			$message      = 'Goods Receive Berhasil Dilakukan';
			$type_message = 'success';
			// parameter lain
		}else{
			$db->rollback();
			$status_code  = '500';
			$message      = 'Goods Receive Gagal Dilakukan';
			$type_message = 'error';
			// parameter lain
		}
	}catch(PDOException $e){
		$db->rollback();
		$status_code  = '500';
		$message      = 'Goods Receive Gagal Dilakukan! ' . $e->getMessage();
		$type_message = 'error';
	}catch (Exception $e) {
		$db->rollback();
		$status_code = 500;
		$message = 'Goods Receive Gagal Dilakukan!, ' . $e->getMessage();
		$type_message = 'error';
	}
	// build response
	$data = array(
		'status_code'    => $status_code,
		'message'        => $message,
		'type_message'   => $type_message
	);

	// tampilkan results
    include( "../../../../usersc/helpers/fn_ajax_results.php" );
?>