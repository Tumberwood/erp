<?php 
    /**
     * Digunakan untuk menghitung tarif pajak berdasarkan iitxxmh
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
    
    $id_iitxxmh   = $_POST['id_iitxxmh'];

    $qs_autofill = $db
        ->raw()
        ->bind(':id_iitxxmh', $id_iitxxmh)
        ->exec('
            SELECT
                ftxxxmh.id,
                ftxxxmh.is_progressif,
                ftxrtmd.batas_bawah,
                ftxrtmd.batas_atas,
                ftxrtmd.tarif
            FROM iitxxmh
            LEFT JOIN ftxxxmh ON ftxxxmh.id = iitxxmh.id_ftxxxmh
            LEFT JOIN ftxrtmd ON ftxrtmd.id_ftxxxmh = ftxxxmh.id
            WHERE 
                iitxxmh.id = :id_iitxxmh
        ');
    $rs_autofill = $qs_autofill->fetch();
    
    $data = array(
        'rs_autofill' => $rs_autofill
    );
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>