<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : wloznmh
     * Parameter        : 
     *  - id_wloznmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_wloznmh_old'] > 0){
        $id_wloznmh_old = $_GET['id_wloznmh_old'];
    }else{
        $id_wloznmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_wloznmh_old > 0){
        $qs_wloznmh_self = $db
            ->query('select', 'wloznmh')
            ->get([
                'wloznmh.id as id',
                'IF(
                    wloznmh.kode IS NULL, 
                    wloznmh.nama,
                    IF(
                        wloznmh.nama IS NULL, 
                        wloznmh.kode,
                        CONCAT(wloznmh.kode," - ",wloznmh.nama)
                    )
                ) as text'
            ])
            ->where('wloznmh..id', $id_wloznmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_wloznmh_self = $qs_wloznmh_self->fetchAll();
    }else{
        $rs_wloznmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_wloznmh_all = $db
        ->query('select', 'wloznmh')
        ->get([
            'wloznmh.id as id',
            'IF(
                wloznmh.kode IS NULL, 
                wloznmh.nama,
                IF(
                    wloznmh.nama IS NULL, 
                    wloznmh.kode,
                    CONCAT(wloznmh.kode," - ",wloznmh.nama)
                )
            ) as text'
        ])
        ->where('wloznmh.transaction_state',1)
        ->where('wloznmh.id', $id_wloznmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('wloznmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('wloznmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_wloznmh_all = $qs_wloznmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_wloznmh_self) > 0){
        $rs_opt = array_merge($rs_wloznmh_self, $rs_wloznmh_all);
    }else{
        $rs_opt = $rs_wloznmh_all;
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