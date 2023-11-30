<?php 
    /**
     * Digunakan untuk populate options data item category
     * Table terkait    : itoxxth
     * Parameter        : 
     *  - id_itoxxth_old       : data existing (untuk keperluan edit), dipakai di query self
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

    if($_GET['id_itoxxth_old'] > 0){
        $id_itoxxth_old = $_GET['id_itoxxth_old'];
    }else{
        $id_itoxxth_old = 0;
    }

    // BEGIN query self.
    // Hanya dipanggil jika field ada nilai id nya
    if($id_itoxxth_old > 0){
        $qs_itoxxth_self = $db
            ->query('select', 'itoxxth')
            ->get([
                'id as id',
                'CONCAT(kode) as text'
            ])
            ->where('id', $id_itoxxth_old )
            ->exec();
        $rs_itoxxth_self = $qs_itoxxth_self->fetchAll();
    }else{
        $rs_itoxxth_self = [];
    }
    // END query self

    // BEGIN query options all except self
    $qs_itoxxth_all = $db
        ->query('select', 'itoxxth')
        ->get([
            'itoxxth.id as id',
            'CONCAT(itoxxth.kode) as text'
        ])
        ->join('itixxth','itixxth.id_itoxxth = itoxxth.id','LEFT' )
        ->where('itixxth.id',null)
        ->where('itoxxth.transaction_state',1)
        ->where('itoxxth.id', $id_itoxxth_old, '<>' )
        ->where( function ( $r ) {
            $q = $_GET['search'];
            $r
                ->where('itoxxth.kode', '%' . $q . '%', 'LIKE' )
                ;
        } )
        ->limit($resultCount)
        ->offset($offset)
        ->exec();
    $rs_itoxxth_all = $qs_itoxxth_all->fetchAll();
    // END query options all except self
    
    // BEGIN menggabungkan options
    if(count($rs_itoxxth_self) > 0){
        $rs_opt = array_merge($rs_itoxxth_self, $rs_itoxxth_all);
    }else{
        $rs_opt = $rs_itoxxth_all;
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