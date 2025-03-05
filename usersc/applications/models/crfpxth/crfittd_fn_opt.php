<?php 
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : crfittd
     * Parameter        : 
     *  - id_crfittd_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_crfittd_old'] > 0){
        $id_crfittd_old = $_GET['id_crfittd_old'];
    }else{
        $id_crfittd_old = 0;
    }

    if($_GET['id_crfpxth'] > 0){
        $id_crfpxth = $_GET['id_crfpxth'];
    }else{
        $id_crfpxth = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_crfittd_old > 0){
        $qs_crfittd_self = $db
            ->query('select', 'crfittd')
            ->get([
                'crfittd.id as id',
                'CONCAT(iimxxmh.nama) as text'
            ])
            ->join('iimxxmh','iimxxmh.id = crfittd.id_iimxxmh','LEFT' )
            ->where('crfittd.id', $id_crfittd_old )
            ->exec();
        $rs_crfittd_self = $qs_crfittd_self->fetchAll();
    }else{
        $rs_crfittd_self = [];
    }
    // END query self

    // BEGIN query options all except self
    $qs_crfittd_all = $db
        ->query('select', 'crfittd')
        ->get([
            'crfittd.id as id',
            'CONCAT(iimxxmh.nama) as text'
        ])
        ->join('iimxxmh','iimxxmh.id = crfittd.id_iimxxmh','LEFT' )
        ->where('iimxxmh.transaction_state',1)
        ->where('crfittd.id_crfpxth',$id_crfpxth)
        ->where('crfittd.id', $id_crfittd_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('iimxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_crfittd_all = $qs_crfittd_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_crfittd_self) > 0){
        $rs_opt = array_merge($rs_crfittd_self, $rs_crfittd_all);
    }else{
        $rs_opt = $rs_crfittd_all;
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