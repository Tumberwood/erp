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
    $qs_def = $db
        ->raw()
        ->exec('
            SELECT
                id,
                concat(kode, " - ", nama) as nama
            FROM fcrxxmh
            WHERE is_default = 1
        ');
    $rs_def   = $qs_def->fetch();
    $id_def   = $rs_def['id'];
    $nama_def = $rs_def['nama'];
    
    $data = array(
        'id_def' => $id_def,
        'nama_def' => $nama_def
    );
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>