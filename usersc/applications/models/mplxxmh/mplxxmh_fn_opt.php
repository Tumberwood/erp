<?php 
    /**
     * Digunakan untuk populate options data mplxxmh
     * Table terkait    : mplxxmh
     * Parameter        : 
     *  - id_mplxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_mplxxmh_old'] > 0){
        $id_mplxxmh_old = $_GET['id_mplxxmh_old'];
    }else{
        $id_mplxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_mplxxmh_old > 0){
        $qs_mplxxmh_self = $db
            ->query('select', 'mplxxmh')
            ->get([
                'mplxxmh.id as id',
                'IF(
                    mplxxmh.kode IS NULL, 
                    mplxxmh.nama,
                    IF(
                        mplxxmh.nama IS NULL, 
                        mplxxmh.kode,
                        CONCAT(mplxxmh.kode," - ",mplxxmh.nama)
                    )
                ) as text'
            ])
            ->where('mplxxmh..id', $id_mplxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_mplxxmh_self = $qs_mplxxmh_self->fetchAll();
    }else{
        $rs_mplxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_mplxxmh_all = $db
        ->query('select', 'mplxxmh')
        ->get([
            'mplxxmh.id as id',
            'IF(
                mplxxmh.kode IS NULL, 
                mplxxmh.nama,
                IF(
                    mplxxmh.nama IS NULL, 
                    mplxxmh.kode,
                    CONCAT(mplxxmh.kode," - ",mplxxmh.nama)
                )
            ) as text'
        ])
        ->where('mplxxmh.transaction_state',1)
        ->where('mplxxmh.id', $id_mplxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('mplxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('mplxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_mplxxmh_all = $qs_mplxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_mplxxmh_self) > 0){
        $rs_opt = array_merge($rs_mplxxmh_self, $rs_mplxxmh_all);
    }else{
        $rs_opt = $rs_mplxxmh_all;
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