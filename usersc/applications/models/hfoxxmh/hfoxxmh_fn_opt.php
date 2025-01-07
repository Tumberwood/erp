<?php 
    /**
     * Digunakan untuk populate options data hfoxxmh
     * Table terkait    : hfoxxmh
     * Parameter        : 
     *  - id_hfoxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_hfoxxmh_old'] > 0){
        $id_hfoxxmh_old = $_GET['id_hfoxxmh_old'];
    }else{
        $id_hfoxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hfoxxmh_old > 0){
        $qs_hfoxxmh_self = $db
            ->query('select', 'hfoxxmh')
            ->get([
                'hfoxxmh.id as id',
                'IF(
                    hfoxxmh.kode IS NULL, 
                    hfoxxmh.nama,
                    IF(
                        hfoxxmh.nama IS NULL, 
                        hfoxxmh.kode,
                        CONCAT(hfoxxmh.kode," - ",hfoxxmh.nama)
                    )
                ) as text'
            ])
            ->where('hfoxxmh..id', $id_hfoxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hfoxxmh_self = $qs_hfoxxmh_self->fetchAll();
    }else{
        $rs_hfoxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_hfoxxmh_all = $db
        ->query('select', 'hfoxxmh')
        ->get([
            'hfoxxmh.id as id',
            'IF(
                hfoxxmh.kode IS NULL, 
                hfoxxmh.nama,
                IF(
                    hfoxxmh.nama IS NULL, 
                    hfoxxmh.kode,
                    CONCAT(hfoxxmh.kode," - ",hfoxxmh.nama)
                )
            ) as text'
        ])
        ->where('hfoxxmh.transaction_state',1)
        ->where('hfoxxmh.id', $id_hfoxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('hfoxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('hfoxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_hfoxxmh_all = $qs_hfoxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hfoxxmh_self) > 0){
        $rs_opt = array_merge($rs_hfoxxmh_self, $rs_hfoxxmh_all);
    }else{
        $rs_opt = $rs_hfoxxmh_all;
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