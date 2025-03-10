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
	$end_date = $_POST['end_date'];

    $qs_sisa = $db
    ->raw()
    ->bind(':start_date', $start_date)
    ->bind(':end_date', $end_date)
    ->exec('SELECT
                COUNT(a.id) c_id
            FROM hfskptd a
            LEFT JOIN hfsxxth b ON b.id = a.id_hfsxxth
            LEFT JOIN ggshrsh c ON c.id = 1
            WHERE b.transaction_state = 1 
            AND (a.skor / a.bobot_persen * 100) <= c.batas_skor_revisi
            AND b.periode BETWEEN :start_date AND :end_date
            AND a.id NOT IN (
                SELECT
                    id_hfskptd
                FROM hfasktd c
                LEFT JOIN hfaxxth d ON d.id = c.id_hfaxxth
                WHERE d.transaction_state = 1 AND c.transaction_state <> -9
            )

    ');
    $rs_sisa = $qs_sisa->fetch();

    $qs_persen = $db
    ->raw()
    ->bind(':start_date', $start_date)
    ->bind(':end_date', $end_date)
    ->exec('WITH pica AS (
                SELECT
                    SUM(IF(a.status = "Open", 1, 0)) AS c_open,
                    SUM(IF(a.status = "Done", 1, 0)) AS c_done
                FROM hfasktd a
                LEFT JOIN hfaxxth b ON b.id = a.id_hfaxxth
                LEFT JOIN hfsxxth c ON c.id = b.id_hfsxxth
                WHERE b.transaction_state = 1
                AND a.transaction_state <> -9 
                AND c.periode BETWEEN :start_date AND :end_date
            ),
            total_pica AS (
                SELECT
                    COUNT(a.id) AS c_id
                FROM hfasktd a
                LEFT JOIN hfaxxth b ON b.id = a.id_hfaxxth
                LEFT JOIN hfsxxth c ON c.id = b.id_hfsxxth
                WHERE b.transaction_state = 1
                AND a.transaction_state <> -9
                AND c.periode BETWEEN :start_date AND :end_date
            )
            SELECT 
                IFNULL(pica.c_open, 0) AS c_open,  
                IFNULL(pica.c_done, 0) AS c_done,  
                IFNULL(total_pica.c_id, 0) AS c_id,  
                IFNULL((pica.c_open / NULLIF(total_pica.c_id, 0)) * 100, 0) AS persen_open,  
                IFNULL((pica.c_done / NULLIF(total_pica.c_id, 0)) * 100, 0) AS persen_done  
            FROM pica, total_pica;

    ');
    $rs_persen = $qs_persen->fetch();

    $data = array(
        'rs_persen' => $rs_persen,
        'rs_sisa' => $rs_sisa,
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>

