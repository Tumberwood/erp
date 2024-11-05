<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : gbrxxmh
     * Parameter        : 
     *  - id_gbrxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
     */
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    require_once( "../../../../usersc/vendor/autoload.php");
	include_once( "../../../helpers/hakakses_s_fn.php" );
	use Carbon\Carbon;

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    // $tanggal_akhir = $_POST['tanggal_akhir'];
    $tanggal_akhir = new Carbon();
    ;

    $qs_hemxxmh = $db
        ->raw()
        ->bind(':s_id_hemxxmh', $s_id_hemxxmh )
        ->exec('SELECT
                    a.id,
                    a.nama,
                    a.jenis,
                    ifnull(c_htl,0) c_leave
                FROM httlpmh a
                LEFT JOIN (
                    SELECT
                        COUNT(b.id) c_htl,
                        b.id_hemxxmh,
                        b.id_httlpmh
                    FROM httlptd b
                    WHERE ( YEAR(b.tanggal_awal) = YEAR(NOW()) OR YEAR(b.tanggal_akhir) = YEAR(NOW()) )
                    AND b.transaction_state = 1
                    GROUP BY b.id_httlpmh, id_hemxxmh
                ) c ON c.id_httlpmh = a.id AND c.id_hemxxmh = :s_id_hemxxmh
                WHERE a.is_dashboard_personal = 1
    
    ');
    $rs_hemxxmh = $qs_hemxxmh->fetchAll();

    $data = array(
        's_id_hemxxmh' => $s_id_hemxxmh,
        'hemxxmh' => $rs_hemxxmh
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>