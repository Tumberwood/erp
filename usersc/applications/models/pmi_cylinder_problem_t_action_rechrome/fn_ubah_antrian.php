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
    
    $qs_antrian = $db
        ->raw()
        ->bind(':id', $id)
        ->exec('SELECT
                    id,
                    (
                            SELECT
                                antrian
                            FROM pmi_cylinder_problem_t_action
                            WHERE id = :id
                    ) antrian
                FROM pmi_cylinder_problem_t_action
                WHERE antrian IN (
                    SELECT
                        antrian '.$plus_minus.' 1
                    FROM pmi_cylinder_problem_t_action 
                    WHERE id = :id AND action = "Rechrome"
                )
                AND action = "Rechrome"
    ');
    $rs_antrian = $qs_antrian->fetch();

    $id_tergeser = $rs_antrian['id'];
    $antrian = $rs_antrian['antrian'];

    $qu_antrian_digeser = $db
        ->raw()
        ->bind(':id_tergeser', $id_tergeser)
        ->bind(':antrian', $antrian)
        ->exec('UPDATE pmi_cylinder_problem_t_action 
                SET 
                    antrian = :antrian
                WHERE id = :id_tergeser
    ');
    
    if ($qu_antrian_digeser) {
        $qu_antrian_now = $db
            ->raw()
            ->bind(':id', $id)
            ->exec('UPDATE pmi_cylinder_problem_t_action 
                    SET 
                        antrian = antrian '.$plus_minus.' 1
                    WHERE id = :id
        ');
    }

    $data = array(
        'qu_antrian_now' => $qu_antrian_now
    );

    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>