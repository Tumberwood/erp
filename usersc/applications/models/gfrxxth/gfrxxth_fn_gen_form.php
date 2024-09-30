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

    $nama_tabel = $_POST['nama_tabel'];

    $qs_gen_form = $db
        ->raw()
        ->bind(':nama_tabel', $nama_tabel)
        ->exec('SELECT
                    b.id id_gfrfltd,
                    b.nama,
                    SUBSTRING_INDEX(SUBSTRING_INDEX(b.nama, "_", -1), ".", 1) urutan_awal,
                    b.is_required,
                    b.label,
                    b.type_data,
                    b.type
                FROM gfrfltd b
                LEFT JOIN gfrxxth a ON a.id = b.id_gfrxxth
                WHERE a.nama_tabel = :nama_tabel AND a.transaction_state = 1 AND b.transaction_state <> -9
                ORDER BY urutan
        '
        );

    $rs_gen_form = $qs_gen_form->fetchAll();
    
    $data = array(
        'rs_gen_form' => $rs_gen_form,
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>