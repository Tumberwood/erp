<?php 
    /**
     * Digunakan untuk populate options data Expedition
     * Table terkait    : grlxxmh
     * Parameter        : 
     *  - id_grlxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
     */
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    // BEGIN select2 pagination preparation
    $page        = $_GET['page'];
    $resultCount = 10;
    $offset      = ($page - 1) * $resultCount;
    // END select2 pagination preparation

    if($_GET['id_grlxxmh_old'] > 0){
        $id_grlxxmh_old = $_GET['id_grlxxmh_old'];
    }else{
        $id_grlxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_grlxxmh_old > 0){
        $qs_grlxxmh_self = $db
            ->query('select', 'grlxxmh')
            ->get([
                'grlxxmh.id as id',
                'IF(
                    grlxxmh.kode IS NULL, 
                    grlxxmh.nama,
                    IF(
                        grlxxmh.nama IS NULL, 
                        grlxxmh.kode,
                        CONCAT(grlxxmh.kode," - ",grlxxmh.nama)
                    )
                ) as text'
            ])
            ->where('grlxxmh..id', $id_grlxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_grlxxmh_self = $qs_grlxxmh_self->fetchAll();
    }else{
        $rs_grlxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_grlxxmh_all = $db
        ->query('select', 'grlxxmh')
        ->get([
            'grlxxmh.id as id',
            'IF(
                grlxxmh.kode IS NULL, 
                grlxxmh.nama,
                IF(
                    grlxxmh.nama IS NULL, 
                    grlxxmh.kode,
                    CONCAT(grlxxmh.kode," - ",grlxxmh.nama)
                )
            ) as text'
        ])
        ->where('grlxxmh.transaction_state',1)
        ->where('grlxxmh.id', $id_grlxxmh_old, '<>' )
        ->where('grlxxmh.is_expedition', 1 )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('grlxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('grlxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_grlxxmh_all = $qs_grlxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_grlxxmh_self) > 0){
        $rs_opt = array_merge($rs_grlxxmh_self, $rs_grlxxmh_all);
    }else{
        $rs_opt = $rs_grlxxmh_all;
    }
    $c_rs_opt = count($rs_opt);    
    // END menggabungkan options

    // BEGIN finalisasi paginasi select2
    $endCount  = $offset + $resultCount;
    $morePages = $endCount > $c_rs_opt;
    // END finalisasi paginasi select2
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>