<?php 
    /**
     * Digunakan untuk populate options data htsxxmh
     * Table terkait    : htsxxmh
     * Parameter        : 
     *  - id_htsxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_htsxxmh_old'] > 0){
        $id_htsxxmh_old = $_GET['id_htsxxmh_old'];
    }else{
        $id_htsxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_htsxxmh_old > 0){
        $qs_htsxxmh_self = $db
            ->query('select', 'htsxxmh')
            ->get([
                'htsxxmh.id as id',
                'IF(
                    htsxxmh.kode IS NULL, 
                    htsxxmh.nama,
                    IF(
                        htsxxmh.nama IS NULL, 
                        htsxxmh.kode,
                        CONCAT(htsxxmh.kode," - ",htsxxmh.nama)
                    )
                ) as text'
            ])
            ->where('htsxxmh..id', $id_htsxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_htsxxmh_self = $qs_htsxxmh_self->fetchAll();
    }else{
        $rs_htsxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_htsxxmh_all = $db
        ->query('select', 'htsxxmh')
        ->get([
            'htsxxmh.id as id',
            'IF(
                htsxxmh.kode IS NULL, 
                htsxxmh.nama,
                IF(
                    htsxxmh.nama IS NULL, 
                    htsxxmh.kode,
                    CONCAT(htsxxmh.kode," - ",htsxxmh.nama)
                )
            ) as text'
        ])
        ->where('htsxxmh.transaction_state',1)
        ->where('htsxxmh.id', $id_htsxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('htsxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('htsxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_htsxxmh_all = $qs_htsxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_htsxxmh_self) > 0){
        $rs_opt = array_merge($rs_htsxxmh_self, $rs_htsxxmh_all);
    }else{
        $rs_opt = $rs_htsxxmh_all;
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