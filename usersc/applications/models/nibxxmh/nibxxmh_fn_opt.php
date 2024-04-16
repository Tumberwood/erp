<?php 
    /**
     * Digunakan untuk populate options data nibxxmh
     * Table terkait    : nibxxmh
     * Parameter        : 
     *  - id_nibxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_nibxxmh_old'] > 0){
        $id_nibxxmh_old = $_GET['id_nibxxmh_old'];
    }else{
        $id_nibxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_nibxxmh_old > 0){
        $qs_nibxxmh_self = $db
            ->query('select', 'nibxxmh')
            ->get([
                'nibxxmh.id as id',
                'IF(
                    nibxxmh.kode IS NULL, 
                    nibxxmh.nama,
                    IF(
                        nibxxmh.nama IS NULL, 
                        nibxxmh.kode,
                        CONCAT(nibxxmh.kode," - ",nibxxmh.nama)
                    )
                ) as text'
            ])
            ->where('nibxxmh..id', $id_nibxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_nibxxmh_self = $qs_nibxxmh_self->fetchAll();
    }else{
        $rs_nibxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_nibxxmh_all = $db
        ->query('select', 'nibxxmh')
        ->get([
            'nibxxmh.id as id',
            'IF(
                nibxxmh.kode IS NULL, 
                nibxxmh.nama,
                IF(
                    nibxxmh.nama IS NULL, 
                    nibxxmh.kode,
                    CONCAT(nibxxmh.kode," - ",nibxxmh.nama)
                )
            ) as text'
        ])
        ->where('nibxxmh.transaction_state',1)
        ->where('nibxxmh.id', $id_nibxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('nibxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('nibxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_nibxxmh_all = $qs_nibxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_nibxxmh_self) > 0){
        $rs_opt = array_merge($rs_nibxxmh_self, $rs_nibxxmh_all);
    }else{
        $rs_opt = $rs_nibxxmh_all;
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