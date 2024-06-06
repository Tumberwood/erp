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

    $id_hcd = $_POST['id_hcd'];
    $nama_tabels_d = $_POST['nama_tabels_d'];
    $c_detail = 0;
    foreach ($nama_tabels_d as $key => $det) {
        if ($det != "hcdogmd" || $det != "hcddhmd") {
            $qs_det = $db
                ->raw()
                ->bind(':id_hcd', $id_hcd)
                ->exec('SELECT
                            if(COUNT(id) > 0, 1, 0) AS c_id
                        FROM '.$det.' a
                        WHERE a.id_hcdxxmh = :id_hcd
                '
                );
        
            $rs_det = $qs_det->fetch();
            $c_detail = $c_detail + $rs_det['c_id'];
        }
    }


    
    $data = array(
        'c_detail' => $c_detail,
        'id_hcd' => $id_hcd,
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>