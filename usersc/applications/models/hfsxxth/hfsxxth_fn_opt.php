<?php 
    /**
     * Digunakan untuk populate options data hfsxxth
     * Table terkait    : hfsxxth
     * Parameter        : 
     *  - id_hfsxxth_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_hfsxxth_old'] > 0){
        $id_hfsxxth_old = $_GET['id_hfsxxth_old'];
    }else{
        $id_hfsxxth_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hfsxxth_old > 0){
        $qs_hfsxxth_self = $db
            ->query('select', 'hfsxxth')
            ->get([
                'hfsxxth.id as id',
                'CONCAT(DATE_FORMAT(hfsxxth.periode, "%d %b %Y"), " - ", hemxxmh.nama) as text'
            ])
            ->join('hemxxmh','hemxxmh.id = hfsxxth.id_hemxxmh','LEFT' )
            ->where('hfsxxth.id', $id_hfsxxth_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hfsxxth_self = $qs_hfsxxth_self->fetchAll();
    }else{
        $rs_hfsxxth_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_hfsxxth_all = $db
        ->query('select', 'hfsxxth')
        ->get([
            'hfsxxth.id as id',
            'CONCAT(DATE_FORMAT(hfsxxth.periode, "%d %b %Y"), " - ", hemxxmh.nama) as text'
        ])
        ->join('hemxxmh','hemxxmh.id = hfsxxth.id_hemxxmh','LEFT' )
        ->where('hfsxxth.transaction_state',1)
        ->where('hfsxxth.id', $id_hfsxxth_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('DATE_FORMAT(hfsxxth.periode, "%d %b %Y")', '%' . $q . '%', 'LIKE' )
                ->or_where('hemxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_hfsxxth_all = $qs_hfsxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hfsxxth_self) > 0){
        $rs_opt = array_merge($rs_hfsxxth_self, $rs_hfsxxth_all);
    }else{
        $rs_opt = $rs_hfsxxth_all;
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