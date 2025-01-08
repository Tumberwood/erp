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

	$start_date = $_POST['start_date'];

    $qs_skor = $db
    ->raw()
    ->bind(':start_date', $start_date)
    ->exec(' SELECT
                AVG(b.skor) avg_skor
            FROM hfsxxth a
            LEFT JOIN hfskptd b ON b.id_hfsxxth = a.id
            WHERE a.transaction_state = 1 AND a.periode = :start_date
            '
            );
    $rs_skor = $qs_skor->fetch();

    if (!empty($rs_skor)) {
        $avg_skor = $rs_skor['avg_skor'];
    } else {
        $avg_skor = 0;
    }
    

    $data = array(
        'avg_skor' => $avg_skor,
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>

