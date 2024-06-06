<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : gtxpkmh
     * Parameter        : 
     *  - id_gtxpkmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_gtxpkmh_old'] > 0){
        $id_gtxpkmh_old = $_GET['id_gtxpkmh_old'];
    }else{
        $id_gtxpkmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_gtxpkmh_old > 0){
        $qs_gtxpkmh_self = $db
            ->query('select', 'gtxpkmh')
            ->get([
                'gtxpkmh.id as id',
                'gtxpkmh.kode as text'
            ])
            ->where('gtxpkmh.id', $id_gtxpkmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_gtxpkmh_self = $qs_gtxpkmh_self->fetchAll();
    }else{
        $rs_gtxpkmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_gtxpkmh_all = $db
        ->query('select', 'gtxpkmh')
        ->get([
            'gtxpkmh.id as id',
            'gtxpkmh.kode as text'
        ])
        ->where('gtxpkmh.transaction_state',1)
        ->where('gtxpkmh.id', $id_gtxpkmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('gtxpkmh.kode', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_gtxpkmh_all = $qs_gtxpkmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_gtxpkmh_self) > 0){
        $rs_opt = array_merge($rs_gtxpkmh_self, $rs_gtxpkmh_all);
    }else{
        $rs_opt = $rs_gtxpkmh_all;
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