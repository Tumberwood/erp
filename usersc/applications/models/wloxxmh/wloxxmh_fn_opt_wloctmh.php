<?php 
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : wloxxmh
     * Parameter        : 
     *  - id_wloxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_wloxxmh_old'] > 0){
        $id_wloxxmh_old = $_GET['id_wloxxmh_old'];
    }else{
        $id_wloxxmh_old = 0;
    }

    if(isset($_GET['id_iwhxxmh']) && !empty($_GET['id_iwhxxmh']) ){
        $id_iwhxxmh = $_GET['id_iwhxxmh'];
    }else{
        $id_iwhxxmh = 0;
    }
    
    if(isset($_GET['ids_wloctmh']) && !empty($_GET['ids_wloctmh']) ){
        $id_wloctmh = $_GET['ids_wloctmh'];
        $w_wloctmh = '=';
    }else{
        $id_wloctmh = -9;
        $w_wloctmh = '<>';
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_wloxxmh_old > 0){
        $qs_wloxxmh_self = $db
            ->query('select', 'wloxxmh')
            ->get([
                'id as id',
                'CONCAT(kode," - ",nama) as text'
            ])
            ->where('id', $id_wloxxmh_old )
            ->exec();
        $rs_wloxxmh_self = $qs_wloxxmh_self->fetchAll();
    }else{
        $rs_wloxxmh_self = [];
    }
    // END query self

    // BEGIN query options all except self
    $qs_wloxxmh_all = $db
        ->query('select', 'wloxxmh')
        ->get([
            'id as id',
            'CONCAT(kode," - ",nama) as text'
        ])
        ->where('transaction_state',1)
        ->where('id', $id_wloxxmh_old, '<>' )
        ->where('id_iwhxxmh', $id_iwhxxmh )
        ->where('id_wloctmh', $id_wloctmh, $w_wloctmh )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('kode', '%' . $q . '%', 'LIKE' )
                ->or_where('nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_wloxxmh_all = $qs_wloxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_wloxxmh_self) > 0){
        $rs_opt = array_merge($rs_wloxxmh_self, $rs_wloxxmh_all);
    }else{
        $rs_opt = $rs_wloxxmh_all;
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