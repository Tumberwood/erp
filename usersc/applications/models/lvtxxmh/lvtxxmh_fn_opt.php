<?php 
    /**
     * Digunakan untuk populate options data Vehicle Type
     * Table terkait    : lvtxxmh
     * Parameter        : 
     *  - id_lvtxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_lvtxxmh_old'] > 0){
        $id_lvtxxmh_old = $_GET['id_lvtxxmh_old'];
    }else{
        $id_lvtxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_lvtxxmh_old > 0){
        $qs_lvtxxmh_self = $db
            ->query('select', 'lvtxxmh')
            ->get([
                'lvtxxmh.id as id',
                'IF(
                    lvtxxmh.kode IS NULL, 
                    lvtxxmh.nama,
                    IF(
                        lvtxxmh.nama IS NULL, 
                        lvtxxmh.kode,
                        CONCAT(lvtxxmh.kode," - ",lvtxxmh.nama)
                    )
                ) as text'
            ])
            ->where('lvtxxmh.id', $id_lvtxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_lvtxxmh_self = $qs_lvtxxmh_self->fetchAll();
    }else{
        $rs_lvtxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_lvtxxmh_all = $db
        ->query('select', 'lvtxxmh')
        ->get([
            'lvtxxmh.id as id',
            'IF(
                lvtxxmh.kode IS NULL, 
                lvtxxmh.nama,
                IF(
                    lvtxxmh.nama IS NULL, 
                    lvtxxmh.kode,
                    CONCAT(lvtxxmh.kode," - ",lvtxxmh.nama)
                )
            ) as text'
        ])
        ->where('lvtxxmh.transaction_state',1)
        ->where('lvtxxmh.id', $id_lvtxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('lvtxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('lvtxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_lvtxxmh_all = $qs_lvtxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_lvtxxmh_self) > 0){
        $rs_opt = array_merge($rs_lvtxxmh_self, $rs_lvtxxmh_all);
    }else{
        $rs_opt = $rs_lvtxxmh_all;
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