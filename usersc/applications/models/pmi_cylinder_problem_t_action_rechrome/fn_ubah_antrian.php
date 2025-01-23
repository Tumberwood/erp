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

    $plus_minus = $_POST['plus_minus'];
    $id = $_POST['id'];
    
    $qu_antrian = $db
        ->raw()
        ->bind(':id', $id)
        ->exec('UPDATE pmi_cylinder_problem_t_action 
                SET 
                    antrian = antrian '.$plus_minus.' 1
                WHERE id = :id
    ');

    $data = array(
        'qu_antrian' => $qu_antrian
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>