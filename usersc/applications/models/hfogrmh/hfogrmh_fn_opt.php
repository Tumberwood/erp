<?php 
    /**
     * Digunakan untuk populate options data hfogrmh
     * Table terkait    : hfogrmh
     * Parameter        : 
     *  - id_hfogrmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_hfogrmh_old'] > 0){
        $id_hfogrmh_old = $_GET['id_hfogrmh_old'];
    }else{
        $id_hfogrmh_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hfogrmh_old > 0){
        $qs_hfogrmh_self = $db
            ->query('select', 'hfogrmh')
            ->get([
                'hfogrmh.id as id',
                'IF(
                    hfogrmh.kode IS NULL, 
                    hfogrmh.nama,
                    IF(
                        hfogrmh.nama IS NULL, 
                        hfogrmh.kode,
                        CONCAT(hfogrmh.kode," - ",hfogrmh.nama)
                    )
                ) as text'
            ])
            ->where('hfogrmh..id', $id_hfogrmh_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hfogrmh_self = $qs_hfogrmh_self->fetchAll();
    }else{
        $rs_hfogrmh_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_hfogrmh_all = $db
        ->query('select', 'hfogrmh')
        ->get([
            'hfogrmh.id as id',
            'IF(
                hfogrmh.kode IS NULL, 
                hfogrmh.nama,
                IF(
                    hfogrmh.nama IS NULL, 
                    hfogrmh.kode,
                    CONCAT(hfogrmh.kode," - ",hfogrmh.nama)
                )
            ) as text'
        ])
        ->where('hfogrmh.transaction_state',1)
        ->where('hfogrmh.id', $id_hfogrmh_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('hfogrmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('hfogrmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_hfogrmh_all = $qs_hfogrmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hfogrmh_self) > 0){
        $rs_opt = array_merge($rs_hfogrmh_self, $rs_hfogrmh_all);
    }else{
        $rs_opt = $rs_hfogrmh_all;
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