<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : hgnedmh
     * Parameter        : 
     *  - id_hgnedmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_hgnedmh_old'] > 0){
        $id_hgnedmh_old = $_GET['id_hgnedmh_old'];
    }else{
        $id_hgnedmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hgnedmh_old > 0){
        $qs_hgnedmh_self = $db
            ->query('select', 'hgnedmh')
            ->get([
                'hgnedmh.id as id',
                'IF(
                    hgnedmh.kode IS NULL, 
                    hgnedmh.nama,
                    IF(
                        hgnedmh.nama IS NULL, 
                        hgnedmh.kode,
                        CONCAT(hgnedmh.kode," - ",hgnedmh.nama)
                    )
                ) as text'
            ])
            ->where('hgnedmh.id', $id_hgnedmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hgnedmh_self = $qs_hgnedmh_self->fetchAll();
    }else{
        $rs_hgnedmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_hgnedmh_all = $db
        ->query('select', 'hgnedmh')
        ->get([
            'hgnedmh.id as id',
            'IF(
                hgnedmh.kode IS NULL, 
                hgnedmh.nama,
                IF(
                    hgnedmh.nama IS NULL, 
                    hgnedmh.kode,
                    CONCAT(hgnedmh.kode," - ",hgnedmh.nama)
                )
            ) as text'
        ])
        ->where('hgnedmh.transaction_state',1)
        ->where('hgnedmh.id', $id_hgnedmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('hgnedmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('hgnedmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_hgnedmh_all = $qs_hgnedmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hgnedmh_self) > 0){
        $rs_opt = array_merge($rs_hgnedmh_self, $rs_hgnedmh_all);
    }else{
        $rs_opt = $rs_hgnedmh_all;
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