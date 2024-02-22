<?php 
    /**
     * Digunakan untuk menghitung tarif pajak berdasarkan iittpmh
     */
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );
	require_once( "../../../../usersc/vendor/autoload.php" );

	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php
    
    $id_iittpmh   = $_POST['id_iittpmh'];

    $qs_autofill = $db
        ->raw()
        ->bind(':id_iittpmh', $id_iittpmh)
        ->exec('
            SELECT
                ftxxxmh.id,
                ftxxxmh.is_progressif,
                ftxrtmd.batas_bawah,
                ftxrtmd.batas_atas,
                ftxrtmd.tarif
            FROM iittpmh
            LEFT JOIN ftxxxmh ON ftxxxmh.id = iittpmh.id_ftxxxmh
            LEFT JOIN ftxrtmd ON ftxrtmd.id_ftxxxmh = ftxxxmh.id
            WHERE 
                iittpmh.id = :id_iittpmh
        ');
    $rs_autofill = $qs_autofill->fetch();
    
    $data = array(
        'rs_autofill' => $rs_autofill
    );
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>