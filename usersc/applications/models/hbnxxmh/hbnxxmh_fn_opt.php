<?php 
    /**
     * Digunakan untuk populate options data provinsi
     * Table terkait    : hbnxxmh
     * Parameter        : 
     *  - id_hbnxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
     */
    require_once( "../../../../users/init.php" );
	require_once( "../../../../usersc/lib/DataTables.php" );
	require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = 0;
    // END definisi variable untuk fn_ajax_results.php

    // BEGIN select2 pagination preparation
    $page        = $_GET['page'];
    $resultCount = 10;
    $offset      = ($page - 1) * $resultCount;
    // END select2 pagination preparation

    if($_GET['id_hbnxxmh_old'] > 0){
        $id_hbnxxmh_old = $_GET['id_hbnxxmh_old'];
    }else{
        $id_hbnxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hbnxxmh_old > 0){
        $qs_hbnxxmh_self = $db
            ->query('select', 'hbnxxmh')
            ->get([
                'hbnxxmh.id as id',
                'hbnxxmh.nama as text'
            ])
            ->where('hbnxxmh.id', $id_hbnxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hbnxxmh_self = $qs_hbnxxmh_self->fetchAll();
    }else{
        $rs_hbnxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_hbnxxmh_all = $db
        ->query('select', 'hbnxxmh')
        ->get([
            'hbnxxmh.id as id',
            'hbnxxmh.nama as text'
        ])
        ->where('hbnxxmh.transaction_state',1)
        ->where('hbnxxmh.id', $id_hbnxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('hbnxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->order('hbnxxmh.nama')
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_hbnxxmh_all = $qs_hbnxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hbnxxmh_self) > 0){
        $rs_opt = array_merge($rs_hbnxxmh_self, $rs_hbnxxmh_all);
    }else{
        $rs_opt = $rs_hbnxxmh_all;
    }
    $c_rs_opt = count($rs_opt);
    // END menggabungkan options

    // BEGIN finalisasi paginasi select2
    $endCount  = $offset + $resultCount;
    $morePages = $endCount >= $c_rs_opt;
    // END finalisasi paginasi select2
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>