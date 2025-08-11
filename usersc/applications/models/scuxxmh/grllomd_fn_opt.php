<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : grllomd
     * Parameter        : 
     *  - id_grllomd_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_grllomd_old'] > 0){
        $id_grllomd_old = $_GET['id_grllomd_old'];
    }else{
        $id_grllomd_old = 0;
    }

    if(isset($_GET['id_grlxxmh_old']) && $_GET['id_grlxxmh_old'] != ''){
        $id_grlxxmh_old = $_GET['id_grlxxmh_old'];
    }else{
        $id_grlxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_grllomd_old > 0){
        $qs_grllomd_self = $db
            ->query('select', 'grllomd')
            ->get([
                'grllomd.id as id',
                'CONCAT(grllomd.alamat) as text'
            ])
            ->where('grllomd.id', $id_grllomd_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_grllomd_self = $qs_grllomd_self->fetchAll();
    }else{
        $rs_grllomd_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_grllomd_all = $db
        ->query('select', 'grllomd')
        ->get([
            'grllomd.id as id',
            'CONCAT(grllomd.alamat) as text'
        ])
        ->join('grlxxmh','grlxxmh.id = grllomd.id_grlxxmh','LEFT' )
        ->where('grllomd.id', $id_grllomd_old, '<>' )
        ->where('grllomd.id_grlxxmh', $id_grlxxmh_old)
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('grllomd.alamat', '%' . $q . '%', 'LIKE' )
                ->or_where('grllomd.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_grllomd_all = $qs_grllomd_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_grllomd_self) > 0){
        $rs_opt = array_merge($rs_grllomd_self, $rs_grllomd_all);
    }else{
        $rs_opt = $rs_grllomd_all;
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