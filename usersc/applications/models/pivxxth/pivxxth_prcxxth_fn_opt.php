<?php
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : prcxxth
     * Parameter        : 
     *  - id_prcxxth_old   : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_prcxxth_old'] > 0){
        $id_prcxxth_old = $_GET['id_prcxxth_old'];
    }else{
        $id_prcxxth_old = 0;
    }

    if($_GET['id_grlxxmh_supplier'] > 0){
        $id_grlxxmh_supplier = $_GET['id_grlxxmh_supplier'];
    }else{
        $id_grlxxmh_supplier = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_prcxxth_old > 0){
        $qs_prcxxth_self = $db
            ->query('select', 'prcxxth')
            ->get([
                'prcxxth.id as id',
                'prcxxth.kode as text'
            ])
            ->where('prcxxth.id', $id_prcxxth_old )            
            ->exec();
        $rs_prcxxth_self = $qs_prcxxth_self->fetchAll();
    }else{
        $rs_prcxxth_self = [];
    }
    // END query self

    //exclude PRC yang pernah dibuat di piv yang lain
    $qs_exclude = $db
        ->query('select', 'pivxxth' )
        ->get(['id_prcxxth'] )
        ->where('transaction_state', -9, '<>' )
        ->exec();
    $rs_exclude = $qs_exclude->fetchAll();

    if (!empty($rs_exclude)) {
        $ids = array_column($rs_exclude, 'id_prcxxth');
    
        // Create the WHERE IN clause string
        $ids_exclude = '(' . implode(',', $ids) . ')';
    } else {
        $ids_exclude = '(0)';
    }

    // BEGIN query options all except self
    $qs_prcxxth_all = $db
        ->query('select', 'prcxxth')
        ->get([
            'prcxxth.id as id',
            'prcxxth.kode as text'
        ])
        ->where('prcxxth.transaction_state',1)
        // ->where('prcxxth.approval_state', 9)
        ->where('prcxxth.id_grlxxmh_supplier', $id_grlxxmh_supplier)
        ->where('prcxxth.id', $id_prcxxth_old, '<>' )
        ->where('prcxxth.id', $ids_exclude, 'NOT IN', false)
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r->where('prcxxth.kode', '%' . $q . '%', 'LIKE' );
        } )
        ->order('prcxxth.kode')
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_prcxxth_all = $qs_prcxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_prcxxth_self) > 0){
        $rs_opt = array_merge($rs_prcxxth_self, $rs_prcxxth_all);
    }else{
        $rs_opt = $rs_prcxxth_all;
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