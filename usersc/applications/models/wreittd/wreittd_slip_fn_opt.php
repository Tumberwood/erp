<?php 
    /**
     * Digunakan untuk populate options data wreittd
     * Table terkait    : wreittd
     * Parameter        : 
     *  - id_wreittd_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_wreittd_old'] > 0){
        $id_wreittd_old = $_GET['id_wreittd_old'];
    }else{
        $id_wreittd_old = 0;
    }
    
    if (isset($_GET['id_wroxxth_old'])) {
        $id_wroxxth_old = $_GET['id_wroxxth_old'];
    } else {
        $id_wroxxth_old = 0;
    }
    
    if (isset($_GET['tanggal'])) {
        $tanggal = $_GET['tanggal'];
    } else {
        $tanggal = '';
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_wreittd_old > 0){
        $qs_wreittd_self = $db
            ->query('select', 'wreittd')
            ->get([
                'wreittd.id as id',
                ' wreittd.kode as text'
            ])
            ->where('wreittd..id', $id_wreittd_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_wreittd_self = $qs_wreittd_self->fetchAll();
    }else{
        $rs_wreittd_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_wreittd_all = $db
        ->query('select', 'wreittd')
        ->get([
            'wreittd.id as id',
            ' wreittd.kode as text'
        ])
        ->where('wreittd.transaction_state',1)
        ->where('wreittd.is_done_slip', 0)
        ->where('wreittd.id_wroxxth',$id_wroxxth_old)
        ->where('DATE_FORMAT(wreittd.finish_at, "%d %b %Y")',$tanggal)
        ->where('wreittd.id', $id_wreittd_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('wreittd.kode', '%' . $q . '%', 'LIKE' )
                ;
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_wreittd_all = $qs_wreittd_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_wreittd_self) > 0){
        $rs_opt = array_merge($rs_wreittd_self, $rs_wreittd_all);
    }else{
        $rs_opt = $rs_wreittd_all;
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