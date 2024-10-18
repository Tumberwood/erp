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

	$id_hrctstd_kostik   = $_POST['id_hrctstd_kostik'];

    $qs_hrctstd_kostik = $db
        ->raw()
        ->bind(':id_hrctstd_kostik', $id_hrctstd_kostik)
        ->exec('SELECT N, G, A, L, P, I, T, V, X, S, B, O, R, D, C, Z, E, K, F,	W
                FROM hrctstd_kostik
                WHERE id = :id_hrctstd_kostik');
    $rs_hrctstd_kostik = $qs_hrctstd_kostik->fetch();

    $combinedValues = array();

    foreach ($rs_hrctstd_kostik as $key => $hrctstd_kostik) {
        // Skip null hrctstd_kostiks
        if ($hrctstd_kostik !== null) {
            $combinedValues[] = $hrctstd_kostik;
        }
    }

    $series1 = array();
    $series1['name'] =  'Skor';
    $series1['type'] =  'area';
    $series1['data'] = $combinedValues;

    
	$results = array();
	array_push($results,$series1);

    $data = array(
        'results_emp_izin' => $results,
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>

