<?php 
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : wdpxxth
     * Parameter        : 
     *  - id_wdpxxth_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_wdpxxth_old'] > 0){
        $id_wdpxxth_old = $_GET['id_wdpxxth_old'];
    }else{
        $id_wdpxxth_old = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_wdpxxth_old > 0){
        $qs_wdpxxth_self = $db
            ->query('select', 'wdpxxth')
            ->get([
                'wdpxxth.id as id',
                'IF(
                wdpxxth.kode IS NULL, 
                grlxxmh.nama,
                IF(
                    grlxxmh.nama IS NULL, 
                    wdpxxth.kode,
                    CONCAT(grlxxmh.nama," - ",wdpxxth.kode)
                    
                )
            ) as text'
            ])
            ->join('grlxxmh','grlxxmh.id = wdpxxth.id_grlxxmh_customer','LEFT' )
            ->where('wdpxxth.id', $id_wdpxxth_old )
            ->exec();
        $rs_wdpxxth_self = $qs_wdpxxth_self->fetchAll();
    }else{
        $rs_wdpxxth_self = [];
    }
    // END query self

    // BEGIN query options all except self
    $qs_wdpxxth_all = $db
        ->query('select', 'wdpxxth')
        ->get([
            'wdpxxth.id as id',
            'IF(
                wdpxxth.kode IS NULL, 
                grlxxmh.nama,
                IF(
                    grlxxmh.nama IS NULL, 
                    wdpxxth.kode,
                    CONCAT(grlxxmh.nama," - ",wdpxxth.kode)
                )
            ) as text'
        ])
        ->join('grlxxmh','grlxxmh.id = wdpxxth.id_grlxxmh_customer','LEFT' )
        // ->where('wdpxxth.transaction_state',1)
        ->where('wdpxxth.id', $id_wdpxxth_old, '<>' )
        ->where('wdpxxth.is_in_use', 0 )
        ->where('wdpxxth.id_wdpxxth', 0 )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('wdpxxth.kode', '%' . $q . '%', 'LIKE' )
                ;
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_wdpxxth_all = $qs_wdpxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_wdpxxth_self) > 0){
        $rs_opt = array_merge($rs_wdpxxth_self, $rs_wdpxxth_all);
    }else{
        $rs_opt = $rs_wdpxxth_all;
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