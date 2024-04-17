<?php 
    /**
     * Digunakan untuk populate options data Document
     * Table terkait    : ndcxxmh
     * Parameter        : 
     *  - id_ndcxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_ndcxxmh_old'] > 0){
        $id_ndcxxmh_old = $_GET['id_ndcxxmh_old'];
    }else{
        $id_ndcxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_ndcxxmh_old > 0){
        $qs_ndcxxmh_self = $db
            ->query('select', 'ndcxxmh')
            ->get([
                'ndcxxmh.id as id',
                'ndcxxmh.dokumen_nomor as text'
            ])
            ->where('ndcxxmh..id', $id_ndcxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_ndcxxmh_self = $qs_ndcxxmh_self->fetchAll();
    }else{
        $rs_ndcxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_ndcxxmh_all = $db
        ->query('select', 'ndcxxmh')
        ->get([
            'ndcxxmh.id as id',
            'ndcxxmh.dokumen_nomor as text'
        ])
        ->where('ndcxxmh.transaction_state',1)
        ->where('ndcxxmh.id', $id_ndcxxmh_old, '<>' );
        
        if ($_GET['document_state'] == 'in') {
            $qs_ndcxxmh_all->where( function ( $r ) {
                $r
                    ->where( 'document_state', 1)
                    ->or_where( 'document_state', 3);
            } );
        } else {
            $qs_ndcxxmh_all->where( function ( $r ) {
                $r
                    ->where( 'document_state', 2)
                    ->or_where( 'document_state', 4);
            } );
        }

        $qs_ndcxxmh_all->where( function ( $r ) {
            $q = $_GET['search'];
            $r->where('ndcxxmh.dokumen_nomor', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset);

    $rs_ndcxxmh_all = $qs_ndcxxmh_all->exec()->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_ndcxxmh_self) > 0){
        $rs_opt = array_merge($rs_ndcxxmh_self, $rs_ndcxxmh_all);
    }else{
        $rs_opt = $rs_ndcxxmh_all;
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