<?php 
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    require '../../../../usersc/vendor/autoload.php';
	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    $id_isoxxth_upload_filter = $_POST['id_isoxxth_upload_filter'];

    $qs_belum_ada_fisik = $db
        ->raw()
        ->bind(':id_isoxxth_upload_filter', $id_isoxxth_upload_filter)
        ->exec('SELECT
                    COUNT(a.id) AS c_belum_dihitung
                FROM isoittd_upload a 
                LEFT JOIN isoxxth_upload b ON b.id = a.id_isoxxth_upload
                WHERE (b.id = :id_isoxxth_upload_filter OR b.id_isoxxth_upload_parent = :id_isoxxth_upload_filter) AND a.fisik IS NULL AND a.is_skip = 0 AND a.transaction_state <> -9
        '
        );

    $rs_belum_ada_fisik = $qs_belum_ada_fisik->fetch();
    $c_belum_dihitung = $rs_belum_ada_fisik['c_belum_dihitung'];
    
    $data = array(
        'c_belum_dihitung' => $c_belum_dihitung,
        'id_isoxxth_upload_filter' => $id_isoxxth_upload_filter,
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>