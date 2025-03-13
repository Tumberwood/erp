<?php 
    /**
     * Digunakan untuk populate options data hrcemtd
     * Table terkait    : hrcemtd
     * Parameter        : 
     *  - id_hrcemtd_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_hrcemtd_old'] > 0){
        $id_hrcemtd_old = $_GET['id_hrcemtd_old'];
    }else{
        $id_hrcemtd_old = 0;
    }

    if(isset($_GET['id_hrccdth']) && $_GET['id_hrccdth'] > 0){
        $id_hrccdth = '('.$_GET['id_hrccdth'].')';
        $where_in = 'IN';
    }else{
        $id_hrccdth = '(-9)';
        $where_in = 'NOT IN';
    }

    // BEGIN query options self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_hrcemtd_old > 0){
        $qs_hrcemtd_self = $db
            ->query('select', 'hrcemtd')
            ->get([
                'hrcemtd.id as id',
                'hcdxxmh.nama as text'
            ])
            ->join('hcdxxmh','hcdxxmh.id = hrcemtd.id_hcdxxmh','LEFT' )
            ->where('hrcemtd.id', $id_hrcemtd_old )
            ->limit(1)
            ->offset($offset)
            ->exec();
        $rs_hrcemtd_self = $qs_hrcemtd_self->fetchAll();
    }else{
        $rs_hrcemtd_self = [];
    }
    // END query options self

    // BEGIN query options all except self
    $qs_hrcemtd_all = $db
        ->query('select', 'hrcemtd')
        ->get([
            'hrcemtd.id as id',
            'hcdxxmh.nama as text'
        ])
        ->join('hcdxxmh','hcdxxmh.id = hrcemtd.id_hcdxxmh','LEFT' )
        ->where('hrcemtd.transaction_state',1)
        ->where('hrcemtd.id', $id_hrcemtd_old, '<>' )
        ->where('hrcemtd.id_hrccdth', $id_hrccdth, $where_in,false)
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('hcdxxmh.nama', '%' . $q . '%', 'LIKE' )
                ;
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_hrcemtd_all = $qs_hrcemtd_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_hrcemtd_self) > 0){
        $rs_opt = array_merge($rs_hrcemtd_self, $rs_hrcemtd_all);
    }else{
        $rs_opt = $rs_hrcemtd_all;
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