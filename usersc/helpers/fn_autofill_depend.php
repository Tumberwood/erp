<?php 
    include_once( "../../users/init.php" );
	include_once( "../../usersc/lib/DataTables.php" );
    include( "datatables_fn_debug.php" );

    require '../../usersc/vendor/autoload.php';
	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php
    
    $tabel   = $_POST['tabel'];
    $id_tabel = $_POST['id_tabel'];

    $qs_autofill = $db
        ->raw()
        ->exec(' SELECT
                    *
                FROM '.$tabel.'
                WHERE id = '.$id_tabel
                );
    $rs_autofill = $qs_autofill->fetch();
    
    $data = array(
        'rs_autofill' => $rs_autofill
    );
    // tampilkan results
    require_once( "../../usersc/helpers/fn_ajax_results.php" );

?>