<?php 
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    if($_POST['id_httlpmh'] > 0){
        $qs_httlpmh = $db
            ->query('select', 'httlpmh')
            ->get([
                'httlpmh.jenis_jam as jenis_jam'
            ])
            ->where('id', $_POST['id_httlpmh'] )
            ->exec();
        $rs_httlpmh = $qs_httlpmh->fetch();
        $data = array(
            'rs_httlpmh' => $rs_httlpmh
        );
    }
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>