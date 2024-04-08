<?php 
    /**
     * Digunakan untuk populate options data document transfer out
     * Table terkait    : ndoxxth
     * Parameter        : 
     *  - id_ndoxxth_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_ndoxxth_old'] > 0){
        $id_ndoxxth_old = $_GET['id_ndoxxth_old'];
    }else{
        $id_ndoxxth_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_ndoxxth_old > 0){
        $qs_ndoxxth_self = $db
            ->query('select', 'ndoxxth')
            ->get([
                'ndoxxth.id as id',
                'ndoxxth.kode as text'
            ])
            ->where('ndoxxth..id', $id_ndoxxth_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_ndoxxth_self = $qs_ndoxxth_self->fetchAll();
    }else{
        $rs_ndoxxth_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_ndoxxth_all = $db
        ->query('select', 'ndoxxth')
        ->get([
            'ndoxxth.id as id',
            'ndoxxth.kode as text'
        ])
        ->where('ndoxxth.transaction_state',1)
        ->where('ndoxxth.id', $id_ndoxxth_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('ndoxxth.kode', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_ndoxxth_all = $qs_ndoxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_ndoxxth_self) > 0){
        $rs_opt = array_merge($rs_ndoxxth_self, $rs_ndoxxth_all);
    }else{
        $rs_opt = $rs_ndoxxth_all;
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