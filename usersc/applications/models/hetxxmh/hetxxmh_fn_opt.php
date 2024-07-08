<?php 
    /**
     * Digunakan untuk populate options data hetxxmh
     * Table terkait    : hetxxmh
     * Parameter        : 
     *  - id_hetxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_hetxxmh_old'] > 0){
        $id_hetxxmh_old = $_GET['id_hetxxmh_old'];
    }else{
        $id_hetxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hetxxmh_old > 0){
        $qs_hetxxmh_self = $db
            ->query('select', 'hetxxmh')
            ->get([
                'hetxxmh.id as id',
                'IF(
                    hetxxmh.kode IS NULL, 
                    hetxxmh.nama,
                    IF(
                        hetxxmh.nama IS NULL, 
                        hetxxmh.kode,
                        CONCAT(hetxxmh.kode," - ",hetxxmh.nama)
                    )
                ) as text'
            ])
            ->where('hetxxmh..id', $id_hetxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hetxxmh_self = $qs_hetxxmh_self->fetchAll();
    }else{
        $rs_hetxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_hetxxmh_all = $db
        ->query('select', 'hetxxmh')
        ->get([
            'hetxxmh.id as id',
            'IF(
                hetxxmh.kode IS NULL, 
                hetxxmh.nama,
                IF(
                    hetxxmh.nama IS NULL, 
                    hetxxmh.kode,
                    CONCAT(hetxxmh.kode," - ",hetxxmh.nama)
                )
            ) as text'
        ])
        ->where('hetxxmh.transaction_state',1)
        ->where('hetxxmh.id', $id_hetxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('hetxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('hetxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->order('hetxxmh.nama')
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_hetxxmh_all = $qs_hetxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hetxxmh_self) > 0){
        $rs_opt = array_merge($rs_hetxxmh_self, $rs_hetxxmh_all);
    }else{
        $rs_opt = $rs_hetxxmh_all;
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