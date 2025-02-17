<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : licxxmh
     * Parameter        : 
     *  - id_licxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_licxxmh_old'] > 0){
        $id_licxxmh_old = $_GET['id_licxxmh_old'];
    }else{
        $id_licxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_licxxmh_old > 0){
        $qs_licxxmh_self = $db
            ->query('select', 'licxxmh')
            ->get([
                'licxxmh.id as id',
                'kode as text'
            ])
            ->where('licxxmh.id', $id_licxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_licxxmh_self = $qs_licxxmh_self->fetchAll();
    }else{
        $rs_licxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_licxxmh_all = $db
        ->query('select', 'licxxmh')
        ->get([
            'licxxmh.id as id',
            'kode as text'
        ])
        ->where('licxxmh.transaction_state',1)
        ->where('licxxmh.id', $id_licxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('licxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('licxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_licxxmh_all = $qs_licxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_licxxmh_self) > 0){
        $rs_opt = array_merge($rs_licxxmh_self, $rs_licxxmh_all);
    }else{
        $rs_opt = $rs_licxxmh_all;
    }
    $c_rs_opt = count($rs_opt);    
    // END menggabungkan options

    // BEGIN finalisasi paginasi select2
    $endCount  = $offset + $resultCount;
    $morePages = $endCount > $c_rs_opt;
    // END finalisasi paginasi select2
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>