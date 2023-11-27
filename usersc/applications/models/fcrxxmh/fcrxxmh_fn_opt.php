<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : fcrxxmh
     * Parameter        : 
     *  - id_fcrxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_fcrxxmh_old'] > 0){
        $id_fcrxxmh_old = $_GET['id_fcrxxmh_old'];
    }else{
        $id_fcrxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_fcrxxmh_old > 0){
        $qs_fcrxxmh_self = $db
            ->query('select', 'fcrxxmh')
            ->get([
                'fcrxxmh.id as id',
                'IF(
                    fcrxxmh.kode IS NULL, 
                    fcrxxmh.nama,
                    IF(
                        fcrxxmh.nama IS NULL, 
                        fcrxxmh.kode,
                        CONCAT(fcrxxmh.kode," - ",fcrxxmh.nama)
                    )
                ) as text'
            ])
            ->where('fcrxxmh.id', $id_fcrxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_fcrxxmh_self = $qs_fcrxxmh_self->fetchAll();
    }else{
        $rs_fcrxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_fcrxxmh_all = $db
        ->query('select', 'fcrxxmh')
        ->get([
            'fcrxxmh.id as id',
            'IF(
                fcrxxmh.kode IS NULL, 
                fcrxxmh.nama,
                IF(
                    fcrxxmh.nama IS NULL, 
                    fcrxxmh.kode,
                    CONCAT(fcrxxmh.kode," - ",fcrxxmh.nama)
                )
            ) as text'
        ])
        ->where('fcrxxmh.transaction_state',1)
        ->where('fcrxxmh.id', $id_fcrxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('fcrxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('fcrxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_fcrxxmh_all = $qs_fcrxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_fcrxxmh_self) > 0){
        $rs_opt = array_merge($rs_fcrxxmh_self, $rs_fcrxxmh_all);
    }else{
        $rs_opt = $rs_fcrxxmh_all;
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