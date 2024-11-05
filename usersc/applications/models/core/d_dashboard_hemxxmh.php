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
        ->bind(':id_users', $_SESSION['user'] )
        ->exec('SELECT 
                    hemxxmh.kode AS hemxxmh_kode,
                    hemxxmh.nama AS hemxxmh_nama,
                    hodxxmh.nama AS hodxxmh_nama,
                    hetxxmh.nama AS hetxxmh_nama,
                    CONCAT(
                        TIMESTAMPDIFF(YEAR, hemjbmh.tanggal_masuk, CURDATE()), " Tahun", 
                        CASE 
                            WHEN TIMESTAMPDIFF(YEAR, hemjbmh.tanggal_masuk, CURDATE()) != 1 THEN "s" 
                            ELSE "" 
                        END, 
                        " ", 
                        TIMESTAMPDIFF(MONTH, hemjbmh.tanggal_masuk, CURDATE()) % 12, " Bulan", 
                        CASE 
                            WHEN TIMESTAMPDIFF(MONTH, hemjbmh.tanggal_masuk, CURDATE()) % 12 != 1 THEN "s" 
                            ELSE "" 
                        END
                    ) AS masakerja
                FROM 
                    hemxxmh
                LEFT JOIN 
                    hemjbmh ON hemjbmh.id_hemxxmh = hemxxmh.id
                LEFT JOIN 
                    hodxxmh ON hodxxmh.id = hemjbmh.id_hodxxmh
                LEFT JOIN 
                    hetxxmh ON hetxxmh.id = hemjbmh.id_hetxxmh
                WHERE 
                    hemxxmh.id_users = :id_users
    
    ');
    $rs_hemxxmh = $qs_hemxxmh->fetch();

    $data = array(
        'hemxxmh' => $rs_hemxxmh
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>