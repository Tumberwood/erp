<?php 
    /**
     * Digunakan untuk populate options data hfkxxth
     * Table terkait    : hfkxxth
     * Parameter        : 
     *  - id_hfkxxth_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_hfkxxth_old'] > 0){
        $id_hfkxxth_old = $_GET['id_hfkxxth_old'];
    }else{
        $id_hfkxxth_old = 0;
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hfkxxth_old > 0){
        $qs_hfkxxth_self = $db
            ->query('select', 'hfkxxth')
            ->get([
                'hfkxxth.id as id',
                'CONCAT(hemxxmh.nama," (",DATE_FORMAT(hfkxxth.tanggal_awal, "%d %b %Y"), " - ", DATE_FORMAT(hfkxxth.tanggal_akhir, "%d %b %Y"), ")") as text'
            ])
            ->join('hemxxmh','hemxxmh.id = hfkxxth.id_hemxxmh','LEFT' )
            ->where('hfkxxth.id', $id_hfkxxth_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hfkxxth_self = $qs_hfkxxth_self->fetchAll();
    }else{
        $rs_hfkxxth_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_hfkxxth_all = $db
        ->query('select', 'hfkxxth')
        ->get([
            'hfkxxth.id as id',
            'CONCAT(hemxxmh.nama," (",DATE_FORMAT(hfkxxth.tanggal_awal, "%d %b %Y"), " - ", DATE_FORMAT(hfkxxth.tanggal_akhir, "%d %b %Y"), ")") as text'
        ])
        ->join('hemxxmh','hemxxmh.id = hfkxxth.id_hemxxmh','LEFT' )
        ->where('hfkxxth.transaction_state',1)
        ->where('hfkxxth.id', $id_hfkxxth_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('DATE_FORMAT(hfkxxth.tanggal_awal, "%d %b %Y")', '%' . $q . '%', 'LIKE' )
                ->where('DATE_FORMAT(hfkxxth.tanggal_akhir, "%d %b %Y")', '%' . $q . '%', 'LIKE' )
                ->or_where('hemxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_hfkxxth_all = $qs_hfkxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hfkxxth_self) > 0){
        $rs_opt = array_merge($rs_hfkxxth_self, $rs_hfkxxth_all);
    }else{
        $rs_opt = $rs_hfkxxth_all;
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