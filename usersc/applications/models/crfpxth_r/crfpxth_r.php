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

	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$id_scuxxmh = isset($_POST['id_scuxxmh']) ? $_POST['id_scuxxmh'] : [];

	$whereCustomer = '';

	if (!empty($id_scuxxmh) && is_array($id_scuxxmh)) {
		$id_list = implode(',', array_map('intval', $id_scuxxmh)); // Konversi ke format SQL yang aman
		$whereCustomer = " AND b.id_grlxxmh_customer IN ($id_list)";
	}

	echo $start_date;

	if ($start_date != '' && $end_date != '') {
		$qs_crfpxth = $db
			->raw()
			->bind(':start_date', $start_date)
			->bind(':end_date', $end_date)
			->exec('SELECT
						b.id,
						DATE_FORMAT(a.tanggal, "%d %b %Y") tanggal,
						a.kode,
						d.nama customer,
						e.kode kode_so,
						DATE_FORMAT(b.tanggal_dibutuhkan_customer, "%d %b %Y") tanggal_dibutuhkan_customer,
						DATE_FORMAT(b.tanggal_dibutuhkan, "%d %b %Y") tanggal_dibutuhkan,
						c.nama item,
						b.jumlah_unit,
						f.kode uom
					FROM crfpxth a
					LEFT JOIN crfittd b ON b.id_crfpxth = a.id
					LEFT JOIN iimxxmh c ON c.id = b.id_iimxxmh
					LEFT JOIN grlxxmh d ON d.id = b.id_grlxxmh_customer
					LEFT JOIN sodxxth e ON e.id = b.id_sodxxth
					LEFT JOIN iumxxmh f ON f.id = b.id_iumxxmh_unit
					WHERE a.tanggal BETWEEN :start_date AND :end_date'
					.$whereCustomer
			)
		;
	  	$rs_crfpxth = $qs_crfpxth->fetchAll();
	} else {
		$rs_crfpxth = [];
	}
	


    $data = array(
        'rfp' => $rs_crfpxth
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>