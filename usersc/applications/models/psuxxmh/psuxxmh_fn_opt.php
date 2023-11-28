<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : psuxxmh
     * Parameter        : 
     *  - id_psuxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_psuxxmh_old'] > 0){
        $id_psuxxmh_old = $_GET['id_psuxxmh_old'];
    }else{
        $id_psuxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_psuxxmh_old > 0){
        $qs_psuxxmh_self = $db
            ->query('select', 'psuxxmh')
            ->get([
                'psuxxmh.id as id',
                'IF(
                    psuxxmh.kode IS NULL, 
                    psuxxmh.nama,
                    IF(
                        psuxxmh.nama IS NULL, 
                        psuxxmh.kode,
                        CONCAT(psuxxmh.kode," - ",psuxxmh.nama)
                    )
                ) as text'
            ])
            ->where('psuxxmh.id', $id_psuxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_psuxxmh_self = $qs_psuxxmh_self->fetchAll();
    }else{
        $rs_psuxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_psuxxmh_all = $db
        ->query('select', 'psuxxmh')
        ->get([
            'psuxxmh.id as id',
            'IF(
                psuxxmh.kode IS NULL, 
                psuxxmh.nama,
                IF(
                    psuxxmh.nama IS NULL, 
                    psuxxmh.kode,
                    CONCAT(psuxxmh.kode," - ",psuxxmh.nama)
                )
            ) as text'
        ])
        ->where('psuxxmh.transaction_state',1)
        ->where('psuxxmh.id', $id_psuxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('psuxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('psuxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_psuxxmh_all = $qs_psuxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_psuxxmh_self) > 0){
        $rs_opt = array_merge($rs_psuxxmh_self, $rs_psuxxmh_all);
    }else{
        $rs_opt = $rs_psuxxmh_all;
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