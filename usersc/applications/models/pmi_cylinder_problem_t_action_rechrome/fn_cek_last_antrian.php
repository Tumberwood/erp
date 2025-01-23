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

    $qs_antrian = $db
        ->raw()
        ->exec('SELECT
                    IFNULL(max(antrian),0) max_antrian
                FROM pmi_cylinder_problem_t_action
                WHERE action = "Rechrome" AND transaction_state <> -9
    ');
    $rs_antrian = $qs_antrian->fetch();

    $max_antrian = $rs_antrian['max_antrian'];

    $data = array(
        'max_antrian' => $max_antrian
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>