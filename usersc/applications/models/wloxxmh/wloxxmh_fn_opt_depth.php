<?php 
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : wloxxmh
     * Parameter        : 
     *  - id_wloxxmh_depth_old    : data existing (untuk keperluan edit), dipakai di query self
     */        
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $not_numcheck = 1;
    // END definisi variable untuk fn_ajax_results.php

    // BEGIN select2 pagination preparation
    $page        = $_GET['page'];
    $resultCount = 10;
    $offset      = ($page - 1) * $resultCount;
    // END select2 pagination preparation

    if($_GET['id_wloxxmh_depth_old'] > 0){
        $id_wloxxmh_depth_old = $_GET['id_wloxxmh_depth_old'];
    }else{
        $id_wloxxmh_depth_old = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_wloxxmh_depth_old > 0){
        $qs_wloxxmh_self = $db
            ->query('select', 'wloxxmh')
            ->get([
                'distinct depth_name as text'
            ])
            ->where('id', $id_wloxxmh_depth_old )
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
            'distinct depth_name as text'
        ])
        ->order('depth_name')
        ->where('transaction_state',1)
        ->where('id', $id_wloxxmh_depth_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r->where('depth_name', '%' . $q . '%', 'LIKE' );
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