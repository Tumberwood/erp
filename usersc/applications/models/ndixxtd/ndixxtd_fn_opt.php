<?php 
    /**
     * Digunakan untuk populate options data Document Issue
     * Table terkait    : ndixxtd
     * Parameter        : 
     *  - id_ndixxtd_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_ndixxtd_old'] > 0){
        $id_ndixxtd_old = $_GET['id_ndixxtd_old'];
    }else{
        $id_ndixxtd_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_ndixxtd_old > 0){
        $qs_ndixxtd_self = $db
            ->query('select', 'ndixxtd')
            ->get([
                'ndixxtd.id as id',
                'IF(
                    ndixxtd.kode IS NULL, 
                    ndixxtd.nama,
                    IF(
                        ndixxtd.nama IS NULL, 
                        ndixxtd.kode,
                        CONCAT(ndixxtd.kode," - ",ndixxtd.nama)
                    )
                ) as text'
            ])
            ->where('ndixxtd..id', $id_ndixxtd_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_ndixxtd_self = $qs_ndixxtd_self->fetchAll();
    }else{
        $rs_ndixxtd_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_ndixxtd_all = $db
        ->query('select', 'ndixxtd')
        ->get([
            'ndixxtd.id as id',
            'IF(
                ndixxtd.kode IS NULL, 
                ndixxtd.nama,
                IF(
                    ndixxtd.nama IS NULL, 
                    ndixxtd.kode,
                    CONCAT(ndixxtd.kode," - ",ndixxtd.nama)
                )
            ) as text'
        ])
        ->where('ndixxtd.transaction_state',1)
        ->where('ndixxtd.id', $id_ndixxtd_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('ndixxtd.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('ndixxtd.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_ndixxtd_all = $qs_ndixxtd_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_ndixxtd_self) > 0){
        $rs_opt = array_merge($rs_ndixxtd_self, $rs_ndixxtd_all);
    }else{
        $rs_opt = $rs_ndixxtd_all;
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