<?php 
    /**
     * Digunakan untuk populate options data hfkobtd
     * Table terkait    : hfkobtd
     * Parameter        : 
     *  - id_hfkobtd_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_hfkobtd_old'] > 0){
        $id_hfkobtd_old = $_GET['id_hfkobtd_old'];
    }else{
        $id_hfkobtd_old = 0;
    }

    if($_GET['id_hfkxxth'] > 0){
        $id_hfkxxth = $_GET['id_hfkxxth'];
    }else{
        $id_hfkxxth = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hfkobtd_old > 0){
        $qs_hfkobtd_self = $db
            ->query('select', 'hfkobtd')
            ->get([
                'hfkobtd.id as id',
                'CONCAT(hfoxxmh.nama) as text'
            ])
            ->join('hfoxxmh','hfoxxmh.id = hfkobtd.id_hfoxxmh','LEFT' )
            ->where('hfkobtd.id', $id_hfkobtd_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hfkobtd_self = $qs_hfkobtd_self->fetchAll();
    }else{
        $rs_hfkobtd_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_hfkobtd_all = $db
        ->query('select', 'hfkobtd')
        ->get([
            'hfkobtd.id as id',
            'CONCAT(hfoxxmh.nama) as text'
        ])
        ->join('hfoxxmh','hfoxxmh.id = hfkobtd.id_hfoxxmh','LEFT' )
        ->where('hfkobtd.transaction_state',1)
        ->where('hfkobtd.id', $id_hfkobtd_old, '<>' )
        ->where('hfkobtd.id_hfkxxth', $id_hfkxxth)
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->or_where('hfoxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_hfkobtd_all = $qs_hfkobtd_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hfkobtd_self) > 0){
        $rs_opt = array_merge($rs_hfkobtd_self, $rs_hfkobtd_all);
    }else{
        $rs_opt = $rs_hfkobtd_all;
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