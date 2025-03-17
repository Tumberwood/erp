<?php 
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : ittxxmh
     * Parameter        : 
     *  - id_ittxxmh_old    : data existing (untuk keperluan edit), dipakai di query self
     */        
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    // $c_rs_opt  = 0;
    // $morePages = false;
    // END definisi variable untuk fn_ajax_results.php

    // BEGIN select2 pagination preparation
    $page        = $_GET['page'];
    $resultCount = 10;
    $offset      = ($page - 1) * $resultCount;
    // END select2 pagination preparation

    if($_GET['id_ittxxmh_old'] > 0){
        $id_ittxxmh_old = $_GET['id_ittxxmh_old'];
    }else{
        $id_ittxxmh_old = 0;
    }

    if(isset($_GET['movement_type_group'])){
        $movement_type_group = '('.$_GET['movement_type_group'].')';
        $w_like = 'IN';
    }else{
        $movement_type_group = '(-9)';
        $w_like = 'NOT IN';
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_ittxxmh_old > 0){
        $qs_ittxxmh_self = $db
            ->query('select', 'ittxxmh')
            ->get([
                'ittxxmh.id as id',
                'CONCAT(ittxxmh.kode," - ",ittxxmh.nama) as text'
            ])
            ->join('imtxxmh','imtxxmh.kode = ittxxmh.imtxxmh_kode','LEFT' )
            ->where('ittxxmh.id', $id_ittxxmh_old )
            ->limit($resultCount)
            ->offset($offset)
            ->exec();
        $rs_ittxxmh_self = $qs_ittxxmh_self->fetchAll();
    }else{
        $rs_ittxxmh_self = [];
    }
    // END query self

    // BEGIN query options all except self
    $qs_ittxxmh_all = $db
        ->query('select', 'ittxxmh')
        ->get([
            'ittxxmh.id as id',
            'CONCAT(ittxxmh.kode," - ",ittxxmh.nama) as text'
        ])
        ->join('imtxxmh','imtxxmh.kode = ittxxmh.imtxxmh_kode','LEFT' )
        ->order('ittxxmh.kode')
        ->where('ittxxmh.transaction_state',1)
        ->where('ittxxmh.id', $id_ittxxmh_old, '<>' )
        ->where('imtxxmh.movement_type_group', $movement_type_group, $w_like, false )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('ittxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('ittxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_ittxxmh_all = $qs_ittxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_ittxxmh_self) > 0){
        $rs_opt = array_merge($rs_ittxxmh_self, $rs_ittxxmh_all);
    }else{
        $rs_opt = $rs_ittxxmh_all;
    }
    // $c_rs_opt = count($rs_opt);
    // END menggabungkan options

    // BEGIN untuk keperluan paginasi select2
    // $endCount  = $offset + $resultCount;
    // $morePages = $endCount > $c_rs_opt;
    // END untuk keperluan paginasi select2
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>