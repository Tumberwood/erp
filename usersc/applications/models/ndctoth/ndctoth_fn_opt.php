<?php 
    /**
     * Digunakan untuk populate options data document transfer out
     * Table terkait    : ndctoth
     * Parameter        : 
     *  - id_ndctoth_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_ndctoth_old'] > 0){
        $id_ndctoth_old = $_GET['id_ndctoth_old'];
    }else{
        $id_ndctoth_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_ndctoth_old > 0){
        $qs_ndctoth_self = $db
            ->query('select', 'ndctoth')
            ->get([
                'ndctoth.id as id',
                'ndctoth.kode as text'
            ])
            ->where('ndctoth..id', $id_ndctoth_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_ndctoth_self = $qs_ndctoth_self->fetchAll();
    }else{
        $rs_ndctoth_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_ndctoth_all = $db
        ->query('select', 'ndctoth')
        ->get([
            'ndctoth.id as id',
            'ndctoth.kode as text'
        ])
        ->where('ndctoth.transaction_state',1)
        ->where('ndctoth.id', $id_ndctoth_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('ndctoth.kode', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_ndctoth_all = $qs_ndctoth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_ndctoth_self) > 0){
        $rs_opt = array_merge($rs_ndctoth_self, $rs_ndctoth_all);
    }else{
        $rs_opt = $rs_ndctoth_all;
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