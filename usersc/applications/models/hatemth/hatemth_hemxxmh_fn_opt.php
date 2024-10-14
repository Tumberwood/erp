<?php 
    /**
     * Digunakan untuk populate options data hatemth
     * Table terkait    : hatemth
     * Parameter        : 
     *  - id_hatemth_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_hatemth_old'] > 0){
        $id_hatemth_old = $_GET['id_hatemth_old'];
    }else{
        $id_hatemth_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hatemth_old > 0){
        $qs_hatemth_self = $db
            ->query('select', 'hatemth')
            ->get([
                'hatemth.id as id',
                'IF(
                    hatemth.kode IS NULL, 
                    hemxxmh.nama,
                    IF(
                        hemxxmh.nama IS NULL, 
                        hatemth.kode,
                        CONCAT(hatemth.kode," - ",hemxxmh.kode," - ",hemxxmh.nama)
                    )
                ) as text'
            ])
            ->join('hemxxmh','hemxxmh.id = hatemth.id_hemxxmh','LEFT' )
            ->where('hatemth..id', $id_hatemth_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hatemth_self = $qs_hatemth_self->fetchAll();
    }else{
        $rs_hatemth_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_hatemth_all = $db
        ->query('select', 'hatemth')
        ->get([
            'hatemth.id as id',
            'IF(
                hatemth.kode IS NULL, 
                hemxxmh.nama,
                IF(
                    hemxxmh.nama IS NULL, 
                    hatemth.kode,
                    CONCAT(hatemth.kode," - ",hemxxmh.kode," - ",hemxxmh.nama)
                )
            ) as text'
        ])
        ->join('hemxxmh','hemxxmh.id = hatemth.id_hemxxmh','LEFT' )
        ->where('hatemth.transaction_state',1 )
        ->where('hatemth.id', $id_hatemth_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('hatemth.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('hemxxmh.nama', '%' . $q . '%', 'LIKE' )
                ->or_where('hemxxmh.kode', '%' . $q . '%', 'LIKE' )
                ;
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_hatemth_all = $qs_hatemth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hatemth_self) > 0){
        $rs_opt = array_merge($rs_hatemth_self, $rs_hatemth_all);
    }else{
        $rs_opt = $rs_hatemth_all;
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