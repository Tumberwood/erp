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

    $id_files_pointer = $_POST['id_files_pointer'];
    $qs_def = $db
        ->raw()
        ->bind(':id_files_pointer', $id_files_pointer)
        ->exec('SELECT
                    keterangan_pointer
                FROM isoittd_upload a
                WHERE a.id_files_pointer = :id_files_pointer
        ');
    $rs_def = $qs_def->fetch();
    $keterangan_pointer = $rs_def['keterangan_pointer'];

    $data = array(
        'keterangan_pointer' => $keterangan_pointer
    );
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>