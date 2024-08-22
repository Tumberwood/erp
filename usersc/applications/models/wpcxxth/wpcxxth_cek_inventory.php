<?php 
    require_once( "../../../../users/init.php" );
    require_once( "../../../../usersc/lib/DataTables.php" );
    require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	require_once( "../../../../usersc/vendor/autoload.php");
	require_once( "../../../helpers/hakakses_s_fn.php" );

	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    // END definisi variable untuk fn_ajax_results.php

	$wlpxxmh_kode = $_POST['wlpxxmh_kode'];
	$id_wloxxmh = $_POST['id_wloxxmh'];
	$jumlah_pl = $_POST['jumlah_pl'];
	$id_wplxxth = $_POST['id_wplxxth'];

	$qs_wpllptd = $db
		->raw()
		->bind(':jumlah_pl', $jumlah_pl)
		->bind(':wlpxxmh_kode', $wlpxxmh_kode)
		->bind(':id_wloxxmh', $id_wloxxmh)
		->exec('SELECT
					COUNT(a.id) c_id
				FROM wtrittd a
				WHERE is_replenishment = 1 
				AND a.id_wloxxmh_tujuan = :id_wloxxmh
				AND a.wlpxxmh_kode = :wlpxxmh_kode
				AND a.jumlah_unit =:jumlah_pl
				AND keterangan = "wplxxth_id_'.$id_wplxxth.'"'
		);
	$rs_wpllptd = $qs_wpllptd->fetch();

	$c_id = $rs_wpllptd['c_id'];
	if ($c_id > 0) {
		$message = "Harap menuju Menu Item Transfer Replenishment untuk melakukan konfirmasi Replenishment!";
		$status_code = 500;
	} else {
		$message = "";
		$status_code = 200;
	}

    $data = array(
        'message' => $message,
        'status_code' => $status_code,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>