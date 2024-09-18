<?php 
    /**
     * Digunakan untuk populate options data hgnlgmh
     * Table terkait    : hgnlgmh
     * Parameter        : 
     *  - id_hgnlgmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_hgnlgmh_old'] > 0){
        $id_hgnlgmh_old = $_GET['id_hgnlgmh_old'];
    }else{
        $id_hgnlgmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hgnlgmh_old > 0){
        $qs_hgnlgmh_self = $db
            ->query('select', 'hgnlgmh')
            ->get([
                'hgnlgmh.id as id',
                'IF(
                    hgnlgmh.kode IS NULL, 
                    hgnlgmh.nama,
                    IF(
                        hgnlgmh.nama IS NULL, 
                        hgnlgmh.kode,
                        CONCAT(hgnlgmh.kode," - ",hgnlgmh.nama)
                    )
                ) as text'
            ])
            ->where('hgnlgmh..id', $id_hgnlgmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hgnlgmh_self = $qs_hgnlgmh_self->fetchAll();
    }else{
        $rs_hgnlgmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_hgnlgmh_all = $db
        ->query('select', 'hgnlgmh')
        ->get([
            'hgnlgmh.id as id',
            'IF(
                hgnlgmh.kode IS NULL, 
                hgnlgmh.nama,
                IF(
                    hgnlgmh.nama IS NULL, 
                    hgnlgmh.kode,
                    CONCAT(hgnlgmh.kode," - ",hgnlgmh.nama)
                )
            ) as text'
        ])
        ->where('hgnlgmh.transaction_state',1)
        ->where('hgnlgmh.id', $id_hgnlgmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('hgnlgmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('hgnlgmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_hgnlgmh_all = $qs_hgnlgmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hgnlgmh_self) > 0){
        $rs_opt = array_merge($rs_hgnlgmh_self, $rs_hgnlgmh_all);
    }else{
        $rs_opt = $rs_hgnlgmh_all;
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