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

    $id_iimxxmh = $_POST['id_iimxxmh'];

    $qs_loc = $db
        ->raw()
        ->bind(':id_iimxxmh', $id_iimxxmh)
        ->exec('SELECT
                    COUNT(b.id) c_smaller
                FROM wimlotd a
                LEFT JOIN wloxxmh b ON b.id = a.id_wloxxmh
                WHERE a.id_iimxxmh = :id_iimxxmh AND b.is_smaller = 1
        '
        );

    $rs_loc = $qs_loc->fetch();

    if (!empty($rs_loc)) {
        $c_smaller = $rs_loc['c_smaller'];

        if ($c_smaller > 0) {
            $message = "";
            $status_code = 200;
        } else {
            $message = "Lokasi tujuan replenishment belum di set!";
            $status_code = 500;
        }
    } else {
        $message = "Lokasi tujuan replenishment belum di set!";
        $status_code = 500;
    }

    $data = array(
        'status_code' => $status_code,
        'message' => $message,
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>