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

    $id_h = $_POST['id_transaksi_h'];
    $qs_def = $db
        ->raw()
        ->bind(':id_h', $id_h)
        ->exec('    UPDATE isoittd_upload AS b
                    LEFT JOIN (
                        SELECT
                            a.id_isoittd_upload,
                            SUM(a.fisik) AS sum_fisik
                        FROM isoittd_upload_fisik AS a
                        WHERE a.id_isoittd_upload = :id_h
                    ) AS c ON c.id_isoittd_upload = b.id
                    SET 
                        b.fisik = sum_fisik,
                        b.selisih = sum_fisik - b.jumlah_terkecil,
                        b.selisih_final = sum_fisik - b.jumlah_terkecil
                    WHERE b.id = :id_h
        ');

    $data = array(
        'id_h' => $id_h
    );
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>