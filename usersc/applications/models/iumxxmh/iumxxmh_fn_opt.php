<?php 
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : iumxxmh
     * Parameter        : 
     *  - id_iumxxmh_old    : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_iumxxmh_old'] > 0){
        $id_iumxxmh_old = $_GET['id_iumxxmh_old'];
    }else{
        $id_iumxxmh_old = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_iumxxmh_old > 0){
        $qs_iumxxmh_self = $db
            ->query('select', 'iumxxmh')
            ->get([
                'id as id',
                'CONCAT(kode," - ",nama) as text'
            ])
            ->where('id', $id_iumxxmh_old )
            ->exec();
        $rs_iumxxmh_self = $qs_iumxxmh_self->fetchAll();
    }else{
        $rs_iumxxmh_self = [];
    }
    // END query self

    // BEGIN query options all except self
    $qs_iumxxmh_all = $db
        ->query('select', 'iumxxmh')
        ->get([
            'id as id',
            'CONCAT(kode," - ",nama) as text'
        ])
        ->where('transaction_state',1)
        ->where('id', $id_iumxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('kode', '%' . $q . '%', 'LIKE' )
                ->or_where('nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_iumxxmh_all = $qs_iumxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_iumxxmh_self) > 0){
        $rs_opt = array_merge($rs_iumxxmh_self, $rs_iumxxmh_all);
    }else{
        $rs_opt = $rs_iumxxmh_all;
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