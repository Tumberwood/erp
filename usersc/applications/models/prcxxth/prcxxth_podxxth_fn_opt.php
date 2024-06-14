<?php
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : podxxth
     * Parameter        : 
     *  - id_podxxth_old   : data existing (untuk keperluan edit), dipakai di query self
     *  - id_grlxxmh_supplier            : data id_grlxxmh_supplier
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

    if($_GET['id_podxxth_old'] > 0){
        $id_podxxth_old = $_GET['id_podxxth_old'];
    }else{
        $id_podxxth_old = 0;
    }

    if($_GET['id_grlxxmh_supplier'] > 0){
        $id_grlxxmh_supplier = $_GET['id_grlxxmh_supplier'];
    }else{
        $id_grlxxmh_supplier = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_podxxth_old > 0){
        $qs_podxxth_self = $db
            ->query('select', 'podxxth')
            ->get([
                'podxxth.id as id',
                'podxxth.kode as text'
            ])
            ->where('podxxth.id', $id_podxxth_old )            
            ->exec();
        $rs_podxxth_self = $qs_podxxth_self->fetchAll();
    }else{
        $rs_podxxth_self = [];
    }
    // END query self

    // BEGIN query options all except self
    $qs_podxxth_all = $db
        ->query('select', 'podxxth')
        ->get([
            'podxxth.id as id',
            'podxxth.kode as text'
        ])
        ->where('podxxth.transaction_state',1)
        ->where('podxxth.approval_state', 9)
        ->where('podxxth.id_grlxxmh_supplier', $id_grlxxmh_supplier)
        ->where('podxxth.id', $id_podxxth_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r->where('podxxth.kode', '%' . $q . '%', 'LIKE' );
        } )
        ->order('podxxth.kode')
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_podxxth_all = $qs_podxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_podxxth_self) > 0){
        $rs_opt = array_merge($rs_podxxth_self, $rs_podxxth_all);
    }else{
        $rs_opt = $rs_podxxth_all;
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