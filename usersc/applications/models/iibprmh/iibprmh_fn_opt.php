<?php 
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : iibprmh
     * Parameter        : 
     *  - id_iibprmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_iibprmh_old'] > 0){
        $id_iibprmh_old = $_GET['id_iibprmh_old'];
    }else{
        $id_iibprmh_old = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_iibprmh_old > 0){
        $qs_iibprmh_self = $db
            ->query('select', 'iibprmh')
            ->get([
                'id as id',
                'nama as text'
            ])
            ->where('id', $id_iibprmh_old )
            ->exec();
        $rs_iibprmh_self = $qs_iibprmh_self->fetchAll();
    }else{
        $rs_iibprmh_self = [];
    }
    // END query self

    // BEGIN query options all except self
    $qs_iibprmh_all = $db
        ->query('select', 'iibprmh')
        ->get([
            'id as id',
            'nama as text'
        ])
        ->where('transaction_state',1)
        ->where('id', $id_iibprmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('kode', '%' . $q . '%', 'LIKE' )
                ->or_where('nama', '%' . $q . '%', 'LIKE' );
        } )
        ->order('nama')
        ->limit($resultCount)
        ->offset($offset)
        ->exec();

        
    $rs_iibprmh_all = $qs_iibprmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_iibprmh_self) > 0){
        $rs_opt = array_merge($rs_iibprmh_self, $rs_iibprmh_all);
    }else{
        $rs_opt = $rs_iibprmh_all;
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