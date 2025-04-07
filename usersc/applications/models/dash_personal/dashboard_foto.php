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
        ->bind(':s_id_users', $s_id_users )
        ->exec('SELECT
                    b.web_path,
                    a.gender,
                    ifnull(b.web_path, if(a.gender = "Laki-laki", "../../../files/uploads/def_male.png", "../../../files/uploads/def_female.png")) url_foto
                FROM hemxxmh a
                LEFT JOIN files b ON b.id = a.id_files_foto
                -- WHERE a.id = :s_id_hemxxmh
                WHERE a.id_users = :s_id_users
    
    ');
    $rs_hemxxmh = $qs_hemxxmh->fetch();

    $data = array(
        's_id_hemxxmh' => $s_id_hemxxmh,
        'hemxxmh' => $rs_hemxxmh
    );
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>