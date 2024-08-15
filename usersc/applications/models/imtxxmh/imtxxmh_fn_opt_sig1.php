<?php 
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : imtxxmh
     * Parameter        : 
     *  - id_imtxxmh_old    : data existing (untuk keperluan edit), dipakai di query self
     */        
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    // END definisi variable untuk fn_ajax_results.php

    // BEGIN select2 pagination preparation
    $page        = $_GET['page'];
    $resultCount = 10;
    $offset      = ($page - 1) * $resultCount;
    // END select2 pagination preparation

    if($_GET['id_imtxxmh_old'] > 0){
        $id_imtxxmh_old = $_GET['id_imtxxmh_old'];
    }else{
        $id_imtxxmh_old = 0;
    }

    if( count($_GET['movement_type_group']) > 0 ){
        $movement_type_group = $_GET['movement_type_group'];
    }else{
        $movement_type_group = [];
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_imtxxmh_old > 0){
        $qs_imtxxmh_self = $db
            ->query('select', 'imtxxmh')
            ->get([
                'id as id',
                'movement_type as text'
            ])
            ->where('id', $id_imtxxmh_old )
            ->limit($resultCount)
            ->offset($offset)
            ->exec();
        $rs_imtxxmh_self = $qs_imtxxmh_self->fetchAll();
    }else{
        $rs_imtxxmh_self = [];
    }
    // END query self

    // BEGIN query options all except self
    $qs_imtxxmh_all = $db
        ->query('select', 'imtxxmh')
        ->get([
            'id as id',
            'movement_type as text'
        ])
        ->order('kode')
        ->where('transaction_state',1)
        ->where('id', $id_imtxxmh_old, '<>' )
        ->where('module','SIG')
        ->where_in( ' movement_type_group', $_GET['movement_type_group'])
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('nama', '%' . $q . '%', 'LIKE' )
                ;
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_imtxxmh_all = $qs_imtxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_imtxxmh_self) > 0){
        $rs_opt = array_merge($rs_imtxxmh_self, $rs_imtxxmh_all);
    }else{
        $rs_opt = $rs_imtxxmh_all;
    }
    // END menggabungkan options
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>