<?php 
    /**
     * Digunakan untuk populate options data badan usaha
     * Table terkait    : prqittd
     * Parameter        : 
     *  - id_prqittd_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_prqittd_old'] > 0){
        $id_prqittd_old = $_GET['id_prqittd_old'];
    }else{
        $id_prqittd_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_prqittd_old > 0){
        $qs_prqittd_self = $db
            ->query('select', 'prqittd')
            ->get([
                'prqittd.id as id',
                'IF(
                    prqxxth.kode IS NULL, 
                    prqittd.nama,
                    IF(
                        prqittd.nama IS NULL, 
                        prqxxth.kode,
                        CONCAT(prqxxth.kode," - ",prqittd.nama)
                    )
                ) as text'
            ])
            ->join('prqxxth','prqxxth.id = prqittd.id_prqxxth','LEFT' )
            ->where('prqittd.id', $id_prqittd_old )            
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_prqittd_self = $qs_prqittd_self->fetchAll();
    }else{
        $rs_prqittd_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_prqittd_all = $db
        ->query('select', 'prqittd')
        ->get([
            'prqittd.id as id',
            'IF(
                prqittd.nama = "", 
                CONCAT(prqxxth.kode," - ",iimxxmh.kode," - ",iimxxmh.nama),
                CONCAT(prqxxth.kode," - ",prqittd.nama)
            ) as text'
        ])
        ->join('prqxxth','prqxxth.id = prqittd.id_prqxxth','LEFT' )
        ->join('iimxxmh','iimxxmh.id = prqittd.id_iimxxmh','LEFT' )
        ->where('prqxxth.transaction_state',1)
        ->where('prqxxth.approval_state',9)
        ->where('prqittd.id', $id_prqittd_old, '<>' )
        ->where( function ( $r ) {
            $r
                ->where('prqittd.is_nextprocess', null)
                ->or_where( 'prqittd.is_nextprocess', 0);
        } )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('prqxxth.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('prqittd.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_prqittd_all = $qs_prqittd_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_prqittd_self) > 0){
        $rs_opt = array_merge($rs_prqittd_self, $rs_prqittd_all);
    }else{
        $rs_opt = $rs_prqittd_all;
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