<?php 
    /**
     * Digunakan untuk populate options data Document Receive
     * Table terkait    : ndrxxtd
     * Parameter        : 
     *  - id_ndrxxtd_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_ndrxxtd_old'] > 0){
        $id_ndrxxtd_old = $_GET['id_ndrxxtd_old'];
    }else{
        $id_ndrxxtd_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_ndrxxtd_old > 0){
        $qs_ndrxxtd_self = $db
            ->query('select', 'ndrxxtd')
            ->get([
                'ndrxxtd.id as id',
                'IF(
                    ndrxxtd.dokumen_nomor IS NULL, 
                    ndrxxtd.pengirim,
                    IF(
                        ndrxxtd.pengirim IS NULL, 
                        ndrxxtd.dokumen_nomor,
                        CONCAT(ndrxxtd.dokumen_nomor," - ",ndrxxtd.pengirim)
                    )
                ) as text'
            ])
            ->where('ndrxxtd..id', $id_ndrxxtd_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_ndrxxtd_self = $qs_ndrxxtd_self->fetchAll();
    }else{
        $rs_ndrxxtd_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_ndrxxtd_all = $db
        ->query('select', 'ndrxxtd')
        ->get([
            'ndrxxtd.id as id',
            'IF(
                ndrxxtd.dokumen_nomor IS NULL, 
                ndrxxtd.pengirim,
                IF(
                    ndrxxtd.pengirim IS NULL, 
                    ndrxxtd.dokumen_nomor,
                    CONCAT(ndrxxtd.dokumen_nomor," - ",ndrxxtd.pengirim)
                )
            ) as text'
        ])
        ->where('ndrxxtd.transaction_state',1)
        ->where('ndrxxtd.id', $id_ndrxxtd_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('ndrxxtd.dokumen_nomor', '%' . $q . '%', 'LIKE' )
                ->or_where('ndrxxtd.pengirim', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_ndrxxtd_all = $qs_ndrxxtd_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_ndrxxtd_self) > 0){
        $rs_opt = array_merge($rs_ndrxxtd_self, $rs_ndrxxtd_all);
    }else{
        $rs_opt = $rs_ndrxxtd_all;
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