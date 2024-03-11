<?php 
    /**
     * Digunakan untuk populate options data item group 2
     * Item Group 2 merupakan child dari Item Group 1
     * Table terkait    : iigx2mh
     * Parameter        : 
     *  @param Number id_iigxxmh        : nilai id Item Group 1
     *  @param Number id_iigx2mh_old    : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_iigxxmh'] > 0){
        $id_iigxxmh = $_GET['id_iigxxmh'];
    }else{
        $id_iigxxmh = 0;
    }

    if($_GET['id_iigx2mh_old'] > 0){
        $id_iigx2mh_old = $_GET['id_iigx2mh_old'];
    }else{
        $id_iigx2mh_old = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_iigx2mh_old > 0){
        $qs_iigx2mh_self = $db
            ->query('select', 'iigx2mh')
            ->get([
                'id as id',
                'nama as text'
            ])
            ->where('id', $id_iigx2mh_old )            
            ->exec();
        $rs_iigx2mh_self = $qs_iigx2mh_self->fetchAll();
    }else{
        $rs_iigx2mh_self = [];
    }
    // END query self

    // BEGIN query options all except self
    $qs_iigx2mh_all = $db
        ->query('select', 'iigx2mh')
        ->get([
            'id as id',
            'nama as text'
        ])
        ->where('transaction_state',1)
        ->where('id', $id_iigx2mh_old, '<>' )
        ->where('id_iigxxmh', $id_iigxxmh )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('kode', '%' . $q . '%', 'LIKE' )
                ->or_where('nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_iigx2mh_all = $qs_iigx2mh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_iigx2mh_self) > 0){
        $rs_opt = array_merge($rs_iigx2mh_self, $rs_iigx2mh_all);
    }else{
        $rs_opt = $rs_iigx2mh_all;
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