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
                    TIMESTAMPDIFF(YEAR, b.tanggal_masuk, CURDATE()) AS masakerja, 
                    COUNT(*) AS c_masakerja 
                FROM hemxxmh a
                LEFT JOIN hemjbmh b ON b.id_hemxxmh = a.id
                WHERE a.transaction_state = 1 AND b.tanggal_masuk IS NOT NULL
                GROUP BY 
                    masakerja 
                ORDER BY 
                    masakerja;
        ');
    $rs_hemxxmh = $qs_hemxxmh->fetchAll();

    $category = array();
	$category['name'] = 'Masa Kerja';
	
	$series1 = array();
	$series1['name'] =  'Karyawan';
	
	foreach ($rs_hemxxmh as $key => $row) {
		$category['data'][] = $row['masakerja'];
		$series1['data'][] = $row['c_masakerja'];
	}
	
	$results = array();
	array_push($results,$category);
	array_push($results,$series1);

    $data = array(
        'd_hr_profile_empMK' => $results
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>

