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

    $id_gfrxxth =  $_POST['id_gfrxxth'];
    $qs_gfrxxth = $db
        ->query('select', 'gfrfltd')
        ->get([
            'MAX(urutan) as urutan_max'
        ])
        ->where('gfrfltd.transaction_state', -9, '<>')
        ->where('gfrfltd.id_gfrxxth', $_POST['id_gfrxxth'] )
        ->exec();
        
    $rs_gfrxxth = $qs_gfrxxth->fetch();
    $data = array(
        'rs_gfrxxth' => $rs_gfrxxth
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>