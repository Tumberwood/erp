<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : wlotpmh
     * Parameter        : 
     *  - id_wlotpmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_wlotpmh_old'] > 0){
        $id_wlotpmh_old = $_GET['id_wlotpmh_old'];
    }else{
        $id_wlotpmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_wlotpmh_old > 0){
        $qs_wlotpmh_self = $db
            ->query('select', 'wlotpmh')
            ->get([
                'wlotpmh.id as id',
                'IF(
                    wlotpmh.kode IS NULL, 
                    wlotpmh.nama,
                    IF(
                        wlotpmh.nama IS NULL, 
                        wlotpmh.kode,
                        CONCAT(wlotpmh.kode," - ",wlotpmh.nama)
                    )
                ) as text'
            ])
            ->where('wlotpmh..id', $id_wlotpmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_wlotpmh_self = $qs_wlotpmh_self->fetchAll();
    }else{
        $rs_wlotpmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_wlotpmh_all = $db
        ->query('select', 'wlotpmh')
        ->get([
            'wlotpmh.id as id',
            'IF(
                wlotpmh.kode IS NULL, 
                wlotpmh.nama,
                IF(
                    wlotpmh.nama IS NULL, 
                    wlotpmh.kode,
                    CONCAT(wlotpmh.kode," - ",wlotpmh.nama)
                )
            ) as text'
        ])
        ->where('wlotpmh.transaction_state',1)
        ->where('wlotpmh.id', $id_wlotpmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('wlotpmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('wlotpmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_wlotpmh_all = $qs_wlotpmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_wlotpmh_self) > 0){
        $rs_opt = array_merge($rs_wlotpmh_self, $rs_wlotpmh_all);
    }else{
        $rs_opt = $rs_wlotpmh_all;
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