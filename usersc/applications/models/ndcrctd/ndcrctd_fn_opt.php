<?php 
    /**
     * Digunakan untuk populate options data Document Receive
     * Table terkait    : ndcrctd
     * Parameter        : 
     *  - id_ndcrctd_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_ndcrctd_old'] > 0){
        $id_ndcrctd_old = $_GET['id_ndcrctd_old'];
    }else{
        $id_ndcrctd_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_ndcrctd_old > 0){
        $qs_ndcrctd_self = $db
            ->query('select', 'ndcrctd')
            ->get([
                'ndcrctd.id as id',
                'IF(
                    ndcrctd.dokumen_nomor IS NULL, 
                    ndcrctd.pengirim,
                    IF(
                        ndcrctd.pengirim IS NULL, 
                        ndcrctd.dokumen_nomor,
                        CONCAT(ndcrctd.dokumen_nomor," - ",ndcrctd.pengirim)
                    )
                ) as text'
            ])
            ->where('ndcrctd..id', $id_ndcrctd_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_ndcrctd_self = $qs_ndcrctd_self->fetchAll();
    }else{
        $rs_ndcrctd_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_ndcrctd_all = $db
        ->query('select', 'ndcrctd')
        ->get([
            'ndcrctd.id as id',
            'IF(
                ndcrctd.dokumen_nomor IS NULL, 
                ndcrctd.pengirim,
                IF(
                    ndcrctd.pengirim IS NULL, 
                    ndcrctd.dokumen_nomor,
                    CONCAT(ndcrctd.dokumen_nomor," - ",ndcrctd.pengirim)
                )
            ) as text'
        ])
        ->where('ndcrctd.transaction_state',1)
        ->where('ndcrctd.id', $id_ndcrctd_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('ndcrctd.dokumen_nomor', '%' . $q . '%', 'LIKE' )
                ->or_where('ndcrctd.pengirim', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_ndcrctd_all = $qs_ndcrctd_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_ndcrctd_self) > 0){
        $rs_opt = array_merge($rs_ndcrctd_self, $rs_ndcrctd_all);
    }else{
        $rs_opt = $rs_ndcrctd_all;
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