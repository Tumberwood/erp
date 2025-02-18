<?php 
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : iimxxmh
     * Parameter        : 
     *  - id_iimxxmh_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_iimxxmh_old'] > 0){
        $id_iimxxmh_old = $_GET['id_iimxxmh_old'];
    }else{
        $id_iimxxmh_old = 0;
    }
    
    if($_GET['id_podxxth'] > 0){
        $id_podxxth = $_GET['id_podxxth'];
    }else{
        $id_podxxth = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_iimxxmh_old > 0){
        $qs_iimxxmh_self = $db
            ->query('select', 'iimxxmh')
            ->get([
                'id as id',
                'CONCAT(kode," - ",nama) as text'
            ])
            ->where('id', $id_iimxxmh_old )
            ->exec();
        $rs_iimxxmh_self = $qs_iimxxmh_self->fetchAll();
    }else{
        $rs_iimxxmh_self = [];
    }
    // END query self

    // BEGIN query options all except self
    $qs_iimxxmh_all = $db
        ->query('select', 'dbmxxth')
        ->get([
            'iimxxmh.id as id',
            'CONCAT(iimxxmh.kode," - ",iimxxmh.nama) as text',
            'podittd.id as id_podittd',
            'podittd.id_podxxth as id_podxxth',
            'podittd.harga_unit as harga_unit',
            
            'dbmittd.jumlah_unit as jumlah_material',
            'dbmittd.id_iumxxmh_unit as id_iumxxmh_unit',
            '(dbmittd.jumlah_unit * podittd.jumlah_unit) as jumlah_unit'
        ])
        ->join('dbmittd','dbmittd.id_dbmxxth = dbmxxth.id','LEFT' )
        ->join('iimxxmh','iimxxmh.id = dbmittd.id_iimxxmh','LEFT' )
        ->join('podittd','podittd.id_iimxxmh = dbmxxth.id_iimxxmh','LEFT' )
        ->where('dbmxxth.transaction_state',1)
        ->where('iimxxmh.transaction_state',1)
        ->where('iimxxmh.id', $id_iimxxmh_old, '<>' )
        ->where('podittd.id_podxxth', $id_podxxth)
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('iimxxmh.kode', '%' . $q . '%', 'LIKE' )
                ->or_where('iimxxmh.nama', '%' . $q . '%', 'LIKE' );
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_iimxxmh_all = $qs_iimxxmh_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_iimxxmh_self) > 0){
        $rs_opt = array_merge($rs_iimxxmh_self, $rs_iimxxmh_all);
    }else{
        $rs_opt = $rs_iimxxmh_all;
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