<?php 
    /**
     * Digunakan untuk populate options data hfmxxmh
     * Table terkait    : hfmxxmh
     * Parameter        : 
     *  - id_hfmxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_hfmxxmh_old'] > 0){
        $id_hfmxxmh_old = $_GET['id_hfmxxmh_old'];
    }else{
        $id_hfmxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hfmxxmh_old > 0){
        $qs_hfmxxmh_self = $db
            ->query('select', 'hfmxxmh')
            ->get([
                'hfmxxmh.id as id',
                'IF(
                    hfmxxmh.kode IS NULL, 
                    hfmxxmh.nama,
                    IF(
                        hfmxxmh.nama IS NULL, 
                        hfmxxmh.kode,
                        CONCAT(hfmxxmh.kode," - ",hfmxxmh.nama)
                    )
                ) as text'
            ])
            ->where('hfmxxmh..id', $id_hfmxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hfmxxmh_self = $qs_hfmxxmh_self->fetchAll();
    }else{
        $rs_hfmxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_hfmxxmh_all = $db
        ->query('select', 'hfmxxmh')
        ->get([
            'hfmxxmh.id as id',
            'IF(
                hfmxxmh.kode IS NULL, 
                hfmxxmh.nama,
                IF(
                    hfmxxmh.nama IS NULL, 
                    hfmxxmh.kode,
                    CONCAT(hfmxxmh.kode," - ",hfmxxmh.nama)
                )
            ) as text'
        ])
        ->where('hfmxxmh.transaction_state',1)
        ->where('hfmxxmh.id', $id_hfmxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('hfmxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('hfmxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_hfmxxmh_all = $qs_hfmxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hfmxxmh_self) > 0){
        $rs_opt = array_merge($rs_hfmxxmh_self, $rs_hfmxxmh_all);
    }else{
        $rs_opt = $rs_hfmxxmh_all;
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