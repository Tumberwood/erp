<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : wloctmh
     * Parameter        : 
     *  - id_wloctmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_wloctmh_old'] > 0){
        $id_wloctmh_old = $_GET['id_wloctmh_old'];
    }else{
        $id_wloctmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_wloctmh_old > 0){
        $qs_wloctmh_self = $db
            ->query('select', 'wloctmh')
            ->get([
                'wloctmh.id as id',
                'IF(
                    wloctmh.kode IS NULL, 
                    wloctmh.nama,
                    IF(
                        wloctmh.nama IS NULL, 
                        wloctmh.kode,
                        CONCAT(wloctmh.kode," - ",wloctmh.nama)
                    )
                ) as text'
            ])
            ->where('wloctmh..id', $id_wloctmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_wloctmh_self = $qs_wloctmh_self->fetchAll();
    }else{
        $rs_wloctmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_wloctmh_all = $db
        ->query('select', 'wloctmh')
        ->get([
            'wloctmh.id as id',
            'IF(
                wloctmh.kode IS NULL, 
                wloctmh.nama,
                IF(
                    wloctmh.nama IS NULL, 
                    wloctmh.kode,
                    CONCAT(wloctmh.kode," - ",wloctmh.nama)
                )
            ) as text'
        ])
        ->where('wloctmh.transaction_state',1)
        ->where('wloctmh.id', $id_wloctmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('wloctmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('wloctmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_wloctmh_all = $qs_wloctmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_wloctmh_self) > 0){
        $rs_opt = array_merge($rs_wloctmh_self, $rs_wloctmh_all);
    }else{
        $rs_opt = $rs_wloctmh_all;
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