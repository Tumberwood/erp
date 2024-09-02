<?php 
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : prcittd
     * Parameter        : 
     *  - id_prcittd_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_prcittd_old'] > 0){
        $id_prcittd_old = $_GET['id_prcittd_old'];
    }else{
        $id_prcittd_old = 0;
    }
    
    if($_GET['ids_prcxxth'] > 0){
        $id_prcxxth = $_GET['ids_prcxxth'];
    }else{
        $id_prcxxth = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_prcittd_old > 0){
        $qs_prcittd_self = $db
            ->query('select', 'prcittd')
            ->get([
                'prcittd.id as id',
                'CONCAT(iimxxmh.kode," - ",iimxxmh.nama) as text'
            ])
            ->join('iimxxmh','iimxxmh.id = prcittd.id_iimxxmh','LEFT' )
            ->where('prcittd.id', $id_prcittd_old )
            ->exec();
        $rs_prcittd_self = $qs_prcittd_self->fetchAll();
    }else{
        $rs_prcittd_self = [];
    }
    // END query self

    // BEGIN query options all except self
    $qs_prcittd_all = $db
        ->query('select', 'prcittd')
        ->get([
            'prcittd.id as id',
            'CONCAT(iimxxmh.kode," - ",iimxxmh.nama) as text'
        ])
        ->join('iimxxmh','iimxxmh.id = prcittd.id_iimxxmh','LEFT' )
        ->where('prcittd.id', $id_prcittd_old, '<>' )
        ->where('prcittd.id_prcxxth', $id_prcxxth)
        ->where('prcittd.jumlah_terkecil_os', 0, '>')
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('iimxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('iimxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_prcittd_all = $qs_prcittd_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_prcittd_self) > 0){
        $rs_opt = array_merge($rs_prcittd_self, $rs_prcittd_all);
    }else{
        $rs_opt = $rs_prcittd_all;
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