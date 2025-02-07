<?php 
    /**
     * Digunakan untuk populate options data pivxxth
     * Table terkait    : pivxxth
     * Parameter        : 
     *  - id_pivxxth_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_pivxxth_old'] > 0){
        $id_pivxxth_old = $_GET['id_pivxxth_old'];
    }else{
        $id_pivxxth_old = 0;
    }

    if($_GET['id_grlxxmh_supplier'] > 0){
        $id_grlxxmh_supplier = $_GET['id_grlxxmh_supplier'];
    }else{
        $id_grlxxmh_supplier = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_pivxxth_old > 0){
        $qs_pivxxth_self = $db
            ->query('select', 'pivxxth')
            ->get([
                'pivxxth.id as id',
                'IF(
                    pivxxth.kode IS NULL, 
                    pivxxth.nama,
                    IF(
                        pivxxth.nama IS NULL, 
                        pivxxth.kode,
                        CONCAT(pivxxth.kode," - ",pivxxth.nama)
                    )
                ) as text'
            ])
            ->where('pivxxth..id', $id_pivxxth_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_pivxxth_self = $qs_pivxxth_self->fetchAll();
    }else{
        $rs_pivxxth_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_pivxxth_all = $db
        ->query('select', 'pivxxth')
        ->get([
            'pivxxth.id as id',
            'IF(
                pivxxth.kode IS NULL, 
                pivxxth.nama,
                IF(
                    pivxxth.nama IS NULL, 
                    pivxxth.kode,
                    CONCAT(pivxxth.kode," - ",pivxxth.nama)
                )
            ) as text'
        ])
        ->where('pivxxth.transaction_state',1)
        ->where('pivxxth.id', $id_pivxxth_old, '<>' )
        ->where('pivxxth.id_grlxxmh_supplier', $id_grlxxmh_supplier)
        ->where('pivxxth.selisih_bayar', 0, '>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('pivxxth.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('pivxxth.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_pivxxth_all = $qs_pivxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_pivxxth_self) > 0){
        $rs_opt = array_merge($rs_pivxxth_self, $rs_pivxxth_all);
    }else{
        $rs_opt = $rs_pivxxth_all;
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