<?php 
    /**
     * Digunakan untuk populate options data branch / cabang
     * Table terkait    : aakxxmh
     * Parameter        : 
     *  - id_aakxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_aakxxmh_old'] > 0){
        $id_aakxxmh_old = $_GET['id_aakxxmh_old'];
    }else{
        $id_aakxxmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_aakxxmh_old > 0){
        $qs_aakxxmh_self = $db
            ->query('select', 'aakxxmh')
            ->get([
                'aakxxmh.id as id',
                'IF(
                    aakxxmh.kode IS NULL, 
                    aakxxmh.nama,
                    IF(
                        aakxxmh.nama IS NULL, 
                        aakxxmh.kode,
                        CONCAT(aakxxmh.kode," - ",aakxxmh.nama)
                    )
                ) as text'
            ])
            ->where('aakxxmh.id', $id_aakxxmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_aakxxmh_self = $qs_aakxxmh_self->fetchAll();
    }else{
        $rs_aakxxmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_aakxxmh_all = $db
        ->query('select', 'aakxxmh')
        ->get([
            'aakxxmh.id as id',
            'IF(
                aakxxmh.kode IS NULL, 
                aakxxmh.nama,
                IF(
                    aakxxmh.nama IS NULL, 
                    aakxxmh.kode,
                    CONCAT(aakxxmh.kode," - ",aakxxmh.nama)
                )
            ) as text'
        ])
        ->where('aakxxmh.transaction_state',1)
        ->where('aakxxmh.id_aatxxmh',1)
        ->where('aakxxmh.is_parent',0)
        ->where('aakxxmh.id', $id_aakxxmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('aakxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('aakxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_aakxxmh_all = $qs_aakxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_aakxxmh_self) > 0){
        $rs_opt = array_merge($rs_aakxxmh_self, $rs_aakxxmh_all);
    }else{
        $rs_opt = $rs_aakxxmh_all;
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