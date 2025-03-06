<?php 
    /**
     * Digunakan untuk populate options data lvhxxmh
     * Table terkait    : lvhxxmh
     * Parameter        : 
     *  - id_lvhxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_lvhxxmh_old'] > 0){
        $id_lvhxxmh_old = $_GET['id_lvhxxmh_old'];
    }else{
        $id_lvhxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_lvhxxmh_old > 0){
        $qs_lvhxxmh_self = $db
            ->query('select', 'lvhxxmh')
            ->get([
                'lvhxxmh.id as id',
                'IF(
                    lvhxxmh.kode IS NULL, 
                    lvtxxmh.nama,
                    IF(
                        lvtxxmh.nama IS NULL, 
                        lvhxxmh.kode,
                        CONCAT(lvhxxmh.kode," - ",lvtxxmh.nama)
                    )
                ) as text'
            ])
            ->join('lvtxxmh','lvtxxmh.fieldjoin = .id_lvtxxmh','LEFT' )
            ->where('lvhxxmh..id', $id_lvhxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_lvhxxmh_self = $qs_lvhxxmh_self->fetchAll();
    }else{
        $rs_lvhxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_lvhxxmh_all = $db
        ->query('select', 'lvhxxmh')
        ->get([
            'lvhxxmh.id as id',
            'IF(
                lvhxxmh.kode IS NULL, 
                lvtxxmh.nama,
                IF(
                    lvtxxmh.nama IS NULL, 
                    lvhxxmh.kode,
                    CONCAT(lvhxxmh.kode," - ",lvtxxmh.nama)
                )
            ) as text'
        ])
        ->join('lvtxxmh','lvtxxmh.fieldjoin = .id_lvtxxmh','LEFT' )
        ->where('lvhxxmh.transaction_state',1)
        ->where('lvhxxmh.id', $id_lvhxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('lvhxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('lvtxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_lvhxxmh_all = $qs_lvhxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_lvhxxmh_self) > 0){
        $rs_opt = array_merge($rs_lvhxxmh_self, $rs_lvhxxmh_all);
    }else{
        $rs_opt = $rs_lvhxxmh_all;
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