<?php 
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : sdlittd
     * Parameter        : 
     *  - id_sdlittd_old       : data existing (untuk keperluan edit), dipakai di query self
     */    
    require_once( "../../../../users/init.php" );
    require_once( "../../../../usersc/lib/DataTables.php" );
    require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = false;
    // END definisi variable untuk fn_ajax_results.php

    // BEGIN select2 pagination preparation
    $page        = $_GET['page'];
    $resultCount = 10;
    $offset      = ($page - 1) * $resultCount;
    // END select2 pagination preparation

    if($_GET['id_sdlittd_old'] > 0){
        $id_sdlittd_old = $_GET['id_sdlittd_old'];
    }else{
        $id_sdlittd_old = 0;
    }
    
    if($_GET['ids_sdlxxth'] > 0){
        $id_sdlxxth = $_GET['ids_sdlxxth'];
    }else{
        $id_sdlxxth = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_sdlittd_old > 0){
        $qs_sdlittd_self = $db
            ->query('select', 'sdlittd')
            ->get([
                'sdlittd.id as id',
                'CONCAT(iimxxmh.kode," - ",iimxxmh.nama) as text'
            ])
            ->join('iimxxmh','iimxxmh.id = sdlittd.id_iimxxmh','LEFT' )
            ->where('sdlittd.id', $id_sdlittd_old )
            ->exec();
        $rs_sdlittd_self = $qs_sdlittd_self->fetchAll();
    }else{
        $rs_sdlittd_self = [];
    }
    // END query self

    // BEGIN query options all except self
    $qs_sdlittd_all = $db
        ->query('select', 'sdlittd')
        ->get([
            'sdlittd.id as id',
            'CONCAT(iimxxmh.kode," - ",iimxxmh.nama) as text'
        ])
        ->join('iimxxmh','iimxxmh.id = sdlittd.id_iimxxmh','LEFT' )
        ->where('sdlittd.id', $id_sdlittd_old, '<>' )
        ->where('sdlittd.id_sdlxxth', $id_sdlxxth)
        ->where('sdlittd.jumlah_terkecil_os', 0, '>')
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('iimxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('iimxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_sdlittd_all = $qs_sdlittd_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_sdlittd_self) > 0){
        $rs_opt = array_merge($rs_sdlittd_self, $rs_sdlittd_all);
    }else{
        $rs_opt = $rs_sdlittd_all;
    }
    $c_rs_opt = count($rs_opt);
    // END menggabungkan options

    // BEGIN untuk keperluan paginasi select2
    $endCount  = $offset + $resultCount;
    $morePages = $endCount > $c_rs_opt;
    // END untuk keperluan paginasi select2
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>