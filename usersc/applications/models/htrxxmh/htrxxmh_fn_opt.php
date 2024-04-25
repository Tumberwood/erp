<?php 
    /**
     * Digunakan untuk populate options data htrxxmh
     * Table terkait    : htrxxmh
     * Parameter        : 
     *  - id_htrxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_htrxxmh_old'] > 0){
        $id_htrxxmh_old = $_GET['id_htrxxmh_old'];
    }else{
        $id_htrxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_htrxxmh_old > 0){
        $qs_htrxxmh_self = $db
            ->query('select', 'htrxxmh')
            ->get([
                'htrxxmh.id as id',
                'IF(
                    htrxxmh.kode IS NULL, 
                    htrxxmh.nama,
                    IF(
                        htrxxmh.nama IS NULL, 
                        htrxxmh.kode,
                        CONCAT(htrxxmh.kode," - ",htrxxmh.nama)
                    )
                ) as text'
            ])
            ->where('htrxxmh..id', $id_htrxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_htrxxmh_self = $qs_htrxxmh_self->fetchAll();
    }else{
        $rs_htrxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_htrxxmh_all = $db
        ->query('select', 'htrxxmh')
        ->get([
            'htrxxmh.id as id',
            'IF(
                htrxxmh.kode IS NULL, 
                htrxxmh.nama,
                IF(
                    htrxxmh.nama IS NULL, 
                    htrxxmh.kode,
                    CONCAT(htrxxmh.kode," - ",htrxxmh.nama)
                )
            ) as text'
        ])
        ->where('htrxxmh.transaction_state',1)
        ->where('htrxxmh.id', $id_htrxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('htrxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('htrxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_htrxxmh_all = $qs_htrxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_htrxxmh_self) > 0){
        $rs_opt = array_merge($rs_htrxxmh_self, $rs_htrxxmh_all);
    }else{
        $rs_opt = $rs_htrxxmh_all;
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