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

    if($_POST['id_hrremth'] > 0){
        $qs_hrremth = $db
            ->raw()
            ->bind(':id_hrremth', $_POST['id_hrremth'])
            ->exec('SELECT
                        COUNT(ifnull(id,0)) c_id
                    FROM hrrertd
                    WHERE id_hrremth = :id_hrremth
                    '
			);
        $rs_hrremth = $qs_hrremth->fetch();
        $data = array(
            'rs_hrremth' => $rs_hrremth
        );
    }
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>