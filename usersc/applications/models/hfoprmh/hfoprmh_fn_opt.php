<?php 
    /**
     * Digunakan untuk populate options data hfoprmh
     * Table terkait    : hfoprmh
     * Parameter        : 
     *  - id_hfoprmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_hfoprmh_old'] > 0){
        $id_hfoprmh_old = $_GET['id_hfoprmh_old'];
    }else{
        $id_hfoprmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hfoprmh_old > 0){
        $qs_hfoprmh_self = $db
            ->query('select', 'hfoprmh')
            ->get([
                'hfoprmh.id as id',
                'IF(
                    hfoprmh.kode IS NULL, 
                    hfoprmh.nama,
                    IF(
                        hfoprmh.nama IS NULL, 
                        hfoprmh.kode,
                        CONCAT(hfoprmh.kode," - ",hfoprmh.nama)
                    )
                ) as text'
            ])
            ->where('hfoprmh..id', $id_hfoprmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hfoprmh_self = $qs_hfoprmh_self->fetchAll();
    }else{
        $rs_hfoprmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_hfoprmh_all = $db
        ->query('select', 'hfoprmh')
        ->get([
            'hfoprmh.id as id',
            'IF(
                hfoprmh.kode IS NULL, 
                hfoprmh.nama,
                IF(
                    hfoprmh.nama IS NULL, 
                    hfoprmh.kode,
                    CONCAT(hfoprmh.kode," - ",hfoprmh.nama)
                )
            ) as text'
        ])
        ->where('hfoprmh.transaction_state',1)
        ->where('hfoprmh.id', $id_hfoprmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('hfoprmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('hfoprmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_hfoprmh_all = $qs_hfoprmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hfoprmh_self) > 0){
        $rs_opt = array_merge($rs_hfoprmh_self, $rs_hfoprmh_all);
    }else{
        $rs_opt = $rs_hfoprmh_all;
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