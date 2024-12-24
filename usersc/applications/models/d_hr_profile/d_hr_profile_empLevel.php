<?php 
    /**
     * Digunakan 
     */
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    require_once( "../../../../usersc/vendor/autoload.php");
	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    // $tanggal_akhir = $_POST['tanggal_akhir'];
    $tanggal_akhir = new Carbon();

    $qs_hemxxmh = $db
        ->raw()
        ->exec('SELECT
                    a.id,
                    a.nama as hevxxmh_nama,
                    if(c.id, COUNT(c.id), 0) c_hevxxmh_nama
                FROM hevxxmh a
                LEFT JOIN hemjbmh b ON b.id_hevxxmh = a.id
                LEFT JOIN hemxxmh c ON c.id = b.id_hemxxmh AND c.transaction_state = 1
                GROUP BY a.id
                ORDER BY a.id
        ');
    $rs_hemxxmh = $qs_hemxxmh->fetchAll();

    $category = array();
	$category['name'] = 'Grup Level';
	
	$series1 = array();
	$series1['name'] =  'Karyawan';
	
	foreach ($rs_hemxxmh as $key => $row) {
		$category['data'][] = $row['hevxxmh_nama'];
		$series1['data'][] = $row['c_hevxxmh_nama'];
	}
	
	$results = array();
	array_push($results,$category);
	array_push($results,$series1);

    $data = array(
        'results_emp_level' => $results
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>

