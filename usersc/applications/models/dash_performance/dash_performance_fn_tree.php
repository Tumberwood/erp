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

    $qs_object = $db
    ->raw()
    ->exec('SELECT
                a.id,
                a.nama,
                b.nama grup,
                CONCAT(a.id, "[", a.nama, "]") obj,
                a.id_hfogrmh
            FROM hfoxxmh a
            LEFT JOIN hfogrmh b ON b.id = a.id_hfogrmh
            ORDER BY b.id, a.id;
    ');
    $rs_object = $qs_object->fetchAll();

    $chart = "graph TD\n";
    $currentGroup = "";

    foreach ($rs_object as $object) {
        if ($object['grup'] != $currentGroup) {
            if ($currentGroup != "") {
                $chart .= "end\n"; // Mengakhiri subgraph sebelumnya
            }
            $currentGroup = $object['grup'];
            $chart .= "subgraph " . $currentGroup . "\n";
        }
        // Tambahkan node ke dalam subgraph saat ini
        $chart .= "  " . $object['obj'] . "\n";
    }

    // Akhiri subgraph terakhir jika ada
    if ($currentGroup != "") {
        $chart .= "end\n";
    }

    $qs_parents = $db
    ->raw()
    ->exec('SELECT
                CONCAT(c.id, " --> ", a.id) parent,
                a.nama,
                c.nama
            FROM hfoxxmh a
            LEFT JOIN hfoxxmh_parents b ON b.id_hfoxxmh = a.id
            LEFT JOIN hfoxxmh c ON c.id = b.id_hfoxxmh_parents
            HAVING parent
    ');
    $rs_parents = $qs_parents->fetchAll();

    foreach ($rs_parents as $key => $parents) {
        $chart .= $parents['parent']."\n";
    }

    $data = array(
        'chart' => $chart,
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>

