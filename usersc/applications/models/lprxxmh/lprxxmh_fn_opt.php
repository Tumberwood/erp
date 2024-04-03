<?php 
    /**
     * Digunakan untuk populate options data Master Logistic Process
     * Table terkait    : lprxxmh
     * Parameter        : 
     *  - id_lprxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_lprxxmh_old'] > 0){
        $id_lprxxmh_old = $_GET['id_lprxxmh_old'];
    }else{
        $id_lprxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_lprxxmh_old > 0){
        $qs_lprxxmh_self = $db
            ->query('select', 'lprxxmh')
            ->get([
                'lprxxmh.id as id',
                'IF(
                    lprxxmh.kode IS NULL, 
                    lprxxmh.nama,
                    IF(
                        lprxxmh.nama IS NULL, 
                        lprxxmh.kode,
                        CONCAT(lprxxmh.kode," - ",lprxxmh.nama)
                    )
                ) as text'
            ])
            ->where('lprxxmh..id', $id_lprxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_lprxxmh_self = $qs_lprxxmh_self->fetchAll();
    }else{
        $rs_lprxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_lprxxmh_all = $db
        ->query('select', 'lprxxmh')
        ->get([
            'lprxxmh.id as id',
            'IF(
                lprxxmh.kode IS NULL, 
                lprxxmh.nama,
                IF(
                    lprxxmh.nama IS NULL, 
                    lprxxmh.kode,
                    CONCAT(lprxxmh.kode," - ",lprxxmh.nama)
                )
            ) as text'
        ])
        ->where('lprxxmh.transaction_state',1)
        ->where('lprxxmh.id', $id_lprxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('lprxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('lprxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->order('lprxxmh.id')
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_lprxxmh_all = $qs_lprxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_lprxxmh_self) > 0){
        $rs_opt = array_merge($rs_lprxxmh_self, $rs_lprxxmh_all);
    }else{
        $rs_opt = $rs_lprxxmh_all;
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