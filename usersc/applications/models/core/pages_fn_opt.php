<?php 
    /**
     * Digunakan untuk populate options data users
     * Table terkait    : users
     * Parameter        : 
     *  - id_users_old       : data existing (untuk keperluan edit), dipakai di query self 
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

    if($_GET['id_pages_old'] > 0){
        $id_pages_old = $_GET['id_pages_old'];
    }else{
        $id_pages_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_pages_old > 0){
        $qs_pages_self = $db
            ->query('select', 'pages')
            ->get([
                'pages.id as id',
                'pages.title as text'
            ])
            ->where('pages.id', $id_pages_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_pages_self = $qs_pages_self->fetchAll();
    }else{
        $rs_pages_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_pages_all = $db
        ->query('select', 'pages')
        ->get([
            'pages.id as id',
            'pages.title as text'
        ])
        ->where('pages.id', $id_pages_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r->where('pages.title', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_pages_all  = $qs_pages_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_pages_self) > 0){
        $rs_opt = array_merge($rs_pages_self, $rs_pages_all);
    }else{
        $rs_opt = $rs_pages_all;
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