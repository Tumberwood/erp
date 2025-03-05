<?php 
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : dbmxxth
     * Parameter        : 
     *  - id_dbmxxth_old       : data existing (untuk keperluan edit), dipakai di query self
     */    
    require_once( "../../../../users/init.php" );
    require_once( "../../../../usersc/lib/DataTables.php" );
    require_once( "../../../../usersc/helpers/datatables_fn_debug.php" );

    // BEGIN definisi variable untuk fn_ajax_results.php
    $data      = array();
    $rs_opt    = array();
    $c_rs_opt  = 0;
    $morePages = false;
    // END definisi variable untuk fn_ajax_results.php

    // BEGIN select2 pagination preparation
    $page        = $_GET['page'];
    $resultCount = 10;
    $offset      = ($page - 1) * $resultCount;
    // END select2 pagination preparation

    if($_GET['id_dbmxxth_old'] > 0){
        $id_dbmxxth_old = $_GET['id_dbmxxth_old'];
    }else{
        $id_dbmxxth_old = 0;
    }

    if(isset($_GET['id_iimxxmh'])){
        $id_iimxxmh = '('.$_GET['id_iimxxmh'].')';
        $iim_where = 'IN';
    }else{
        $id_iimxxmh = '(0)';
        $iim_where = 'NOT IN';
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_dbmxxth_old > 0){
        $qs_dbmxxth_self = $db
            ->query('select', 'dbmxxth')
            ->get([
                'dbmxxth.id as id',
                'CONCAT(dbmxxth.kode, " - ", iimxxmh.nama) as text'
            ])
            ->join('iimxxmh','iimxxmh.id = dbmxxth.id_iimxxmh','LEFT' )
            ->where('dbmxxth.id', $id_dbmxxth_old )
            ->exec();
        $rs_dbmxxth_self = $qs_dbmxxth_self->fetchAll();
    }else{
        $rs_dbmxxth_self = [];
    }
    // END query self

    // BEGIN query options all except self
    $qs_dbmxxth_all = $db
        ->query('select', 'dbmxxth')
        ->get([
            'dbmxxth.id as id',
            'CONCAT(dbmxxth.kode, " - ", iimxxmh.nama) as text'
        ])
        ->join('iimxxmh','iimxxmh.id = dbmxxth.id_iimxxmh','LEFT' )
        ->where('iimxxmh.transaction_state',1)
        ->where('dbmxxth.transaction_state',1)
        ->where('dbmxxth.id_iimxxmh',$id_iimxxmh, $iim_where, false)
        ->where('dbmxxth.id', $id_dbmxxth_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('iimxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_dbmxxth_all = $qs_dbmxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_dbmxxth_self) > 0){
        $rs_opt = array_merge($rs_dbmxxth_self, $rs_dbmxxth_all);
    }else{
        $rs_opt = $rs_dbmxxth_all;
    }
    $c_rs_opt = count($rs_opt);
    // END menggabungkan options

    // BEGIN untuk keperluan paginasi select2
    $endCount  = $offset + $resultCount;
    $morePages = $endCount > $c_rs_opt;
    // END untuk keperluan paginasi select2
    
    // tampilkan results
    require_once( "../../../../usersc/helpers/fn_ajax_results.php" );

?>