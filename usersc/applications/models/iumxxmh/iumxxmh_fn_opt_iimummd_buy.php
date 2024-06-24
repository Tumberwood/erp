<?php
    /**
     * Digunakan untuk populate options data UoM berdasarkan Item
     * Table terkait    : iumxxmh
     * Parameter        : 
     *  - id_iumxxmh_unit_old   : data existing (untuk keperluan edit), dipakai di query self
     *  - id_iimxxmh            : data id_iimxxmh
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

    if($_GET['id_iumxxmh_unit_old'] > 0){
        $id_iumxxmh_unit_old = $_GET['id_iumxxmh_unit_old'];
    }else{
        $id_iumxxmh_unit_old = 0;
    }

    if($_GET['id_iimxxmh'] > 0){
        $id_iimxxmh = $_GET['id_iimxxmh'];
    }else{
        $id_iimxxmh = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_iumxxmh_unit_old > 0){
        $qs_iimummd_self = $db
            ->query('select', 'iumxxmh')
            ->get([
                'iumxxmh.id as id',
                'iumxxmh.kode as text'
            ])
            ->where('iumxxmh.id', $id_iumxxmh_unit_old )            
            ->exec();
        $rs_iimummd_self = $qs_iimummd_self->fetchAll();
    }else{
        $rs_iimummd_self = [];
    }
    // END query self

    // BEGIN query options all except self
    $qs_iimummd_all = $db
        ->query('select', 'iimummd')
        ->get([
            'iumxxmh.id as id',
            'iumxxmh.kode as text'
        ])
        ->join('iumxxmh','iumxxmh.id = iimummd.id_iumxxmh','LEFT')
        ->where('iimummd.transaction_state',-9, '<>')
        ->where('iumxxmh.transaction_state',1)
        ->where('iimummd.is_iumxxmh_beli',1)
        ->where('iimummd.id_iimxxmh', $id_iimxxmh)
        ->where('iumxxmh.id', $id_iumxxmh_unit_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r->where('iumxxmh.kode', '%' . $q . '%', 'LIKE' );
        } )
        ->order('iumxxmh.kode')
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_iimummd_all = $qs_iimummd_all->fetchAll();
    if(empty($rs_iimummd_all)){
        $qs_iimummd_all = $db
            ->query('select', 'iimummd')
            ->get([
                'iumxxmh.id as id',
                'iumxxmh.kode as text'
            ])
            ->join('iumxxmh','iumxxmh.id = iimummd.id_iumxxmh','LEFT')
            ->where('iimummd.transaction_state',-9, '<>')
            ->where('iumxxmh.transaction_state',1)
            ->where('iimummd.id_iimxxmh', $id_iimxxmh)
            ->where('iumxxmh.id', $id_iumxxmh_unit_old, '<>' )
            ->where( function ( $r ) {
                $q = $_GET['search'];
                $r->where('iumxxmh.kode', '%' . $q . '%', 'LIKE' );
            } )
            ->order('iumxxmh.kode')
            ->limit($resultCount)
            ->offset($offset)
            ->exec();
        $rs_iimummd_all = $qs_iimummd_all->fetchAll();
    }
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_iimummd_self) > 0){
        $rs_opt = array_merge($rs_iimummd_self, $rs_iimummd_all);
    }else{
        $rs_opt = $rs_iimummd_all;
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