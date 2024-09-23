<?php 
    /**
     * Digunakan untuk populate options data msnxxmh
     * Table terkait    : msnxxmh
     * Parameter        : 
     *  - id_msnxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_msnxxmh_old'] > 0){
        $id_msnxxmh_old = $_GET['id_msnxxmh_old'];
    }else{
        $id_msnxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_msnxxmh_old > 0){
        $qs_msnxxmh_self = $db
            ->query('select', 'msnxxmh')
            ->get([
                'msnxxmh.id as id',
                'IF(
                    msnxxmh.kode IS NULL, 
                    msnxxmh.nama,
                    IF(
                        msnxxmh.nama IS NULL, 
                        msnxxmh.kode,
                        CONCAT(msnxxmh.kode," - ",msnxxmh.nama)
                    )
                ) as text'
            ])
            ->where('msnxxmh..id', $id_msnxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_msnxxmh_self = $qs_msnxxmh_self->fetchAll();
    }else{
        $rs_msnxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_msnxxmh_all = $db
        ->query('select', 'msnxxmh')
        ->get([
            'msnxxmh.id as id',
            'IF(
                msnxxmh.kode IS NULL, 
                msnxxmh.nama,
                IF(
                    msnxxmh.nama IS NULL, 
                    msnxxmh.kode,
                    CONCAT(msnxxmh.kode," - ",msnxxmh.nama)
                )
            ) as text'
        ])
        ->where('msnxxmh.transaction_state',1)
        ->where('msnxxmh.id', $id_msnxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('msnxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('msnxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_msnxxmh_all = $qs_msnxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_msnxxmh_self) > 0){
        $rs_opt = array_merge($rs_msnxxmh_self, $rs_msnxxmh_all);
    }else{
        $rs_opt = $rs_msnxxmh_all;
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