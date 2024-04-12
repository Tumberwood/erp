<?php 
    /**
     * Digunakan untuk populate options data httlpmh
     * Table terkait    : httlpmh
     * Parameter        : 
     *  - id_httlpmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_httlpmh_old'] > 0){
        $id_httlpmh_old = $_GET['id_httlpmh_old'];
    }else{
        $id_httlpmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_httlpmh_old > 0){
        $qs_httlpmh_self = $db
            ->query('select', 'httlpmh')
            ->get([
                'httlpmh.id as id',
                'IF(
                    httlpmh.kode IS NULL, 
                    httlpmh.nama,
                    IF(
                        httlpmh.nama IS NULL, 
                        httlpmh.kode,
                        CONCAT(httlpmh.kode," - ",httlpmh.nama)
                    )
                ) as text'
            ])
            ->where('httlpmh..id', $id_httlpmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_httlpmh_self = $qs_httlpmh_self->fetchAll();
    }else{
        $rs_httlpmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_httlpmh_all = $db
        ->query('select', 'httlpmh')
        ->get([
            'httlpmh.id as id',
            'IF(
                httlpmh.kode IS NULL, 
                httlpmh.nama,
                IF(
                    httlpmh.nama IS NULL, 
                    httlpmh.kode,
                    CONCAT(httlpmh.kode," - ",httlpmh.nama)
                )
            ) as text'
        ])
        ->where('httlpmh.transaction_state',1)
        ->where('httlpmh.id', $id_httlpmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('httlpmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('httlpmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_httlpmh_all = $qs_httlpmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_httlpmh_self) > 0){
        $rs_opt = array_merge($rs_httlpmh_self, $rs_httlpmh_all);
    }else{
        $rs_opt = $rs_httlpmh_all;
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